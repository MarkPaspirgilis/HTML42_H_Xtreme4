<?php

$plugindir = DIR_X4 . 'plugin_admin/';
if (!isset($GLOBALS['admin_navi'])) {
    $GLOBALS['admin_navi'] = array();
}

$GLOBALS['admin_navi'][BASEURL . 'x4/index'] = 'Overview';
$GLOBALS['admin_navi'][BASEURL . 'x4/pages'] = 'Pages';

include_once $plugindir . 'classes/x4admin.class.php';

