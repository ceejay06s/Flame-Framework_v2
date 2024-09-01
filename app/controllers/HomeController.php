<?php

class HomeController extends Controller
{
    var $user;
    function __construct()
    {
        parent::__construct();
        $this->user = new User;
        // $results = $this->user->query("select * from users")->first();
        var_dump($this->user->fields);
    }
    public function index()
    {
        $this->render();
    }
}
