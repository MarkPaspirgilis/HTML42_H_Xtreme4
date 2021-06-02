<?php

class PluginUsers {

    public static function init() {
        
    }

    public static function login($user, $password) {
        $db_result = $GLOBALS['XDB']->select_first('xusers', array(
            'username' => $user,
            'password' => Utilities::password($password)
        ));
        if (empty($db_result)) {
            $db_result = null;
        }
        //
        $id = null;
        if ($db_result) {
            $_SESSION['login'] = Utilities::fingerprint();
            $_SESSION['user_id'] = $db_result['id'];
            $id = $_SESSION['user_id'];
        }
        return $id;
    }

    public static function logout() {
        if (isset($_SESSION['login'])) {
            $_SESSION['login'] = null;
            unset($_SESSION['login']);
            if (isset($_SESSION['login'])) {
                $_SESSION['user_id'] = null;
                unset($_SESSION['user_id']);
            }
            return true;
        }
        return false;
    }

    public static function empty_users_db() {
        foreach (array('xusers', 'xuser_xgroup') as $key) {
            if ($GLOBALS['XDB']->engine == 'json') {
                file_put_contents(XDBJson::$dir_tables . $key . '.json', '{}');
                XDBJson::set_meta('table', $key, array(
                    "id" => 0,
                    "amount" => 0,
                    "update_date" => time()
                ));
            }
        }
    }

}

PluginUsers::init();
