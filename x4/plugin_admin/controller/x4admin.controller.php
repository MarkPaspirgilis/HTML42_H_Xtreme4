<?php

class X4AdminController extends Controller {

    public function __construct() {
        if (!$_SESSION['adminlogin']) {
            $password = is_file(DIR_ROOT . 'adminpw') ? file_get_contents(DIR_ROOT . 'adminpw') : '1234';
            if (isset($_POST['password']) && $_POST['password'] == $password) {
                $_SESSION['adminlogin'] = true;
            } else {
                echo File::i('templates/login.php')->get_content();
                die;
            }
        }
    }

    public static function view_pages() {

        include DIR_X4 . 'plugin_admin/classes/x4pages.class.php';
    }

}

if (!isset($_SESSION['adminlogin'])) {
    $_SESSION['adminlogin'] = false;
}
