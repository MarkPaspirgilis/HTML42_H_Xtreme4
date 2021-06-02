<?php

$plugindir = DIR_X4 . 'plugin_users/';

include_once $plugindir . 'classes/plugin_users.class.php';
include_once $plugindir . 'classes/xtreme_user.class.php';

//Database-Structure
if (!isset($GLOBALS['XDB_STRUCTURE'])) {
    debug('ERROR: XDB_STRUCTURE not available');
} else {
    $GLOBALS['XDB_STRUCTURE']['xusers'] = array(
        'username' => '',
        'password' => '',
        'hash' => function($data) {
            $email = (isset($data['email']) ? $data['email'] : 'no-email');
            return strtoupper(md5($data['id'] . '||' . $email));
        },
        'email' => '',
        'email_validated' => null,
    );
    $GLOBALS['XDB_STRUCTURE']['xuser_xgroup'] = array('user_id' => '', 'name' => '');
}

if (!isset($GLOBALS['XDB_VALIDATIONS'])) {
    debug('ERROR: XDB_VALIDATIONS not available');
} else {
    $GLOBALS['XDB_VALIDATIONS']['xusers'] = array(
        'groups' => array('id' => array('xuser_xgroup', 'user_id')),
    );
}
