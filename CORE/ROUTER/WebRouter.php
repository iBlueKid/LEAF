<?php

namespace CORE\ROUTER;
class WebRouter extends Router {

    private function __construct () {}

    public static function Start () {
        GLOBAL_CONFIG['session'] == 'ON' && session_start ();
        self :: _doRouter();
    }

    protected static function _doRouter () {
        print_r ($_SERVER);
    }
}
