<?php

/**
 * CommonFunctions contains functions that will help in differents cases.
 *  
 */
class CommonFunctions {
	
    /*
     * @param $datetime fecha Mysql con el formato Y-m-d H:i:s'
     * @return string fecha con el formato D-M-Y
     */
    public static function datemysqltophp($datetime){         
        list($y, $m, $d) = explode('-', substr($datetime, 0, 10));              
        return $d.'-'.$m.'-'.$y;    
    }
    
    /*
     * @param $date string con el formato d-m-Y
     * @return date fecha con el formato Y-m-d
     */
    public static function datephptomysql($date){
        list($d, $m, $y) = explode('-', $date);         
        return strftime('%Y-%m-%d', mktime(0, 0, 0, $m, $d, $y));
    }
    
    /*
     * @return date fecha con el formato d-m-Y
     */
    public static function datenow(){
        return self::datephptomysql(date('d-m-Y'));
    }
    
    /*
     * @param $stringnumber el cual debe comprobarse con anticipacion si es un numero,
     * para estopuede utilizar la funcion is_numeric
     * @return int o float segun sea el caso
     */
    public static function stringtonumber($stringnumber) {//Para utilizar esta funcion se debe comprobar con anticipacion que el var es numerico
        if ((float) $stringnumber != (int) $stringnumber)
            return (float) $stringnumber;
        else
            return (int) $stringnumber;
    }
    
    public static function ponderaciontoideal($ponderacion){        
            if($ponderacion == 7 || $ponderacion == 6)
                return 5;
            else if($ponderacion == 5)
                return 4;
            else if($ponderacion == 4)
                return 3;
            else if($ponderacion == 3 || $ponderacion == 2)
                return 2;
            else if($ponderacion == 1)
                return 1;
            else
                return 0;                
    }
    
    public static function encrypt($number){
        $salt =  989;
        return $number*$salt;
    }
    
    
    public static function decrypt($number){
        $salt =  989;
        return $number/$salt;
    }
    
}