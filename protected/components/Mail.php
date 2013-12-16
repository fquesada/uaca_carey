<?php

class Mail {
	
    /*
     * @param $evaluador nombre del encargado de evaluar al colaborador
     * @param $correoevaluador correo del encargado de evaluar al colaborador
     * @param $colaborador nombre de la persona que debe ser evaluada
     * @param $link hipervinculo para acceder a la evaluación del colaborador
     * @param $tipo tipo de correo que debe ser enviado
     * @return boolean confirmacion de envio
     */
    public static function enviarcorreo($evaluador, $correoevaluador, $colaborador, $link, $tipo){         
        
        $correo = new YiiMailer();
        $correo->setView('contact');
        $correo->setData(array('nombreevaluador' => $evaluador , 'nombrecolaborador' => $colaborador, 'link' => $link, 'description' => 'Evaluación de Colaboradores'));

        //set properties
        $correo->setFrom($correoevaluador, $evaluador);
        
        if ($tipo == 1){
            $correo->setSubject('Evaluación de Desempeño: '. $colaborador);
        }
        else if ($tipo == 2){
            $correo->setSubject('Evaluación de Competencias: '. $colaborador);
        }
        
        $correo->setTo($correoevaluador);
        
        if($correo->send()){
            return TRUE;
        }
        else
            return FALSE;    
    }
    
   
}
