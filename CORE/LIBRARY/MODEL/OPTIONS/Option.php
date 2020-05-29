<?php

namespace CORE\LIBRARY\MODEL\OPTIONS;
abstract class Option {
    protected $_argvs;
    function __construct (array $argvs) {

    }

    protected function _ExtractKeys () {}
    protected function _ExtractVals () {}

    public function ExtractKeys () {
        return $this -> _ExtractKeys ();
    }

    public function ExtractVals () {
        return $this -> _ExtractVals ();
    }

}