<?php

class XDB {

    public static $config_raw = null;
    public $config = null;
    public $engine = 'json';

    public function __construct($config = null) {
        if (is_array($config) && !empty($config)) {
            $this->config = $config;
        } else if (isset(self::$config_raw)) {
            $this->config = self::$config_raw;
        }
        if (isset($this->config['engine']) && is_string($this->config['engine']) && !empty($this->config['engine'])) {
            $this->engine = strtolower(trim($this->config['engine']));
        }
        switch ($this->engine) {
            case 'jsondb':
            case 'json':
            case 'files':
                $this->engine = 'json';
                include_once XDBCLASSES . 'xdb_json.class.php';
                break;
            case 'sql':
            case 'mysql':
                $this->engine = 'mysql';
                include_once XDBCLASSES . 'xdb_mysql.class.php';
                break;
            default:
                debug('ERROR: XDB engine "' . $this->engine . '" is not valid');
                break;
        }
        return $this;
    }

    public function init() {
        if ($this->engine == 'json') {
            XDBJson::startup();
        } else if ($this->engine == 'mysql') {
            //
        }
    }

    public function insert($table_name, $data) {
        if ($this->engine == 'json') {
            return XDBJson::insert($table_name, $data);
        } else if ($this->engine == 'mysql') {
            return null;
        }
    }

    public function select($table_name, $conditions = null, $config = null, $with_connections = true) {
        if ($this->engine == 'json') {
            return XDBJson::select($table_name, $conditions, $config, $with_connections);
        } else if ($this->engine == 'mysql') {
            return null;
        }
    }

    public function select_first($table_name, $conditions = null, $with_connections = true) {
        if ($this->engine == 'json') {
            return XDBJson::select_first($table_name, $conditions, $with_connections);
        } else if ($this->engine == 'mysql') {
            return null;
        }
    }

    public function update($table_name, $conditions, $data) {
        if ($this->engine == 'json') {
            return XDBJson::update($table_name, $conditions, $data);
        } else if ($this->engine == 'mysql') {
            return null;
        }
    }

    public function search($table_name, $term, $fields = null, $exact_match = false, $quick = true) {
        if ($this->engine == 'json') {
            return XDBJson::search($table_name, $term, $fields, $exact_match, $quick);
        } else if ($this->engine == 'mysql') {
            return null;
        }
    }

    //

    public function add_validations($tables) {
        if (is_array($tables) && !empty($tables)) {
            foreach ($tables as $table_name => $table_validation) {
                if (is_array($table_validation) && !empty($table_validation) && !empty($table_name)) {
                    $this->add_validation($table_name, $table_validation);
                }
            }
        }
    }

    public function add_validation($table_name, $table_validation) {
        if ($this->engine == 'json') {
            XDBJson::$config_connections[$table_name] = $table_validation;
        }
    }

    public function add_tables($tables) {
        if (is_array($tables) && !empty($tables)) {
            foreach ($tables as $table_name => $table_config) {
                if (is_array($table_config) && !empty($table_config) && !empty($table_name)) {
                    $this->add_table($table_name, $table_config);
                }
            }
        }
    }

    public function add_table($table_name, $table_config) {
        if ($this->engine == 'json') {
            XDBJson::$config_tables[$table_name] = $table_config;
        }
    }

}
