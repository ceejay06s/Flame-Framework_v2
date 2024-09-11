<?php

namespace System\Config;

use \System\Config\Encryption;

class Session
{
    private $session;
    private $path;
    private $encrypt;
    public $csrf_token;
    public function __construct()
    {
        session_name(getenv('SESSION_NAME'));

        $this->session = new \Model;
        $this->session->table = 'sessions';
        $this->path = APP_PATH . DS . "tmp/sessions";
        $this->path = !empty(getenv('SESSION_PATH')) ? getenv('SESSION_PATH') : $this->path;
        session_save_path($this->path);


        in_array($_ENV['SECURITY_HASH'], hash_hmac_algos()) ? $_ENV['SECURITY_HASH'] : 'MD5';
        $this->encrypt = new Encryption($_ENV['SESSION_KEY'], $_ENV['SESSION_SALT'], $_ENV['SECURITY_HASH']);

        session_set_save_handler(
            function ($save_path, $session_name) {
                return true;
            },
            function () {
                return true;
            },
            function ($session_id) {
                if (getenv('SESSION_DRIVER') == 'database') {
                    $sessionData = $this->session->select($this->session->table, '*', "session_id = '$session_id'");
                    $session_data =  $sessionData ? unserialize($this->encrypt->decrypt($sessionData[0]['data'])) : '';
                } elseif (getenv('SESSION_DRIVER') == 'file') {
                    $session_data = file_exists(session_save_path() . '/' . $session_id) ? unserialize($this->encrypt->decrypt(file_get_contents(session_save_path() . '/' . $session_id))) : '';
                }
                /*  $resd = array_map(function ($item) {
                    if ($item !== '') {
                        list($key, $value) = explode('|', $item);
                        if (!$this->encrypt->isHex($key))
                            $key = $this->encrypt->toHex($key);

                        $ven = $key . "|" . $value;
                        return $ven;
                    }
                }, explode(';', $session_data));
                $session_data = implode(';', $resd); */
                return $session_data;
            },
            function ($session_id, $session_data) {
                $resd = array_map(function ($item) {
                    if ($item !== '') {
                        list($key, $value) = explode('|', $item);
                        if (!$this->encrypt->isHex($key)) {
                            unset($_SESSION[$key]);
                            $key = $this->encrypt->toHex($key);
                        }
                        return $key . "|" . $value;
                    }
                }, explode(';', $session_data));
                $session_data = implode(';', $resd);

                $enc = $this->encrypt->encrypt(serialize($session_data));
                $sessionData = [
                    'session_id' => $session_id,
                    'user_id' => isset($_SESSION['user']) ? $_SESSION['user']->id : null,
                    'data' => $enc,
                ];
                if ($_ENV['SESSION_DRIVER'] == 'database') {
                    $ret = $this->session->select($this->session->table, '*', "session_id = '$session_id'");
                    if ($ret) {
                        $ret = $this->session->update($this->session->table, $sessionData, "session_id = '$session_id'");
                    } else {
                        $ret = $this->session->insert($this->session->table, $sessionData);
                    }
                    return ($ret) ? true : false;
                } elseif ($_ENV['SESSION_DRIVER'] == 'file') {
                    $ret = file_put_contents(session_save_path() . '/' . $session_id, $enc);
                    return ($ret) ? true : false;
                }
            },
            function ($session_id) {
                $this->session = new \Model;
                $this->session->table = 'sessions';
                if (getenv('SESSION_DRIVER') == 'database') {
                    return $this->session->delete('sessions', "session_id = '$session_id'");
                } elseif (getenv('SESSION_DRIVER') == 'file') {
                    return unlink(session_save_path() . '/' . $session_id);
                }
            },
            function ($maxlifetime) {
                $maxlifetime;
                return true;
            }
        );
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
            if (is_null($this->get('csrf_token')) && is_null($this->csrf_token)) {
                $this->csrf_token = md5(uniqid(mt_rand(32, 40)));
                $this->set('csrf_token', $this->csrf_token);
            } elseif (is_null($this->get('csrf_token')) && !is_null($this->csrf_token)) {
                $this->set('csrf_token', $this->csrf_token);
            } else {
                $this->csrf_token = $this->get('csrf_token');
            }
        }
    }

    public function set($key, $value)
    {
        $hexKey = $this->encrypt->toHex($key);
        $_SESSION["{$hexKey}"] = $value;
    }

    public function get($key)
    {
        $hexKey = $this->encrypt->toHex($key);
        return $_SESSION[$key] ?? ($_SESSION["{$hexKey}"] ?? null);
    }

    public function delete($key)
    {
        $key = $this->encrypt->tohex($key);
        unset($_SESSION[$key]);
    }

    public function destroy()
    {

        session_destroy();
    }
}
