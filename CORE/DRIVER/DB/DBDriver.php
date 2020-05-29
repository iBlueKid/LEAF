<?php

namespace CORE\DRIVER\DB;
abstract class DBDriver {
    protected $_pdo;
    // protected $_dbname;
    // protected $_port;
    // protected $_option;
    // protected $_usr;
    // protected $_pwd;

    function __construct () {
        $this -> _init();
    }
    abstract protected function _init ();

    public function DoQuery (string $sql , array $argv = []) {
        $stmt = $this -> _pdo -> prepare ($sql);
        if(!$stmt) throw new \Exception ('pdo prepare sql failure');
        empty($argv) ? $stmt -> execute () : $stmt -> execute($argv);
        $error = $stmt -> errorInfo();
        if ($error[0] != '00000') throw new \Exception ('SQLSTATE ERROR CODE [' . $error[0] . '] , DRIVER ERROR CODE [' . $error[1] . '] , ERROR MSG : ' . $error[2]);

        $result = $stmt -> fetchAll(\PDO::FETCH_ASSOC) ?? [];
        return  $result;
    }

    public function DoExec(string $sql , array $argv = []) {
        $stmt = $this -> _pdo -> prepare ($sql);
        if(!$stmt) throw new \Exception ("pdo prepare sql failure");
    
        $execResult = empty($argv) ? $stmt -> execute () : $stmt -> execute($argv);
        if($execResult) $effectCount = $stmt -> rowCount ();
        $error = $stmt -> errorInfo();
        if ($error[0] != '00000') throw new \Exception ('SQLSTATE ERROR CODE [' . $error[0] . '] , DRIVER ERROR CODE [' . $error[1] . '] , ERROR MSG : ' . $error[2]);
        return $execResult ? $effectCount : $execResult;
    }
}