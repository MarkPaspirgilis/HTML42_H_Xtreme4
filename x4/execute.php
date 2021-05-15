<?php

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

include DIR_CORE_CLASSES . 'x4.class.php';
include DIR_CORE_CLASSES . 'controller.class.php';
include DIR_CORE_CLASSES . 'view.class.php';

define('BASEURL', 'http' . (is_https() ? 's' : '') . '://' . $_SERVER['SERVER_NAME'] . '/' . Request::$url_path_to_script);

//Project Includes
if(is_dir(DIR_ROOT . 'classes')) {
    foreach(File::ls(DIR_ROOT . 'classes', true, true) as $class_file) {
        if(strstr($class_file, '.class.php')) {
            include_once $class_file;
        }
    }
}
if(is_dir(DIR_ROOT . 'functions')) {
    foreach(File::ls(DIR_ROOT . 'functions', true, true) as $php_file) {
        if(strstr($php_file, '.php')) {
            include_once $php_file;
        }
    }
}

X4::load();
X4::plugins_load();

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
        include DIR_CORE_MODES . 'default.php';
}

Response::deliver(X4::$content);
