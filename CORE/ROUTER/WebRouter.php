<?php

namespace CORE\ROUTER;
class WebRouter {
    private static $_NAMESPACE = '\\APP\\';

    private function __construct () {}

    public static function Start () {
        GLOBAL_CONFIG['session'] == 'ON' && session_start ();
        self :: _doRouter();
    }

    protected static function _doRouter () {
        $pathInfo = trim ($_SERVER['PATH_INFO'] , '/');
        list ($ctl , $act) = explode ('/' , $pathInfo);
        $ctl = empty ($ctl) ? 'Default' : $ctl;
        $act = empty ($act) ? 'Index' : $act;
        
        
    }
}
