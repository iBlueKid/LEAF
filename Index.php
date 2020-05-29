<?php
if(version_compare(PHP_VERSION, '7.0.0', '<')) exit('require php version 7.0.0 at least');
//debug
define('DEBUG' , false);

//system const
define ('ROOT' , realpath('.'));
define ('CORE' , ROOT . DIRECTORY_SEPARATOR . 'CORE');
define ('APP' , ROOT . DIRECTORY_SEPARATOR . 'APP');

//framework start
include_once CORE . '/Leaf.php';
\Core\Leaf :: Start ();