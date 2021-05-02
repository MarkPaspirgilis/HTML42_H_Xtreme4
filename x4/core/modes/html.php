<?php

if(X4::$config['File'] && X4::$config['File']->exists) {
    echo X4::$config['File']->get_content();
    die;
}
$view_filepath = 'views/' . strtolower(X4::$config['app']['controller']) . '/' . strtolower(X4::$config['app']['view']);
$view_filepath_trylist = File::_create_try_list($view_filepath, array('html', 'php'));
$File_view = File::instance_of_first_existing_file($view_filepath_trylist);

$website_content = '404 - File not found';
if($File_view->exists) {
    $website_content = $File_view->get_content();
}
$website_base = X4::$config['Base'] ? X4::$config['Base']->get_content() : '';

X4::$content = str_replace('#yield#', $website_content, $website_base);

