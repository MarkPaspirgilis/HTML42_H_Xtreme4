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
        } else {
            foreach (self::$structure as $url_path => $config) {
                if (!empty($url_path) && preg_match('#' . $url_path . '#', Request::$requested_clean_path)) {
                    self::$config_raw = self::$structure[$url_path];
                    break;
                }
            }
        }
        if (self::$config_raw) {
            foreach (self::$config as $c_key => $c_value) {
                if (isset(self::$config_raw[$c_key]) && __is_value(self::$config_raw[$c_key])) {
                    self::$config[$c_key] = self::$config_raw[$c_key];
                }
            }
            if (isset(self::$config_raw['cv']) && self::$config_raw['cv'] == 'url' || isset(self::$config_raw['vc']) && self::$config_raw['vc'] == 'url') {
                if (!isset(self::$config_raw['controller'])) {
                    self::$config_raw['controller'] = isset(Request::$requested_clean_path_array[0]) ? Request::$requested_clean_path_array[0] : 'index';
                }
                if (!isset(self::$config_raw['view'])) {
                    self::$config_raw['view'] = isset(Request::$requested_clean_path_array[1]) ? Request::$requested_clean_path_array[1] : 'index';
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
                        'start2' => @__is_string_default_null($plugin_config['start2']),
                        'end' => @__is_string_default_null($plugin_config['end']),
                        'close' => @__is_string_default_null($plugin_config['close']),
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

    public static function plugins_event_start() {
        foreach (self::$plugins as $plugin) {
            $script = $plugin['events']['start'] ? $plugin['dir'] . $plugin['events']['start'] : null;
            if ($script) {
                include $script;
            }
        }
    }

    public static function plugins_event_start2() {
        foreach (self::$plugins as $plugin) {
            $script = $plugin['events']['start2'] ? $plugin['dir'] . $plugin['events']['start2'] : null;
            if ($script) {
                include $script;
            }
        }
    }

    public static function plugins_event_end() {
        foreach (self::$plugins as $plugin) {
            $script = $plugin['events']['end'] ? $plugin['dir'] . $plugin['events']['end'] : null;
            if ($script) {
                include $script;
            }
        }
    }

    public static function plugins_event_close() {
        foreach (self::$plugins as $plugin) {
            $script = $plugin['events']['close'] ? $plugin['dir'] . $plugin['events']['close'] : null;
            if ($script) {
                include $script;
            }
        }
    }

}

X4::init();
