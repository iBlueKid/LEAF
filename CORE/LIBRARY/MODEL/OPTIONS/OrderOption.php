<?php

namespace CORE\LIBRARY\MODEL\OPTIONS;
class OrderOption extends Option {
    function __construct ($argvs) {
        $this -> _argvs = $argvs;
    }

    protected function _ExtractKeys () {
        $keys = [];
        foreach  ($this -> _argvs as $key => $val) {
            $field = is_int($key) ? $val : $key;
            $sort = is_int($key) ? 'ASC' : strtoupper($val);
            if (strstr($field , '.')) $field = implode('.' , array_map (function($part) { return sprintf('{%s}' , $part);},explode('.' , $field)));
            else $field = sprintf('{%s}' , $field);
            $keys[] = $field . ' ' . $sort;
        }

        $result  = empty($keys) ? '' : 'ORDER BY ' . implode(',' , $keys);
        return $result;
    }
}