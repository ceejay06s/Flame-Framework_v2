<?php

use System\Config\Encryption;

#[\AllowDynamicProperties]
class Controller
{
    public $layout = 'default';
    private $view;
    public $session;
    public $oauth2;
    public $uses = [];
    public $components = [];
    public $controller;
    public $request;
    public $encrypt;

    public function __construct()
    {
        global $session;
        $this->session = $session;
        $this->request = new System\Config\Request;
        $this->oauth2 = new System\Config\OAuth2;
        $this->view = new View;

        $this->encrypt = new Encryption($_ENV['SESSION_KEY'], $_ENV['SESSION_SALT']);

        foreach ($this->uses as $use) {
            $this->loadModel($use);
        }
    }

    public function render($render = null, $data = [])
    {
        $this->view->controller = preg_replace('/Controller/i', '', get_class($this));
        $this->view->method = debug_backtrace()[1]['function'];
        $this->view->layout = $this->layout;
        return $this->view->render($render, $data);
    }

    public function loadModel($model)
    {
        $model = ucfirst($model);
        $path = APP_PATH . DS . 'models' . DS . $model . '.php';
        if (file_exists($path)) {
            require_once $path;
            $this->{$model} = new $model;
        } else {
            return false;
        }
    }
    public function loadComponents()
    {
        foreach ($this->components as $component) {
            $component = ucfirst($component);
            $path = CONTROLLERS_PATH .  DS . 'components' . DS . $component . '.php';
            if (file_exists($path)) {
                require_once $path;
                $this->controller->{$component} = new $component;
                $this->controller->{$component}->controller = preg_replace('/Controller/i', '', get_class($this));
            } else {
                return false;
            }
        }
    }
}
