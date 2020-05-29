<?php

namespace CORE\LIBRARY\MODEL\OPTIONS;
class SetOption extends Option {
    function __construct (array $argvs) {
        $this -> _Merge ($argvs);
    }

    public function _Merge ($argvs) {
        $this -> _argvs = array_merge ($this -> _argvs ?? [] , $argvs);
    }

    protected function _ExtractKeys () {
        $keys = array_keys ($this -> _argvs);
        $keys = array_map (function ($key) {if (strstr($key , '.')) return implode('.' , array_map (function($item){ return sprintf('{%s}' , $item);} , explode('.' , $key))); return sprintf('{%s}' , $key);} , $keys);
        $keys = array_map (function ($key) { return $key . '=%s';} , $keys);
        $result = implode(',' , $keys);
        return empty($result) ? '' :'SET ' . $result;
    }

    protected function _ExtractVals () {
        $vals = array_values($this -> _argvs);
        $vals = array_map (function ($val) {return is_string($val) ? sprintf('\'%s\'' , $val) : $val;} , $vals);
        return $vals;
    }
}