<?php

$mimetype = mime_content_type(Request::$requested_clean_path);
$File_image = File::instance(Request::$requested_clean_path);

X4::$mime = 'image/error';
X4::$content = '404 - Image not found';

if ($File_image->exists) {
    X4::$content = $File_image->get_content();
    X4::$mime = $mimetype;
}

