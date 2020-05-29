<?php

namespace CORE\LIBRARY\MODEL\ACTIONS;
class DeleteAct extends Action {

    protected $_sqlTemplate = 'DELETE FROM {table} {where} {order by} {limit};';
    
    private $_keys;
    private $_vals;
    private $_limit;
    private $_order;

    function __construct (string $table , array $ops , \CORE\DRIVER\DB\DBDriver $driver) {
        parent :: __construct ($table , $driver);
        $this -> _keys = !empty($ops['OP_WHERE']) ? $ops['OP_WHERE'] -> ExtractKeys() : [];
        $this -> _vals = !empty($ops['OP_WHERE']) ? $ops['OP_WHERE'] -> ExtractVals() : [];
        $this -> _limit = !empty($ops['OP_LIMIT']) ? $ops['OP_LIMIT'] -> ExtractKeys() : [];
        $this -> _order = !empty($ops['OP_ORDER']) ? $ops['OP_ORDER'] -> ExtractKeys() : [];
    }

    private function _CommonPart () {
        $exeSql = str_replace (' {table}' , $this -> _driver -> Format(sprintf(' %s' , $this -> _table)) , $this -> _sqlTemplate);
        $exeSql = str_replace (' {where}' , !empty($this -> _keys) ? sprintf(' %s' , $this -> _driver -> Format($this -> _keys)) : '', $exeSql);
        $exeSql = str_replace (' {order by}' , !empty($this -> _order) ? sprintf(' %s' , $this -> _driver -> Format($this -> _order)) : '' , $exeSql);
        $exelimit = empty ($this -> _limit) ? '' : sprintf(' %s' , $this -> _limit);
        $exeSql = str_replace (' {limit}' ,  $exelimit , $exeSql);
        return $exeSql;
    }

    public function DoCompose () {
        $exeSql = $this -> _CommonPart ();
        !empty($this -> _vals) && $exeSql = vsprintf ($exeSql , $this -> _vals);
        return $exeSql;
    }

    public function DoExecute () {
        $exeSql = $this -> _commonPart ();
        !empty($this -> _vals) && $exeSql = vsprintf ($exeSql ,  array_fill( 0 , count($this -> _vals) , '?'));
        $result = $this -> _driver -> DoExec ($exeSql , $this -> _vals);
        return $result;
    }

}