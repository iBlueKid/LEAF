<?php

namespace CORE\ROUTER;
class ConRouter {

    private static $_allowOpts = ['e' , 'ex' , 'exc'];

    private function __construct () {}

    public static function Start () {
        self :: _doRouter ();
    }
    protected static function _doRouter () {
       $argv = $_SERVER['argv'];
       list($script , $opt , $target) = $argv;
 
       if (empty ($opt) || !in_array (substr($opt , 1) , self :: $_allowOpts)) exit ('unknow option , please input your option or checkout your inputs...' . PHP_EOL);
       empty($target) && $target = 'Default::Run';
       list ($ctl , $act) = explode ('::' , $target);
       empty($target) && $act = 'Run';
       $class = '\\CONSOLE\\CTL\\' . $ctl . 'CTL';
       $curCtl = new $class;
       \CORE\LIBRARY\UTIL\Console::Log('Route to ' . implode ('::' , [$class , $act]) . '................');
       if (!method_exists ($curCtl , $act)) exit ('call an undefine method ['. $act .'] at class [' . $class . ']' . PHP_EOL);
       $curCtl -> $act(); 
    }
}
