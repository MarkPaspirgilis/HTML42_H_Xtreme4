<?php

class CitypluginCore {
    
    public static $internal = null;
    public static $internal_dir = null;
    public static $external_url = 'https://www.thecity.net/api/';
    public static $config = array();
    
    public static $key = null;
    public static $secret = null;

    public static function init() {
        foreach(array(
            DIR_ROOT . '../../the-city',
            DIR_ROOT . '../../thecity',
            DIR_ROOT . '../the-city',
            DIR_ROOT . '../thecity',
        ) as $try_dir) {
            if(is_dir($try_dir)) {
                $try_dir = File::n($try_dir);
                if(is_file($try_dir . 'city.dir')) {
                    self::$internal_dir = $try_dir;
                    self::$internal = true;
                    break;
                }
            }
        }
        //
        $File_website_json = File::instance('website.json');
        if($File_website_json->exists) {
            self::$config = $File_website_json->get_json();
        }
        //
        if(isset(self::$config['secret'])) {
            self::$secret = self::$config['secret'];
        }
        self::$key = end(Request::$requested_clean_path_array);
    }

}

CitypluginCore::init();
