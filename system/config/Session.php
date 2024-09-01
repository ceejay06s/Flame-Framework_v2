<?php


namespace System\Config;

use \System\Config\Encryption;

class Session
{
    private $session;
    private $path;
    public function __construct()
    {
        session_name(getenv('SESSION_NAME'));

        $this->session = new \Model;
        $this->session->table = 'sessions';
        $this->path = APP_PATH . DS . "tmp/sessions";
        $this->path = !empty(getenv('SESSION_PATH')) ? getenv('SESSION_PATH') : $this->path;
        session_save_path($this->path);
        session_set_save_handler(
            function ($save_path, $session_name) {
                var_dump($save_path, $session_name);
                return true;
            },
            function () {
                return true;
            },
            function ($session_id) {
                in_array($_ENV['SECURITY_HASH'], hash_hmac_algos()) ? $_ENV['SECURITY_HASH'] : 'MD5';
                $encrypt = new Encryption($_ENV['SESSION_KEY'], $_ENV['SESSION_SALT'], $_ENV['SECURITY_HASH']);
                if (getenv('SESSION_DRIVER') == 'database') {
                    $sessionData = $this->session->select($this->session->table, '*', "session_id = '$session_id'");
                    return $sessionData ? unserialize($encrypt->decrypt($sessionData[0]['data'])) : '';
                } elseif (getenv('SESSION_DRIVER') == 'file') {
                    var_dump(session_save_path());
                    $res = file_exists(session_save_path() . '/' . $session_id) ? unserialize($encrypt->decrypt(file_get_contents(session_save_path() . '/' . $session_id))) : '';
                    var_dump($res);
                    return $res;
                }
            },
            function ($session_id, $session_data) {
                in_array($_ENV['SECURITY_HASH'], hash_hmac_algos()) ? $_ENV['SECURITY_HASH'] : 'MD5';
                $encrypt = new Encryption($_ENV['SESSION_KEY'], $_ENV['SESSION_SALT'], $_ENV['SECURITY_HASH']);
                $enc = $encrypt->encrypt(serialize($session_data));
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
                }

                if ($_ENV['SESSION_DRIVER'] == 'file') {

                    $ret = file_put_contents(session_save_path() . '/' . $session_id, $enc);
                    return ($ret) ? true : false;
                }
            },
            function ($session_id) {
                $this->session = new \Model;
                $this->session->table = 'sessions';
                if (getenv('SESSION_DRIVER') == 'database') {
                    return $this->session->delete('sessions', "session_id = '$session_id'");
                } else if (getenv('SESSION_DRIVER') == 'file') {
                    return unlink(session_save_path() . '/' . $session_id);
                }
            },
            function ($maxlifetime) {
                return true;
            }
        );

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public function delete($key)
    {
        unset($_SESSION[$key]);
    }

    public function destroy()
    {

        session_destroy();
    }
}
