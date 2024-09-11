<?php

class Controller
{
    public $layout = 'default';
    private $view;
    public $session;
    public function __construct()
    {
        global $session;
        $this->session = $session;
        $this->view = new View;
    }
    public function render($render = null, $data = [])
    {
        $this->view->controller = preg_replace('/Controller/i', '', get_class($this));
        $this->view->method = debug_backtrace()[1]['function'];
        $this->view->layout = $this->layout;
        return $this->view->render($render, $data);
    }
}
