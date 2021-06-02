<?php

$plugindir = DIR_X4 . 'plugin_database/';
define('XDBCLASSES', $plugindir . 'classes/');

include_once $plugindir . 'classes/xtreme_database.class.php';

//DATABASE CONFIGURATION
$File_dbconfig = File::instance(DIR_ROOT . 'db_config.json');
if (!$File_dbconfig->exists) {
    file_put_contents($File_dbconfig->path, '{"engine":"json"}');
    $File_dbconfig = new File($File_dbconfig->path);
}
XDB::$config_raw = $File_dbconfig->get_json();

//DATABASE TABLES
$File_dbstructure = File::instance(DIR_ROOT . 'dbstructure.php');
if (!$File_dbstructure->exists) {
    $default_structure = file_put_contents($File_dbstructure->path, __content_db_file_structure__());
}
include_once $File_dbstructure->path;

//DATABASE VALIDATIONS
$File_dbvalidations = File::instance(DIR_ROOT . 'dbvalidations.php');
if (!$File_dbvalidations->exists) {
    file_put_contents($File_dbvalidations->path, __content_db_file_validations__());
}
include_once $File_dbvalidations->path;

/**
 * @global XDB $GLOBALS['XDB']
 * @name $XDB 
 */
$GLOBALS['XDB'] = $XDB = new XDB();

function __content_db_file_structure__() {
    return "<?php \$GLOBALS['XDB_STRUCTURE'] = array();";
}

function __content_db_file_validations__() {
    return "<?php \$GLOBALS['XDB_VALIDATIONS'] = array();";
}
