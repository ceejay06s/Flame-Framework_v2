<?php

class Controller
{
    public $layout = 'default';
    private $view;
    function __construct()
    {
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
