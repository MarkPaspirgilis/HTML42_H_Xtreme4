<?php

class X4 {

    public static $structure = array();
    public static $config = array(
        'redirect' => null,
        'type' => 'html',
        'mime' => 'text/html',
        'encoding' => 'UTF-8',
        'status' => 200,
        'filepath' => null,
        'File' => null,
        'base' => 'templates/base',
        'Base' => null,
        'app' => array(
            'controller' => 'index',
            'view' => 'index',
            'area' => 'index',
        )
    );
    public static $config_raw = array();
    public static $plugins = array();
    public static $content = '404 - Not found';
    public static $mime = 'text/html';

    public static function init() {
        $File_structure = File::instance(FILE_STRUCTURE);
        if ($File_structure->exists) {
            self::$structure = $File_structure->get_json();
        }
        self::plugins_init();
        foreach (self::$plugins as $plugin_config) {
            if (isset($plugin_config['structure']) && is_array($plugin_config['structure'])) {
                foreach ($plugin_config['structure'] as $path => $config) {
                    if (!isset(self::$structure[$path])) {
                        self::$structure[$path] = $config;
                    }
                }
            }
        }
    }

    public static function load() {
        if (isset(self::$structure[Request::$requested_clean_path])) {
            self::$config_raw = self::$structure[Request::$requested_clean_path];
            foreach (self::$config as $c_key => $c_value) {
                if (isset(self::$config_raw[$c_key]) && __is_value(self::$config_raw[$c_key])) {
                    self::$config[$c_key] = self::$config_raw[$c_key];
                }
            }
            foreach (array('controller', 'view', 'area') as $_k) {
                if (isset(self::$config_raw[$_k])) {
                    self::$config['app'][$_k] = self::$config_raw[$_k];
                }
            }
            if (isset(self::$config_raw['filepath']) && is_string(self::$config_raw['filepath']) && !empty(self::$config_raw['filepath'])) {
                $File_trylist = File::_create_try_list(self::$config_raw['filepath'], array('html', 'php', 'tpl'));
                $File = File::instance_of_first_existing_file($File_trylist);
                if ($File->exists) {
                    self::$config['filepath'] = $File->path;
                    self::$config['File'] = $File;
                }
            }
            if (isset(self::$config['base']) && is_string(self::$config['base']) && !empty(self::$config['base'])) {
                $File_trylist = File::_create_try_list(self::$config['base'], array('html', 'php', 'tpl'));
                $File = File::instance_of_first_existing_file($File_trylist);
                if ($File->exists) {
                    self::$config['base'] = $File->path;
                }
                self::$config['Base'] = $File;
            }
            self::$mime = self::$config['mime'];
        }
    }

    public static function plugins_init() {
        $File_plugins = File::instance_of_first_existing_file(File::_create_try_list('plugins.json'));
        foreach ($File_plugins->get_json() as $plugin_name) {
            $plugin_dir = DIR_X4 . $plugin_name . '/';
            $plugin_config = File::instance($plugin_dir . 'plugin_config.json')->get_json();
            if (is_dir($plugin_dir) && is_array($plugin_config) && !empty($plugin_config)) {
                self::$plugins[$plugin_name] = array(
                    'key' => $plugin_name,
                    'dir' => $plugin_dir,
                    'events' => array(
                        'init' => @__is_string_default_null($plugin_config['init']),
                        'start' => @__is_string_default_null($plugin_config['start']),
                        'end' => @__is_string_default_null($plugin_config['end']),
                    ),
                    'structure' => isset($plugin_config['structure']) ? $plugin_config['structure'] : array(),
                );
            }
        }
    }

    public static function plugins_load() {
        foreach (self::$plugins as $plugin) {
            $init_script = $plugin['events']['init'] ? $plugin['dir'] . $plugin['events']['init'] : null;
            if ($init_script) {
                include $init_script;
            }
        }
    }

}

X4::init();
