<?php

$type = 'javascript';
if (isset(X4::$config_raw['type']) && is_string(X4::$config_raw['type']) && !empty(X4::$config_raw['type'])) {
    $type = trim(strtolower(X4::$config_raw['type']));
}

switch ($type) {
    case 'js':
        $type = 'javascript';
        break;
}

$filepathes = __filepathes(__files());
$filetimestamp = __filetimstamp($filepathes);
$cache_filename = 'script_' . md5(implode($filepathes)) . '_' . $filetimestamp . '.js';
$assets_cachedir = Cache::$dir . 'assets/';
if(!is_dir($assets_cachedir)) {
    @mkdir($assets_cachedir);
}
$cache_filepath = $assets_cachedir . $cache_filename;
$File = File::instance($cache_filepath);
if (!$File->exists) {
    $script_content_raw = __file_concat($filepathes);
    $script_content = __script_compile($script_content_raw, $type);
    file_put_contents($File->path, $script_content);
} else {
    $script_content = $script_content_raw = $File->get_content();
}

X4::$content = $script_content;
X4::$mime = 'text/javascript';
