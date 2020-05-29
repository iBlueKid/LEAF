<?php 

namespace CORE\LIBRARY\MODEL\ACTIONS;
class SelectAct extends Action {
    protected $_sqlTemplate = 'SELECT {column} FROM {table} {join} {where} {group by} {having} {order by} {limit};';

    private $_extractKeys = [];
    private $_extractVals = [];

    function __construct (string $table , array $ops , \CORE\DRIVER\DB\DBDriver $driver) {
        parent :: __construct ($table , $driver);
        foreach ($ops as $key => $val) {
            $this -> _extractKeys[$key] = $val -> ExtractKeys();
            $this -> _extractVals[$key] = $val -> ExtractVals();
        }
    }

    private function _CommonPart () {
        $exeSql = str_replace (' {table}' , $this -> _driver -> Format(sprintf(' %s' , $this -> _table)) , $this -> _sqlTemplate);
        $exeSql = str_replace (' {column}' , empty($this -> _extractKeys['OP_FIELDS']) ? ' *' : $this -> _driver -> Format(sprintf(' %s' ,$this -> _extractKeys['OP_FIELDS'])) , $exeSql);
        $exeSql = str_replace (' {join}' , empty($this -> _extractKeys['OP_JOIN'])? '' : $this -> _driver -> Format(sprintf(' %s' , $this -> _extractKeys['OP_JOIN'])) , $exeSql);
        $exeSql = str_replace (' {where}' , empty($this -> _extractKeys['OP_WHERE'])? '' : $this -> _driver -> Format(sprintf(' %s' , $this -> _extractKeys['OP_WHERE'])) , $exeSql);
        $exeSql = str_replace (' {group by}' , empty($this -> _extractKeys['OP_GROUP'])? '' : $this -> _driver -> Format(sprintf(' %s' , $this -> _extractKeys['OP_GROUP'])) , $exeSql);
        $exeSql = str_replace (' {having}' , empty($this -> _extractKeys['OP_HAVING'])? '' : $this -> _driver -> Format(sprintf(' %s' , $this -> _extractKeys['OP_HAVING'])) , $exeSql);
        $exeSql = str_replace (' {order by}' , empty($this -> _extractKeys['OP_ORDER'])? '' : $this -> _driver -> Format(sprintf(' %s' , $this -> _extractKeys['OP_ORDER'])) , $exeSql);
        $exeSql = str_replace (' {limit}' , empty($this -> _extractKeys['OP_LIMIT'])? '' : $this -> _driver -> Format(sprintf(' %s' , $this -> _extractKeys['OP_LIMIT'])) , $exeSql);
        return $exeSql;
    }

    public function DoCompose () {
        $exeSql = $this -> _CommonPart ();
        $vals = array_merge ([] , $this -> _extractVals['OP_WHERE'] , $this -> _extractVals['OP_HAVING']);
        $exeSql = vsprintf ($exeSql , $vals);
        return $exeSql;
    }


    public function DoExecute () {
        $exeSql = $this -> _CommonPart ();
        $vals = array_merge ([] , $this -> _extractVals['OP_WHERE'] , $this -> _extractVals['OP_HAVING']);

        $valTokens = array_fill (0 , count($vals) , '?');
        $exeSql = vsprintf ($exeSql , $valTokens);
        $result = $this -> _driver -> DoExec ($exeSql , $vals);
        return $result;
        
    }
}