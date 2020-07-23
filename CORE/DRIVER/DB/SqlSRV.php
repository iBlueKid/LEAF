<?php

namespace CORE\DRIVER\DB;
class SqlSRV extends DBDriver {
    protected function _init() {
        $GLOBAL_CONFS = GLOBAL_CONFIG['SQLSRV'];
        $dsn = sprintf('sqlsrv:Server=%s,%s;Database=%s' , $GLOBAL_CONFS['HOST'] , $GLOBAL_CONFS['PORT'] , $GLOBAL_CONFS['DB']);
        $this -> _pdo = new \PDO ($dsn , $GLOBAL_CONFS['USR'] , $GLOBAL_CONFS['PWD']);
    }

    public function Format (string $part) {
        $part = str_replace('{' , '[' , $part);
        $part = str_replace('}' , ']' , $part);
        return $part;
    } 
}