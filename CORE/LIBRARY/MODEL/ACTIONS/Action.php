<?php

namespace CORE\LIBRARY\MODEL\ACTIONS;
abstract class Action {
    protected $_sqlTemplate;
    protected $_table;
    protected $_driver;

    function __construct (string $table , \CORE\DRIVER\DB\DBDriver $driver) {
        $this -> _driver = $driver;
        $this -> _table = $table;
    }
} 