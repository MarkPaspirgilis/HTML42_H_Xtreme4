<?php

$plugindir = DIR_X4 . 'plugin_game_engine/';
$plugindir_classes = $plugindir . 'classes/';

define('DIR_GAMING', DIR_ROOT . '_game_engine/');
define('DIR_GAMING_CONFIG', DIR_GAMING . 'config/');
define('DIR_GAMING_USERS', DIR_GAMING . 'users/');
define('FILE_GAMING_UNITS', DIR_GAMING_CONFIG . 'units.json');
define('FILE_GAMING_STRUCTURES', DIR_GAMING_CONFIG . 'structures.json');
define('FILE_GAMING_AREAS', DIR_GAMING_CONFIG . 'areas.json');

if (isset($GLOBALS['admin_navi'])) {
    $GLOBALS['admin_navi']['gaming'] = 'Gaming';
}

include $plugindir_classes . 'gaming_area.class.php';
include $plugindir_classes . 'gaming_structure.class.php';
include $plugindir_classes . 'gaming_unit.class.php';
include $plugindir_classes . 'gaming_user.class.php';
include $plugindir_classes . 'gaming_core.class.php';

if(!is_dir(DIR_GAMING)) {
    @mkdir(DIR_GAMING);
}
if(!is_dir(DIR_GAMING_CONFIG)) {
    @mkdir(DIR_GAMING_CONFIG);
}
if(!is_dir(DIR_GAMING_USERS)) {
    @mkdir(DIR_GAMING_USERS);
}

//

GamingCore::$areas = File::instance(FILE_GAMING_AREAS)->get_json();
GamingCore::$structures = File::instance(FILE_GAMING_STRUCTURES)->get_json();
GamingCore::$units = File::instance(FILE_GAMING_UNITS)->get_json();
