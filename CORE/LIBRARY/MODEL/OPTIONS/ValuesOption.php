<?php

namespace CORE\LIBRARY\MODEL\OPTIONS;
class ValuesOption extends Option {
    function __construct (array $argvs) {
        $this -> _argvs = array_filter($argvs , function ($val , $key) {return is_string($key);} , ARRAY_FILTER_USE_BOTH);
    }

    protected function _ExtractKeys () {
        $keys = array_keys ($this -> _argvs);
        $keys = array_map (function ($key) { return sprintf('{%s}' , $key);} , $keys);
        $result = implode(',' , $keys);
        return $result;
    }

    protected function _ExtractVals () {
        $vals = array_values ($this -> _argvs);
        $vals = array_map(function($val) { return is_string($val) ? sprintf('\'%s\'' , $val) : $val;} , $vals);
        return $vals;
    }

}