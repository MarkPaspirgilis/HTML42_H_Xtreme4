<?php

$dir = str_replace(DIRECTORY_SEPARATOR, '/', __DIR__) . '/';

include $dir . 'variables.php';
include DIR_CORE . 'functions.php';
include DIR_CORE_CLASSES . 'utilities.class.php';
include DIR_CORE_CLASSES . 'request.class.php';
include DIR_CORE_CLASSES . 'response.class.php';
include DIR_CORE_CLASSES . 'file.class.php';
include DIR_CORE_CLASSES . 'cache.class.php';

include DIR_CORE_CLASSES . 'x4.class.php';
include DIR_CORE_CLASSES . 'controller.class.php';
include DIR_CORE_CLASSES . 'view.class.php';

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
    default:
        include DIR_CORE_MODES . 'default.php';
}

Response::deliver(X4::$content);
