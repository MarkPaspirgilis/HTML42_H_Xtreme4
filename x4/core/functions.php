<?php

function __is_value($value) {
    return is_string($value) || is_numeric($value) || is_bool($value) || is_null($value);
}

function __is_string_default_null($config) {
    return isset($config) && is_string($config) ? trim($config) : null;
}

function __files() {
    $files = array();
    if (isset(X4::$config_raw['files']) && is_array(X4::$config_raw['files'])) {
        $files = X4::$config_raw['files'];
    }
    return $files;
}

function __filepathes($files) {
    $filepathes = array();
    foreach ($files as $file) {
        $File_trylist = File::_create_try_list($file);
        $File = File::instance_of_first_existing_file($File_trylist);
        if ($File->exists) {
            array_push($filepathes, $File->path);
        }
    }
    return $filepathes;
}

function __filetimstamp($filepathes) {
    $filetimestamp = 0;
    foreach ($filepathes as $filepath) {
        $t = filemtime($filepath);
        if ($t > $filetimestamp) {
            $filetimestamp = $t;
        }
    }
    return $filetimestamp;
}

function __file_concat($filepathes) {
    $style_content = '';
    foreach ($filepathes as $filepath) {
        $style_content .= file_get_contents($filepath);
    }
    $style_content = trim($style_content);
    return $style_content;
}

function __css_compile($code, $type) {
    if ($type == 'less') {
        $less = new lessc;
        $code = $less->compile($code);
    }
    return $code;
}

function __css_images($code) {
    
}

function __script_compile($code, $type) {
    return $code;
}
