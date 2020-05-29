<?php

namespace CONSOLE\CTLS;
class DefaultCTL {
    function __construct () {

    }

    public function Run () {
        // $model = new \CORE\LIBRARY\MODEL\Model ('user' , 'a');
        // $model -> Insert('12313');
        // echo $model -> Values(['name' => 'lilei' , 'age' => 14 , 'birthday' => '1990-08-19 00:00:00']) -> Insert(false);
        // echo PHP_EOL;
        // $argv['_logic_'] = 'AND';
        // $argv[] = [ 'Id' => '1' , 'name' => 'ord' , 'age' => [ 1 , '>' ] , '_logic_' => 'or'];
        // print_r ($argv);

        // $model = new \CORE\LIBRARY\MODEL\Model ('user');
        // $model -> Join (['_type_' => 'LEFT' , '_table_' => 'usr_info' , '_alias_' => 'info' , '_on_' => ['user.Id' => 'info.usrId' , 'info.Id' => [1 , '>=']]])
        // -> Join (['_table_' => 'usr_space' , '_alias_' => 'space' , '_on_' => ['user.Id' => 'space.usrId' , 'space.Id' => [2 , '<=']]]);

        // echo $model -> Fields(['a.Id' => 'Id' , 'b.name' => 'name' , 'age' , 1])
        //  -> Join (['_table_' => 'usrInfo' , '_alias_' => 'b' , '_on_' => ['user.Id' => 'a.Id' , 'a.Id' => ['2' , '>']]])
        //  -> Where (['Id' => 1]) 
        //  -> Group (['a.Id' , 'b.name'])
        //  -> Having (['a.Id' => [3 , '>=']])
        //  -> Order(['Id' => 'asc'])
        //  -> Limit(1,2)
        //  -> Select(false);
        // echo PHP_EOL;

        // echo $model ->Order(['a.Id' => 'DESC' , 'name'])->Limit(1,2)-> WHERE(['_logic_' => 'or']) ->Where(['Id' => [[1] , 'IN'] , 'b.name' => 'ord' , 'a.age' => [1 , '>' ] , '_logic_' => 'or']) -> Where (['gender' => 'fale' , 'birth' => '1989-09-01 00:00:00']) -> Delete(false);
        // echo PHP_EOL;
        
    }
}