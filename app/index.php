<?php
define('BASE_URL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . str_replace('/index.php', '', $_SERVER['PHP_SELF']));

define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('SYSTEM', ROOT_PATH . '/system');
define('CONFIG_PATH', APP_PATH . '/config');
define('DATABASE_PATH', CONFIG_PATH . '/database.php');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('VIEWS_PATH', APP_PATH . '/views');
define('CONTROLLERS_PATH', APP_PATH . '/controllers');
define('MODELS_PATH', APP_PATH . '/models');
define('ASSETS_PATH', PUBLIC_PATH . '/assets');
define('UPLOADS_PATH', PUBLIC_PATH . '/uploads');
require_once ROOT_PATH . DS . 'vendor' . DS . 'autoload.php';
require_once CONFIG_PATH . DS . 'router.php';


spl_autoload_register(function ($class) {
    $file = str_replace('\\', DS, $class) . '.php';
    if (file_exists(CONTROLLERS_PATH . DS . $file)) {
        require_once CONTROLLERS_PATH . DS . $file;
    }

    if (file_exists(SYSTEM . DS . 'config/' . $file)) {
        require_once SYSTEM . DS . 'config/' . $file;
    }
    if (file_exists(SYSTEM . DS . 'database/' . $file)) {
        require_once SYSTEM . DS . 'database/' . "System\Databases\\" . $file;
    }
    if (file_exists(MODELS_PATH . DS . $file)) {
        require_once MODELS_PATH . DS . $file;
    }

    if (file_exists(SYSTEM . DS . $file)) {
        require_once SYSTEM . DS . $file;
    }
});

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(ROOT_PATH);
$dotenv->load();
foreach ($_ENV as $key => $value) {
    putenv("$key=$value");
}
$router = new Router;
// $Router = new Router();
