<?php

ini_set('short_open_tag', 1);
ini_set('magic_quotes_gpc', 1);
ini_set("memory_limit", "512M");

@session_start();

//CLI-Special
foreach (array(
'REQUEST_URI' => '',
 'HTTPS' => 'off',
 'SERVER_PORT' => 0,
 'SERVER_NAME' => 'localhost',
) as $_SERVER_KEY => $_SERVER_VALUE) {
    if (!isset($_SERVER[$_SERVER_KEY])) {
        $_SERVER[$_SERVER_KEY] = $_SERVER_VALUE;
    }
}
define('IS_CLI', ($_SERVER['REQUEST_URI'] === '' && $_SERVER['SERVER_NAME'] === 'localhost' && $_SERVER['SERVER_PORT'] === 0));

include $dir . 'variables.php';
include DIR_CORE . 'functions.php';
include DIR_CORE_CLASSES . 'utilities.class.php';
include DIR_CORE_CLASSES . 'request.class.php';
include DIR_CORE_CLASSES . 'response.class.php';
include DIR_CORE_CLASSES . 'file.class.php';
include DIR_CORE_CLASSES . 'cache.class.php';
include DIR_CORE_CLASSES . 'html.class.php';
include DIR_CORE_CLASSES . 'curl.class.php';
include DIR_CORE_CLASSES . 'texts.class.php';

$dir = str_replace(DIRECTORY_SEPARATOR, '/', __DIR__) . '/';

include $dir . 'variables.php';

define('BASEURL', 'http' . (is_https() ? 's' : '') . '://' . $_SERVER['SERVER_NAME'] . '/' . Request::$url_path_to_script);

$GLOBALS['ASSET_PREFIX'] = '';
for ($i = 0; $i < count(Request::$requested_clean_path_array) - 1; $i++) {
    $GLOBALS['ASSET_PREFIX'] .= '../';
}
define('ASSET_PREFIX', $GLOBALS['ASSET_PREFIX']);

//Project Includes
if (is_dir(DIR_CLASSES . 'classes')) {
    foreach (File::ls(DIR_CLASSES . 'classes', true, true) as $class_file) {
        if (strstr($class_file, '.class.php')) {
            include_once $class_file;
        }
    }
}
