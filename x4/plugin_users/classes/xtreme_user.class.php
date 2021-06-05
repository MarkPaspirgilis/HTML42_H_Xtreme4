<?php

class XtremeUser {

    public $id = null;
    public $username = null;
    public $from_db = null;
    public static $CACHE = array('instances' => array());

    public function __construct($userid) {
        if (is_numeric($userid)) {
            $this->id = intval($userid);
            $this->from_db = $GLOBALS['XDB']->select_first('xusers', array('id' => $this->id));
            if (isset($this->from_db['username'])) {
                $this->username = trim($this->from_db['username']);
            }
            self::$CACHE['instances'][$this->id] = $this;
        }
    }

    /**
     * @param int $id
     * @return XtremeUser
     */
    public static function load($id) {
        if (is_numeric($id)) {
            $id = intval($id);
            if (!isset(self::$CACHE['instances'][$id])) {
                self::$CACHE['instances'][$id] = new self($id);
            }
            return self::$CACHE['instances'][$id];
        }
        return null;
    }

    public function in_group($name) {
        foreach ($this->from_db['groups'] as $group) {
            if ($group['name'] == $name) {
                return true;
            }
        }
        return false;
    }

}
