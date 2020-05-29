<?php

namespace CORE\LIBRARY\MODEL\OPTIONS;
class FieldsOption extends Option {
    function __construct (array $argvs) {
        $this -> _argvs = $argvs;
    }

    protected function _ExtractKeys () {
        $index = 1;
        $trans = [];
        foreach ($this -> _argvs as $key => $val) {
            if (is_string($key) && is_string($val)) {
                $k = strstr($key , '.') ? implode('.' , array_map (function ($item) { return sprintf('{%s}' , $item);}  , explode('.' , $key))) : sprintf('{%s}' , $key);
                $alias = strstr($val , '.') ? implode('.' , array_map (function ($item) { return sprintf('{%s}' , $item);}  , explode('.' , $val))) : sprintf('{%s}' , $val);
            }
            if (is_int($key) && is_int($val)) {$k = $val ; $alias = sprintf('{%s}' , 'unknow' . $index++);}
            if (is_int($key) && is_string($val)) {$k = strstr($val , '.') ? implode('.' , array_map (function ($item) { return sprintf('{%s}' , $item);}  , explode('.' , $val))) : sprintf('{%s}' , $val); $alias = '';}
            if (is_string($key) && is_int($val)) {$k = strstr($key , '.') ? implode('.' , array_map (function ($item) { return sprintf('{%s}' , $item);}  , explode('.' , $key))) : sprintf('{%s}' , $key); $alias = '';}
            $trans[] = ['key' => $k , 'alias' => $alias];
        }
        $result = implode(',' , array_map (function ($tran) { return $tran['key'] . (empty($tran['alias']) ? '' : ' AS ' . $tran['alias']);} , $trans));
        return empty($result) ? '*' : $result;
    }


}