<?php

namespace CORE\LIBRARY\MODEL\OPTIONS;
class JoinOption extends Option {
    function __construct (array $argvs) {
        $this -> Merge ($argvs);
    }

    public function Merge (array $argvs) {
        $join = ($argvs['_type_'] ? strtoupper($argvs['_type_']) : 'INNER') . ' JOIN';
        $table = $argvs['_table_'] ? sprintf('{%s}' , $argvs['_table_']) : '';
        $alias = $argvs['_alias_'] ? sprintf('{%s}' , $argvs['_alias_']) : '';

        $ons['logic'] = 'AND';
        foreach ($argvs['_on_'] as $key => $val) {
            if($key == '_logic_') {$ons['logic'] = strtoupper($val); continue;} 
            if (is_string($key)) $on['key'] = strstr($key , '.') ? implode('.' , array_map(function ($part) { return sprintf('{%s}' , $part);} , explode('.' , $key))) : sprintf('{%s}' , $key);
            else $on['key'] = sprintf('{%s}' , $key);
 
            $on['exp'] = '=';
            if(is_string($val)) $on['val'] = strstr($val , '.') ? implode('.' , array_map(function ($part) { return sprintf('{%s}' , $part);} , explode('.' , $val))) : sprintf('\'%s\'' , $val);
            else if(is_int($val)) $on['val'] = $val;
            else if(is_array($val)) { 
                if(is_string($val[0])) $on['val'] =  strstr($val[0] , '.') ? implode('.' , array_map(function ($part) { return sprintf('{%s}' , $part);} , explode('.' , $val[0]))) : sprintf('\'%s\'' , $val[0]);
                else $on['val'] = $val[0];
                $on['exp'] = $val[1] ?? '';}

           $ons[] = $on;
        }

        $this -> _argvs[] = ['join' => $join , 'table' => $table , 'alias' => $alias , 'on' => $ons];
    }

    protected function _ExtractKeys () {
        $joins = [];
        foreach ($this -> _argvs as $argv) {
            $logic = $argv['on']['logic'];
            unset($argv['on']['logic']);

            $expressions = array_map(function($part) {return $part['key'] . $part['exp'] . $part['val'];} ,$argv['on']);
            $on = implode(' ' . $logic . ' ' , $expressions);
            $joins[] = $argv['join'] . ' ' . $argv['table'] . ($argv['alias'] ? ' AS ' . $argv['alias'] : '') . ($on ? ' ON ' . $on : '');
        }

        $result = implode(' ' , $joins);
        return $result;
    }


}