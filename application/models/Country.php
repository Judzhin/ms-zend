<?php

class Model_Country {

    protected $_list = array();

    public function add($country = null) {

        if (is_null($country)) {
            $this->clear();
        }

        if (array_key_exists($country, $this->_list)) {
            $this->_list[$country]++;
        } else {
            $this->_list[$country] = 1;
        }
    }

    public function get() {
        return array_keys($this->_list);
    }

    public function clear() {
        $this->_list = array();
    }

}

