<?php

$type = 'less';
if (isset(X4::$config_raw['type']) && is_string(X4::$config_raw['type']) && !empty(X4::$config_raw['type'])) {
    $type = trim(strtolower(X4::$config_raw['type']));
}

$filepathes = __filepathes(__files());
$filetimestamp = __filetimstamp($filepathes);
$cache_filename = 'style_' . md5(implode($filepathes)) . '_' . $filetimestamp . '.css';
$assets_cachedir = Cache::$dir . 'assets/';
if(!is_dir($assets_cachedir)) {
    @mkdir($assets_cachedir);
}
$cache_filepath = $assets_cachedir . $cache_filename;
$File = File::instance($cache_filepath);
if (!$File->exists) {
    $style_content_raw = __file_concat($filepathes);
    $style_content = __css_compile($style_content_raw, $type);
    file_put_contents($File->path, $style_content);
} else {
    $style_content = $style_content_raw = $File->get_content();
}

X4::$content = $style_content;
X4::$mime = 'text/css';
