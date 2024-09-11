<?php
class View
{
    public $layout = 'default';
    public $controller;
    public $method;

    public function render($view = null, $data = [], $return = false)
    {
        extract($data);
        ob_start();
        if (empty($view)) {
            $view = $this->controller . DS . $this->method;
        }
        $filename = VIEWS_PATH . DS . $view . '.view';
        if (!file_exists($filename)) {
            $filename = VIEWS_PATH . DS . $view . '.blade.php';
        }
        if (!file_exists($filename)) {
            $filename = VIEWS_PATH . DS . $view . '.php';
        }
        if (!file_exists($filename)) {
            $filename = VIEWS_PATH . DS . $view . '.html';
        }
        if (file_exists($filename)) {
            require_once $filename;
        } else {
            echo "View '$view' not found";
        }
        $content = ob_get_clean();
        if ($this->layout)
            if ($return) {
                return $this->renderLayout($content);
            } else {
                print $this->renderLayout($content);
            }
        else {
            if ($return) {
                return $content;
            } else {
                print $content;
            }
        }
    }

    public function renderLayout($content_for_layout)
    {
        ob_start();
        require_once VIEWS_PATH . DS . 'layouts' . DS . $this->layout . '.layout';
        $layoutContent = ob_get_clean();
        return str_replace('{{content_for_layout}}', $content_for_layout, $layoutContent);
    }
}
