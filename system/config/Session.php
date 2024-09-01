<?php


namespace System\Config;

use \Logs;
use SessionHandler;
use \System\Config\Encryption;

class Session
{
    private $session;
    public function __construct()
    {
        session_name(getenv('SESSION_NAME'));
        $this->session = new \Model;
        $this->session->table = 'sessions';

        if (getenv('SESSION_DRIVER') == 'database') {
            $this->session->table = 'sessions';
        } else if (getenv('SESSION_DRIVER') == 'file') {
            session_save_path(getenv('SESSION_PATH') ?? APP_PATH . DS . 'tmp/sessions');
        }
        session_set_save_handler(
            function ($save_path, $session_name) {
                return true;
            },
            function () {
                return true;
            },
            function ($session_id) {
                $encrypt = new Encryption($_ENV['SESSION_KEY'], $_ENV['SESSION_SALT']);
                if (getenv('SESSION_DRIVER') == 'database') {
                    $sessionData = $this->session->select($this->session->table, '*', "session_id = '$session_id'");
                    return $sessionData ? unserialize($encrypt->decrypt($sessionData[0]['data'])) : '';
                } else if (getenv('SESSION_DRIVER') == 'file') {
                    return file_exists(session_save_path() . '/' . $session_id) ? unserialize($encrypt->decrypt(file_get_contents(session_save_path() . '/' . $session_id))) : '';
                }
            },
            function ($session_id, $session_data) {
                $encrypt = new Encryption($_ENV['SESSION_KEY'], $_ENV['SESSION_SALT']);
                $enc = $encrypt->encrypt(serialize($session_data));
                // var_dump($encrypt->toHex($enc), $encrypt->toBin($encrypt->toHex($enc)));
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
                    $path = $_ENV['SESSION_PATH'] ?? APP_PATH . DS . "tmp/sessions";
                    $ret = file_put_contents(session_save_path($path) . '/' . $session_id, $enc);
                    return $ret;
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
        //}

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // $this->set('init', true);
        // var_dump($_SESSION);
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
