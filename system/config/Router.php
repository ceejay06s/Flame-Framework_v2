<?php

use System\Config\Session;

class Router
{
    public $controller;
    public $method;
    public $params;
    public $Session;
    public function __construct()
    {
        $this->Session = new Session;
        $route = $this->getRoute($_SERVER['REQUEST_URI']);
        $url = parse_url($_SERVER['REQUEST_URI']);
        $path = trim($url['path'], '/');
        $params = explode('/', $path);



        if ($route) {
            $this->controller = $route['controller'];
            $this->method = $route['method'];
            $this->params = $route['params'];
        } else {
            $this->controller = isset($params[0]) && file_exists(CONTROLLERS_PATH . '/' . $params[0] . 'Controller.php') ? $params[0] : 'ERROR';
            $this->method = isset($params[1]) && method_exists($this->controller . "Controller", $params[1]) ? $params[1] : 'index';
            $this->params = array_slice($params, 2);
        }

        $this->dispatch();
    }

    private function getRoute($path)
    {
        global $router;
        if (isset($router[$path])) {
            return $router[$path];
        }

        return false;
    }

    private function dispatch()
    {
        if ($this->controller === 'ERROR') {
            $controllerInstance = new ErrorController();
            if (method_exists($controllerInstance, $this->method)) {
                call_user_func_array([$controllerInstance, $this->method], $this->params);
            }
            die();
        } else {
            $controllerClass = ucfirst($this->controller) . (str_contains($this->controller, 'Controller') ? '' : 'Controller');
            $controllerFile = CONTROLLERS_PATH . DS . $controllerClass . '.php';
            if (file_exists($controllerFile)) {
                require_once $controllerFile;

                $controllerInstance = new $controllerClass();

                if (method_exists($controllerInstance, $this->method)) {
                    call_user_func_array([$controllerInstance, $this->method], $this->params);
                } else {
                    // Handle invalid method
                    echo "Method '$this->method' not found in controller '$controllerClass'";
                    header('HTTP/1.1 302 Found');
                }
            } else {
                // Handle invalid controller
                echo "Controller '$controllerClass' not found";
                header('HTTP/1.1 302 Found');
            }
        }
    }
    public function blockAccess($roles = [])
    {
        if (!empty($roles)) {
            $user = $this->Session->get('user');
            if (!isset($user) || !in_array($user->role, $roles)) {
                header('Location: ' . BASE_URL . '/login');
                die();
            }
        }
    }
}
