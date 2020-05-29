<?php

namespace CORE\LIBRARY\MODEL;
class Model {

    private $_table;
    private $_driver;

    private $_ops = [];
    function __construct (string $table , string $alias = '' , \CORE\DRIVER\DB\DBDriver $driver = null) {
        $this -> _driver = isset($driver) ? $driver : (new \CORE\DRIVER\DB\MySQL);
        $this -> _table = sprintf('{%s}' , (GLOBAL_CONFIG['PREFIX'] ?? '') .$table) . (!empty($alias) ? sprintf(' AS {%s}' , $alias) : '');
    }

    public function Values (array $values = []) {
        $this -> _ops['OP_VALS'] = new \CORE\LIBRARY\MODEL\OPTIONS\ValuesOption ($values);
        return $this;
    }

    public function Fields (array $fields = []) {
        $this -> _ops['OP_FIELDS'] = new \CORE\LIBRARY\MODEL\OPTIONS\FieldsOption ($fields);
        return $this;
    }

    public function Join (array $conditions = []) {
        empty ($this -> _ops['OP_JOIN']) ? ($this -> _ops['OP_JOIN'] = new \CORE\LIBRARY\MODEL\OPTIONS\JoinOption($conditions)) : $this -> _ops['OP_JOIN'] -> Merge ($conditions); 
        return $this;
    }

    public function Set (array $fields) {
        empty ($this -> _ops['OP_SET']) ? ($this -> _ops['OP_SET'] = new \CORE\LIBRARY\MODEL\OPTIONS\SetOption($fields)) : $this -> _ops['OP_SET'] -> Merge ($fields);
        $this -> _ops['OP_SET'] -> ExtractKeys();
        return $this;
    }

    public function Where (array $conditions) {
        empty($this -> _ops['OP_WHERE']) ? ($this -> _ops['OP_WHERE'] = new \CORE\LIBRARY\MODEL\OPTIONS\WhereOption ($conditions)) : $this -> _ops['OP_WHERE']-> Merge ($conditions); 
        return $this;
    }

    public function Group (array $groups) {
        $this -> _ops['OP_GROUP'] = new \CORE\LIBRARY\MODEL\OPTIONS\GroupOption($groups);
        return $this;
    }

    public function Having (array $conditions) {
        empty($this -> _ops['OP_HAVING']) ? ($this -> _ops['OP_HAVING'] = new \CORE\LIBRARY\MODEL\OPTIONS\HavingOption ($conditions)) : $this -> _ops['OP_HAVING']-> Merge ($conditions); 
        return $this;
    }

    public function Order (array $sorts = []) {
        $this -> _ops['OP_ORDER'] = new \CORE\LIBRARY\MODEL\OPTIONS\OrderOption ($sorts);
        return $this;
    }

    public function Limit (...$argvs) {
        $this -> _ops['OP_LIMIT'] = new \CORE\LIBRARY\MODEL\OPTIONS\LimitOption(array_slice($argvs , 0 , 2));
        return $this;
    }

    

    public function __call (string $action , array $arguments) {
        $actions = ['Insert' , 'Delete' , 'Update' , 'Select'];
        if (!in_array($action , $actions)) throw new \Exception ('call an undefined mehtod ' . $action);
        $actClass = '\\CORE\\LIBRARY\\MODEL\\ACTIONS\\' . $action . 'Act';
        $actInstance =  new $actClass($this -> _table , $this -> _ops , $this -> _driver);
        $isExec = !empty($arguments[0]);
        $result = $isExec ? $actInstance -> DoExecute() : $actInstance -> DoCompose ();
        unset ($this -> _ops);
        return $result;
    }

    // public function Insert (bool $isExec = true) {  
    //     $insertAct = new \CORE\LIBRARY\MODEL\ACTIONS\InsertAct ($this -> _table , $this -> _ops, $this -> _driver);
    //     $result = $isExec ? $insertAct -> DoExecute() : $insertAct -> DoCompose ();
    //     return $result;
    // }

    // public function Delete (bool $isExec = true) {
    //     $deleteAct = new \CORE\LIBRARY\MODEL\ACTIONS\DeleteAct ($this -> _table , $this -> _ops , $this -> _driver);
    //     $result = $isExec ? $deleteAct -> DoExecute() : $deleteAct -> DoCompose();
    //     return $result;
    // }

    // public function Update (bool $isExec = true) {
    //     $updateAct =  new \CORE\LIBRARY\MODEL\ACTIONS\UpdateAct ($this -> _table , $this -> _ops , $this -> _driver);
    //     $result = $isExec ? $updateAct -> DoExecute() : $updateAct -> DoCompose();
    //     return $result;
    // }

    // public function Select (bool $isExec = true) {
    //     $selectAct = new \CORE\LIBRARY\MODEL\ACTIONS\SelectAct ($this -> _table , $this -> _ops , $this -> _driver);
    //     $result = $isExec ? $selectAct -> DoExecute() : $selectAct -> DoCompose();
    //     return $result;
    // }



}