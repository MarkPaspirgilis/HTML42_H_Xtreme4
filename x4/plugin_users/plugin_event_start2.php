<?php

//
if (isset($_SESSION['login']) && $_SESSION['login'] == Utilities::fingerprint() && $_SESSION['user_id']) {
    $GLOBALS['me'] = new XtremeUser($_SESSION['user_id']);
} else {
    $GLOBALS['me'] = null;
}
