<?php

namespace CORE\DRIVER\DB;
class MySQL extends DBDriver {
    protected function _init() {
        $GLOBAL_CONFS = GLOBAL_CONFIG['MYSQL'];
        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s' , $GLOBAL_CONFS['HOST'] , $GLOBAL_CONFS['PORT'] , $GLOBAL_CONFS['DB']);
        $this -> _pdo = new \PDO ($dsn , $GLOBAL_CONFS['USR'] , $GLOBAL_CONFS['PWD'] , [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'']);
    }

    public function Format (string $part) {
        $part = str_replace('{' , '`' , $part);
        $part = str_replace('}' , '`' , $part);
        return $part;
    } 

}