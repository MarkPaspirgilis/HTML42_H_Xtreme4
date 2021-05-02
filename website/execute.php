<?php

$X4 = get_cfg_var('X4');
if (!is_string($X4) || empty($X4))
    $X4 = ini_get('X4');
if (!is_string($X4) || empty($X4))
    $X4 = null;
if (is_string($X4) && !empty($X4)) {
    $X4 = str_replace('\\', '/', trim($X4));
    if (substr($X4, -1) != '/')
        $X4 .= '/';
}
#
if (is_dir($X4) && is_file($X4 . 'execute.php') && is_file($X4 . 'version')) {
    include $X4.'execute.php';
} else {
    echo '500 - X4 not found';
    die;
}
