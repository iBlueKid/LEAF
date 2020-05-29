<?php

namespace CORE\LIBRARY\MODEL\OPTIONS;
class GroupOption extends Option {
    function __construct (array $argvs) {
        $this -> _argvs = $argvs;
    }

    protected function _ExtractKeys () {
        $keys = [];
        foreach ($this -> _argvs as $argv) {
            if(is_string($argv)) $keys[] = strstr($argv , '.') ? implode('.',array_map(function ($part) {return sprintf('{%s}' , $part);} , explode('.' , $argv))) : sprintf('{%s}' , $argv);
            else $keys[] = $argv;
        }
        $result = sprintf('GROUP BY %s', implode(',' , $keys));
        return $result;
    }
}