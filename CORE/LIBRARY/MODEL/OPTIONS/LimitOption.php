<?php

namespace CORE\LIBRARY\MODEL\OPTIONS;
class LimitOption extends Option {
    function __construct (array $argvs) {
        $this -> _argvs = $argvs;
    }

    protected function _ExtractKeys () {
        $result = implode(',' , array_map(function($argv) {return is_string($argv) ? sprintf('\'%s\'' , $argv) : $argv;} , $this -> _argvs));
        return empty($result) ? '' : 'Limit ' . $result;
    }
}