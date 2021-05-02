<?php

class Texts {
    
    public static $texts = array();
    public static $translations = array();
    
    public static $filepath_texts = 'texts.ini';
    public static $filepath_translations = 'translations.ini';
    
    public static function init() {
        self::$texts = File::instance(self::$filepath_texts)->get_content();
        self::$texts = parse_ini_string(self::$texts);
        self::$translations = File::instance(self::$filepath_translations)->get_content();
        self::$translations = parse_ini_string(self::$translations);
    }
    
    public static function get($keys) {
        $match = null;
    }
    
    public static function text($keys) {
        
    }
    
    public static function translation($keys) {
        
    }
    
}

Texts::init();


