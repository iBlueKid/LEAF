<?php

namespace CORE\LIBRARY\MODEL\OPTIONS;
class WhereOption extends Option {
    function __construct(array $argvs) {
        $this -> _argvs['_logic_'] = 'AND';
        $this -> Merge ($argvs); 
    }

    public function Merge (array $argvs) {
        if(count($argvs) == 1 && !empty($argvs['_logic_'])) {$this -> _argvs['_logic_'] = strtoupper($argvs['_logic_']); return;}

        $conditions = [];
        foreach ($argvs as $column => $val) {
            $conditions['_logic_'] = 'AND';
            if ($column == '_logic_') {$conditions['_logic_'] = strtoupper($val);continue;}
            $exp = '=';
            if (is_array($val)) {$value = $val[0] ; $exp = ($val[1] ?? '=');}
            else $value = $val;
            $condition['key'] = $column;
            $condition['exp'] = $exp;
            $condition['val'] = $value;
            $conditions[] = $condition;
        }

        !empty($conditions) && $this -> _argvs[] = $conditions ;
    }

    protected function _ExtractKeys () {
        $expressions = [];
        foreach($this -> _argvs as $argv) {
            if(!is_array($argv)) continue;
            $expression = [];
            foreach ($argv as $item) {
                if(!is_array($item)) {$logic = sprintf(' %s ' , strtoupper($item)); continue;}
                if(strstr($item['key'] , '.')) $item['key'] = vsprintf('{%s}.{%s}' , explode('.' , $item['key']));
                else $item['key'] = sprintf ('{%s}' , $item['key']);
                $expression[] = $item['key'] .' '. $item['exp'] . ' %s';
            }
            
            $expressions[] = sprintf('(%s)' , implode($logic , $expression));
        }

        $g_logic = sprintf(' %s ' , $this -> _argvs['_logic_']);
        $result = empty($expressions) ? '' : 'WHERE ' . implode($g_logic , $expressions);
        return $result;
        
    }

    protected function _ExtractVals () {
        $vals = [];
        foreach ($this -> _argvs as $argv) {
            if(!is_array($argv)) continue;
            $vals = array_merge ($vals , array_column($argv , 'val')); 
        }
        return array_map (function($val) {
            if(is_string($val)) return sprintf('\'%s\'' , $val);
            if(is_array($val)) return sprintf('(%s)',implode (',' , array_map(function($item) {return is_string($item) ? sprintf('\'%s\'' , $item) : $item;} ,$val)));
            return $val; 
        } , $vals);
    }

}