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
        $correo->setData(array('nombreevaluador' => $evaluador , 'nombrecolaborador' => $colaborador, 'link' => $link, 'description' => 'Evaluación de Colaboradores',));

        //Se busca id 1, porque solo existe un registro en la tabla
        $admin =  Infoadmin::model()->findByAttributes(array('id' => '1'));
        $correo->setFrom($admin->correo, $admin->nombre);
        
        if ($tipo == 1){
            $correo->setSubject('Evaluación de Desempeño: '. $colaborador);
            $correo->setView('evaluacion_desempeno');
        }
        else if ($tipo == 2){
            $correo->setSubject('Evaluación de Competencias: '. $colaborador);
            $correo->setView('evaluacion_competencias');
        }
        
        $correo->setTo($correoevaluador);
        
        if($correo->send()){
            return TRUE;
        }
        else
            return FALSE;    
    }
    
   
}
