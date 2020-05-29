<?php 

namespace CORE\LIBRARY\LOG;
class Log {

    private static $_level = ['OFF' => 0 , 'FATAL' => 1 , 'ERROR' => 2 , 'WARN' => 3 , 'INFO' => 4 , 'DEBUG' => 5 , 'ALL' => 6 ];

    private function __construct () {}

    public static function __callStatic ($method , $arguments) {
        $logConfig = GLOBAL_CONFIG['LOG'] ?? [];

        $path = empty ( $logConfig['PATH'] ) ? APP . DIRECTORY_SEPARATOR . 'Runtime' . DIRECTORY_SEPARATOR . 'Log' . DIRECTORY_SEPARATOR : $logConfig['PATH'];
        if( !file_exists ( $path ) ) mkdir ( $path , 0777 , true );
        $fileName = sprintf ( 'Log_%s.log' , date( !isset($logConfig['DATE_FORMATE']) ? 'Ymd' : $logConfig['DATE_FORMATE'] ) );

        $logFile = $path . $fileName;

        $levels = array_keys ( self :: $_level );
        if ( !in_array ( strtoupper( $method ) , $levels ) ) throw new \Exception ('mehtod : ' . $method . ' is not allowed to call!');
        
        $allowCalls = array_keys ( array_slice ( self :: $_level , 1 , self :: $_level[$logConfig['LEVEL']] > 5 ? 5 : self :: $_level[$logConfig['LEVEL']] ) );
        if ( !in_array ( strtoupper ( $method ) , $allowCalls ) ) return false;
        
        $content = reset ($arguments) ?? '';

        self :: _AppendLog ($logFile , strtoupper ( $method ) , $content );
    } 

    protected static function _AppendLog ( $filePath , $level , $content ) {
        // print_r ([$filePath , $level , $content]);exit;
        $file = fopen ( $filePath , 'a' );

        flock ($file , LOCK_EX) ;
        fwrite ( $file , sprintf ( '%s %s : %s' .PHP_EOL , date ('Y-m-d H:i:s') , $level , $content ) );
        flock ($file , LOCK_UN);
    }
    
}
