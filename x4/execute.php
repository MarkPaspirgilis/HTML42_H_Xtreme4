<?php

ini_set('short_open_tag', 1);
ini_set('magic_quotes_gpc', 1);
ini_set("memory_limit", "512M");

@session_start();

$dir = str_replace(DIRECTORY_SEPARATOR, '/', __DIR__) . '/';

include $dir . 'variables.php';
include DIR_CORE . 'functions.php';
include DIR_CORE_CLASSES . 'utilities.class.php';
include DIR_CORE_CLASSES . 'request.class.php';
include DIR_CORE_CLASSES . 'response.class.php';
include DIR_CORE_CLASSES . 'file.class.php';
include DIR_CORE_CLASSES . 'cache.class.php';
include DIR_CORE_CLASSES . 'html.class.php';
include DIR_CORE_CLASSES . 'curl.class.php';

include DIR_CORE_CLASSES . 'xtreme_gallery.class.php';

include DIR_CORE_CLASSES . 'x4.class.php';
include DIR_CORE_CLASSES . 'controller.class.php';
include DIR_CORE_CLASSES . 'view.class.php';

define('BASEURL', 'http' . (is_https() ? 's' : '') . '://' . $_SERVER['SERVER_NAME'] . '/' . Request::$url_path_to_script);

//Project Includes
if (is_dir(DIR_ROOT . 'classes')) {
    foreach (File::ls(DIR_ROOT . 'classes', true, true) as $class_file) {
        if (strstr($class_file, '.class.php')) {
            include_once $class_file;
        }
    }
}
if (is_dir(DIR_ROOT . 'functions')) {
    foreach (File::ls(DIR_ROOT . 'functions', true, true) as $php_file) {
        if (strstr($php_file, '.php')) {
            include_once $php_file;
        }
    }
}

X4::load();
X4::plugins_load();

#Handle/Load Controller
$File_controller_trylist = File::_create_try_list(strtolower(X4::$config['app']['controller']), array('.controller.php'), array('controller/'));
$File_controller = File::instance_of_first_existing_file($File_controller_trylist);
if ($File_controller->exists) {
    include $File_controller->path;
    $controller_name = X4::$config['app']['controller'] . 'Controller';
    $Controller = new $controller_name;
    $view_name = 'view_' . X4::$config['app']['view'];
    if (method_exists($Controller, $view_name)) {
        $Controller::$view_name();
    }
}

#Handle Redirect
if (is_string(X4::$config['redirect']) && !empty(X4::$config['redirect'])) {
    Utilities::redirect(X4::$config['redirect'], X4::$config['status']);
    die;
}

#Handle Request
switch (X4::$config['type']) {
    case 'html':
        include DIR_CORE_MODES . 'html.php';
        break;
    case 'css':
    case 'less':
    case 'scss':
    case 'sass':
    case 'style':
        include DIR_CORE_MODES . 'styles.php';
        break;
    case 'js':
    case 'javascript':
    case 'script':
    case 'coffee':
    case 'coffeescript':
        include DIR_CORE_MODES . 'script.php';
        break;
    case 'image':
    case 'images':
    case 'jpg':
    case 'png':
    case 'gif':
        include DIR_CORE_MODES . 'image.php';
        break;
    default:
        $File_mode = File::instance('modes/' . X4::$config['type'] . '.php');
        if ($File_mode->exists) {
            include $File_mode->path;
        } else {
            include DIR_CORE_MODES . 'default.php';
        }
}

Response::deliver(X4::$content);
