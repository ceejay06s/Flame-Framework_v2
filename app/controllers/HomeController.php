<?php

// use OAuth2;

class HomeController extends Controller
{
    var $user;
    function __construct()
    {
        $test = new System\Config\OAuth2;
        parent::__construct();
        $this->user = new User;
        global $session;
        // $test->authorize();
        var_dump($session->get('csrf_token'));
    }
    public function index()
    {
        $this->render();
    }
}
