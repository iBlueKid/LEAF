<?php

namespace CORE\ROUTER;
class WebRouter {
    private static $_NAMESPACE = '\\APP\\CONTROLLERS\\';

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
        
        //new ctl instance
        $ctlClass = self :: $_NAMESPACE . sprintf ('%sController' , $ctl);
        $ctlInstance = new $ctlClass();

        if (!method_exists ($ctlInstance , $act)) exit ($ctl . '::' . $act . ' is not existed');


        //refection params
        $method = new \ReflectionMethod ($ctlClass, $act);
        $params = $method -> getParameters();
        
        $args = [];
        foreach ($params as $param) {
            if($param -> isDefaultValueAvailable()) $args[] = $param -> getDefaultValue ();
            if(isset($_REQUEST[$param -> getName()])) $args[] = $_REQUEST[$param -> getName()];
        }

        $method -> invokeArgs ($ctlInstance , $args);

    }
}
