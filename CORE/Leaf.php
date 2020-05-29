<?php

namespace Core;
class Leaf  {
    private function __construct () {}

    private static function _loadConf () {
        $configDirs = [
            CORE . DIRECTORY_SEPARATOR . 'CONF' , 
            APP . DIRECTORY_SEPARATOR . 'CONF',
        ];


        $GLOBAL_CONFIG = [];

        foreach ($configDirs as $configDir) {
            if (!file_exists($configDir)) continue;
            $configFiles = glob ($configDir . '/*.php' , GLOB_NOSORT);
            if(empty ($configFiles)) continue;

            foreach ($configFiles as $configFile) {
                $config = include_once($configFile);
                $GLOBAL_CONFIG = array_merge($GLOBAL_CONFIG , $config);
            }
        }

        !defined('GLOBAL_CONFIG') && define ('GLOBAL_CONFIG'  , $GLOBAL_CONFIG);
    }

    private static function _loadClass ($fullClass) {
        $classFile = ROOT . DIRECTORY_SEPARATOR . str_replace('\\' , DIRECTORY_SEPARATOR , $fullClass) . '.php';
        if(!file_exists($classFile)) exit('can not found the class : ' . $fullClass . ' , class file : ' . $classFile . ' is not existed' . PHP_EOL);
        include_once($classFile);
    }


    private static function _init () {
        date_default_timezone_set('Asia/Shanghai'); // set system timezone
        self :: _loadConf ();    //load config
        
        // auto register class
        spl_autoload_register ('self::_loadClass');

    }

    public static function Run () {
        self :: _init();
        \CORE\ROUTER\ConRouter :: Start ();
    }

    public static function Start () {
        self :: _init();
        \CORE\ROUTER\WebRouter :: Start ();
    }
}