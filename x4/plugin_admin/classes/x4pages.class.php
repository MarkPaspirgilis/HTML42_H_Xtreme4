<?php

class X4Pages {

    public static $CACHE = array();

    public static function loop_pages_structure() {
        $pages = array();
        foreach (X4::$structure as $path => $config) {
            $pages[$path] = $config;
        }
        return $pages;
    }

}
