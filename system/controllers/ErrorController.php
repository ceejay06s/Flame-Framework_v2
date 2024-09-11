<?php

class ErrorController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->render('error/404');
    }

    public function error404()
    {
        $this->render('error/404');
    }

    public function error500()
    {
        $this->render('error/500');
    }
}
