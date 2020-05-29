<?php 

namespace CORE\LIBRARY\Controller;
class Controller {


    // protected $_context;
    // protected $_view; //view instance
    
    function __construct () {
        $this -> _context = RequestContext :: Context ();
        if (method_exists ($this , '_Init')) $this -> _Init ();
    }
    //Init hook
    protected function _Init () {       
    }

    protected function _Json ( array $data = [] ) : string {
        header('Content-Type:application/json; charset=utf-8');
        return json_encode ($data);
    }

    protected function _Success ( $msg = ''  , array $data = [] ) : string {
        $jsonData = ['code' => 1 ,  'Message' => $msg , 'Data' => $data ];
        return $this -> _Json ($jsonData);
    } 

    protected function _Failure  ( $msg = '' , array $data = [] ) : string {
        $jsonData = ['code' => 0 ,  'Message' => $msg , 'Data' => $data ];
        return $this -> _Json ($jsonData);
    }


    // protected function _Assign ($key , $value) {
    //     if(!isset($this -> _view)) $this -> _view = new View ();
    //     $this -> _view -> Assign ($key , $value);
    // }


    // public function __set (string $name , $value) {
    //     if(!isset($this -> _view)) $this -> _view = new View ();
    //     $this -> _view -> Assign ($name, $value);
    // }
  
    // protected function _View (string $template  = '', array $data = []) : string {
    //     if(!isset($this -> _view)) $this -> _view = new View ();

    //     $controllerName = str_replace ( 'Controller' , '' , array_pop ( explode ( '\\' , get_class ( $this ) ) ) );
        
    //     $viewRoot = APP . DIRECTORY_SEPARATOR . 'Views';
    //     $viewDir = $viewRoot . DIRECTORY_SEPARATOR . $controllerName;
    //     $defaultViewPath = sprintf ( '%s.html' , $viewDir . DIRECTORY_SEPARATOR . $this -> _context -> Action );

    //     if ( !empty ($template) ) {
    //         $templatePaths = explode ( DIRECTORY_SEPARATOR , $template );
    //         if( count ( $templatePaths ) == 1 ) $viewPath = sprintf ( '%s.html' , $viewDir . DIRECTORY_SEPARATOR . reset( $templatePaths ) );
    //         else if ( count ( $templatePaths ) > 1 ) $viewPath = sprintf ( '%s.html' , $viewRoot . DIRECTORY_SEPARATOR . implode ( DIRECTORY_SEPARATOR , $templatePaths ) );
    //     }

    //     $viewPath = $viewPath ?? $defaultViewPath;
    //     if( !file_exists ($viewPath) ) throw new \Exception ('can not found the view ' . $viewPath . ', the director or files is not existed!');

    //     $this -> _view -> Template ( $viewPath ?? $defaultViewPath );
    //     $this -> _view -> TemplateData ( $data );

    //     return $this -> _view -> Render ();   // render;
    // }

    protected function _Redirect (string $path , array $arguments = []) {
        
        if(empty($path)) throw new \Exception ('can not redirect to an empty path');
        $paths = explode (DIRECTORY_SEPARATOR , $path);
        $controller = reset ( $paths );
        $action = $paths[1] ?? '';
        if( empty($controller) || empty($action) ) throw new \Exception ('can not redirect to an empty controller or action');

        $controllerName = 'App\\Controllers\\' . $controller . 'Controller';
        $method = new \ReflectionMethod ($controllerName, $action);
        $params = $method -> getParameters();

        $queryString = [];
        foreach ($arguments as $key => $value) {
            $queryString[] = sprintf ('%s=%s' , $key , $value);
        }
        $url = sprintf ('%s://%s/%s/%s?%s' , $_SERVER['REQUEST_SCHEME'] , $_SERVER['HTTP_HOST'] , $controller , $action , implode ( '&', $queryString ) );
        header("Location: {$url}"); exit;
    }



}