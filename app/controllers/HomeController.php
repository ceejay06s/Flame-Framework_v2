<?php

// use OAuth2;
use Minishlink\WebPush\VAPID;

class HomeController extends Controller
{
    var $user;
    var $uses = ['user'];
    function __construct()
    {
        parent::__construct();
    }
    public function index()
    {

        $this->render();
    }
}
