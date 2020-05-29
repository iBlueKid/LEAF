<?php 

namespace CORE\LIBRARY\MODEL\ACTIONS;
class UpdateAct extends Action {
    protected $_sqlTemplate = 'UPDATE {table} {set} {where} {order by} {limit};';

    private $_setKeys;
    private $_setVals;
    private $_whereKeys;
    private $_whereVals;
    private $_order;
    private $_limit;

    function __construct (string $table , array $ops , \CORE\DRIVER\DB\DBDriver $driver) {
        parent :: __construct ($table , $driver);
        list($this -> _setKeys , $this -> _setVals) = !empty($ops['OP_SET']) ? [$ops['OP_SET'] -> ExtractKeys() , $ops['OP_SET'] -> ExtractVals()] : ['' , []];
        list($this -> _whereKeys , $this -> _whereVals) = !empty($ops['OP_WHERE']) ? [$ops['OP_WHERE'] -> ExtractKeys() , $ops['OP_WHERE'] -> ExtractVals()] : [[] , []];
        $this -> _order = !empty ($ops['OP_WHERE']) ? $ops['OP_ORDER'] -> ExtractKeys() : [];
        $this -> _limit = !empty($ops['OP_LIMIT']) ? $ops['OP_LIMIT'] -> ExtractKeys() : [];
    }

    private function _CommonPart () {
        $exeSql = str_replace (' {table}' , $this -> _driver -> Format(sprintf(' %s' , $this -> _table)) , $this -> _sqlTemplate);
        $exeSql = str_replace (' {set}' , sprintf(' %s' , $this -> _driver -> Format($this -> _setKeys)) , $exeSql);
        $exeSql = str_replace (' {where}' ,!empty($this -> _whereKeys) ? sprintf(' %s' , $this -> _driver -> Format($this -> _whereKeys)) : '' , $exeSql);
        $exeSql = str_replace (' {order by}' ,!empty($this -> _order) ? sprintf(' %s' , $this -> _driver -> Format($this -> _order)) : '' , $exeSql);
        $exelimit = empty ($this -> _limit) ? '' : sprintf(' %s' ,  $this -> _limit);
        $exeSql = str_replace (' {limit}' ,  $exelimit , $exeSql);
        return $exeSql;
    }

    public function DoCompose () {
        $exeSql = $this -> _CommonPart ();
        $formatVals = array_merge ([] , $this -> _setVals , $this -> _whereVals);
        !empty($formatVals) && $exeSql = vsprintf ($exeSql , $formatVals);
        return $exeSql;
    }

    public function DoExecute () {
        $exeSql = $this -> _CommonPart ();
        $formatVals = array_merge ([] , $this -> _setVals , $this -> _whereVals);
        $exeSql = vsprintf( $exeSql , array_fill (0 , count($formatVals) , '?'));
        $result = $this -> _driver -> DoExec ($exeSql , $formatVals);
        return $result;
    }
}