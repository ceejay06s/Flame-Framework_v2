<?php


class Router
{
    public $controller;
    public $method;
    public $params;
    public $session;
    public $router;
    public function __construct()
    {
        global $router, $session;
        $this->session = $session;
        $this->router = $router;
        $this->router['api/oauth/token'] = ['controller' => 'Oauth2Controller', 'method' => 'token', 'action' => 'POST'];
        $this->router['api/oauth/authorize'] = ['controller' => 'Oauth2Controller', 'method' => 'authorize', 'action' => 'ANY'];
        $url = parse_url($_SERVER['REQUEST_URI']);
        $path = trim($url['path'], '/');
        $params = explode('/', $path);
        $url = (empty($params[0])) ? "/" : "/{$params[0]}";
        $url .= (empty($params[1])) ? "" : "/{$params[1]}";
        $route = $this->getRoute($url);
        if ($route) {
            $this->controller = $route['controller'];
            $this->method = $route['method'];
            $this->params = $route['params'] ?? array_slice($params, 2) ?? [];
            if (
                (isset($route['action']) && strtoupper($route['action']) != 'ANY') &&
                (strtoupper($route['action']) != strtoupper($_SERVER['REQUEST_METHOD']))
            ) {
                header('HTTP/1.1 405 Method Not Allowed');
                include_once VIEWS_PATH . DS . "error/405.html";
                die();
            }
        } else {
            $params[1] = $params[1] ?? 'index';
            $this->controller = isset($params[0]) && file_exists(CONTROLLERS_PATH . '/' . $params[0] . 'Controller.php') ? $params[0] : null;
            $this->method = isset($params[1]) && method_exists(ucfirst($this->controller) . "Controller", $params[1]) ? $params[1] : null;
            $this->params = array_slice($params, 2) ?? [];
        }
        $this->dispatch();
    }

    private function getRoute($path)
    {
        $path = strtoupper($path);
        $this->router = array_change_key_case((array)$this->router, MB_CASE_TITLE);

        if (isset($this->router[$path])) {
            return $this->router[$path];
        } elseif (isset($this->router[$path . '/index'])) {
            return $this->router[$path . '/index'];
        }
        return false;
    }

    private function dispatch()
    {


        $controllerClass = ucfirst($this->controller ?? '');
        $controllerClass .= str_contains($controllerClass, "Controller") ? '' : 'Controller';

        $controllerFile = CONTROLLERS_PATH . DS . $controllerClass . '.php';
        if (!file_exists($controllerFile)) {
            $controllerFile = SYSTEM_CONTROLLERS_PATH . DS . $controllerClass . '.php';
        }
        if (file_exists($controllerFile)) {
            require_once $controllerFile;


            $controllerInstance = new $controllerClass();

            if ($this->method && method_exists($controllerInstance, $this->method)) {
                call_user_func_array([$controllerInstance, $this->method ?? 'index'], $this->params ?? []);
            } else {
                // Handle invalid method
                // echo "Method '$this->method' not found in controller '$controllerClass'";
                ob_clean();
                header('HTTP/1.1 302 Found');
                include_once VIEWS_PATH . DS . "error/302.html";
                die;
            }
        } else {
            // Handle invalid controller
            // echo "Controller '$controllerClass' not found";
            ob_clean();
            header('HTTP/1.1 302 Found');
            include_once VIEWS_PATH . DS . "error/302.html";
            die;
        }
    }

    public function blockAccess($roles = [])
    {
        if (!empty($roles)) {
            $user = $this->session->get('user');
            if (!isset($user) || !in_array($user->role, $roles)) {
                header('Location: ' . BASE_URL . '/login');
                die();
            }
        }
    }
}
