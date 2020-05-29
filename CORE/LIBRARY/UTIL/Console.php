<?php 

namespace CORE\LIBRARY\UTIL;
class Console {
    public static function Log ($content) {
        $format = '[%s] : %s' . PHP_EOL;
        echo sprintf ($format , date('Y-m-d H:i:s') , $content);
    }
}