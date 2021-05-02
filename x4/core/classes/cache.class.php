<?php

class Cache {
    
    public static $dir = '_cache';
    
    public static function init() {
        self::$dir = DIR_ROOT . '_cache/';
        if(!is_dir(self::$dir)) {
            @mkdir(self::$dir);
        }
    }

    public static function file($key, $value) {
        
    }

}

Cache::init();
