<?php

namespace CORE\LIBRARY\MODEL\ACTIONS;
class InsertAct extends Action {

    protected $_sqlTemplate = 'INSERT INTO {table} {fields} VALUES {values};';

    private $_keys;
    private $_vals;

    function __construct (string $table , array $ops , \CORE\DRIVER\DB\DBDriver $driver) {
        parent :: __construct ($table , $driver);
        $this -> _keys = $ops['OP_VALS'] -> ExtractKeys();
        $this -> _vals = $ops['OP_VALS'] -> ExtractVals();
    }

    //公共部分
    private function _CommonPart () {
        //compose sql;
        $exeSql = str_replace ('{table}' , $this -> _driver -> Format(sprintf(' %s' , $this -> _table)) , $this -> _sqlTemplate);
        $exeSql = str_replace ('{fields}' ,$this -> _driver -> Format(sprintf('(%s)' , $this -> _keys)) , $exeSql);
        return $exeSql;
    }

    public function DoCompose () {
        $exeSql = $this -> _CommonPart();
        $exeSql = str_replace ('{values}' , sprintf('(%s)' , implode(',' , $this -> _vals)) , $exeSql);
        return $exeSql;
    }

    public function DoExecute () {
        //compose sql;
        $exeSql = $this -> _CommonPart();
        $valTokens = sprintf('(%s)' , implode(',' , array_fill(0 , count($this -> _vals) , '?')));
        $exeSql = str_replace ('{values}' , $valTokens , $exeSql);
        $result = $this -> _driver -> DoExec ($exeSql , $this -> _vals);
        return $result;
    }


}