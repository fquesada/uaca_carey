<?php
/* @var $this ProcesoEvaluacion */
/* 'proceso'=>$proceso, 'ec' =>$ec */
echo 'fecha';
echo $proceso->fecha;
echo 'evaluador';
echo $proceso->evaluador;
echo 'estado';
echo $proceso->estado;
echo 'descripcion';
echo $proceso->descripcion;
echo 'periodo';
echo $proceso->periodo;

 echo "\n";
 echo "Colaboradores a evaluar";
foreach($proceso->_evaluacionescompetencias as $ec){
    echo "Colaboradores a evaluar";
    echo $ec->_colaborador->nombre;
    echo "\n";
    echo "Link";
    echo $ec->_links->url;
    echo "\n";
}


?>