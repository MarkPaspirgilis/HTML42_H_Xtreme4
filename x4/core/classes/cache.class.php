<?php

class Cache {
    
    public static $dir = '_cache';
    public static $curl_ttl = 60 * 5;#5 Minutes
    
    public static function init() {
        self::$dir = DIR_ROOT . '_cache/';
        if(!is_dir(self::$dir)) {
            @mkdir(self::$dir);
        }
    }

    public static function file($key, $value) {
        
    }
    
    public static function curl($url, $ttl = null) {
        if(!is_numeric($ttl)) {
            $ttl = self::$curl_ttl;
        }
        $ttl = @intval($ttl);
        $fetch_new = $ttl <= 0;
        #
        $url_cache_file_name = md5('url' . $url) . '.urlcache';
        $dir_urls = self::$dir . 'urls/';
        if(!is_dir($dir_urls)) {
            @mkdir($dir_urls);
        }
        $url_cache_file_path = $dir_urls . $url_cache_file_name;
        #
        $last_time = is_file($url_cache_file_path) ? filemtime($url_cache_file_path) : -1;
        $accepted_time = time() - $ttl;
        if(!$fetch_new && $last_time < $accepted_time) {
            $fetch_new = true;
        }
        #
        if($fetch_new) {
            $content = Curl::get($url);
        } else {
            $content = file_get_contents($url_cache_file_path);
        }
        file_put_contents($url_cache_file_path, $content);
        #
        return $content;
    }

}

Cache::init();
