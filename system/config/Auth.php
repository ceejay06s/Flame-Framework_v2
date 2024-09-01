<?php

namespace System\Config;

use System\Databases\Database;

class Auth
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function login($username, $password)
    {
        $user = $this->db->select('users', '*', "username = '$username' AND password = '$password'");
        if ($user->first()) {
            $_SESSION['user'] = $user->first();
            return true;
        }
        return false;
    }
    public function logout()
    {
        session_destroy();
    }
    public function isLoggedIn()
    {
        return isset($_SESSION['user']);
    }
}
