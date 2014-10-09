<?php
/* @var $this ProcesoEDController */
/* @var $procesoed ProcesoEvaluacion */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/adminprocesoed.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/adminprocesoed.css');//CLEAN CODE

$this->breadcrumbs=array(
	'ED'=>array('admin'),
	'Gestionar proceso ED',
);
$this->menu=array(
	array('label'=>'Lista de Procesos ED' , 'url'=>array('admin')),	
        array('label'=>'Editar Proceso ED' , 'url'=>array('editar', 'id'=>$procesoed->id)),	
);
?>

<h3 style="text-align: center">Gestionar Proceso ED #<?php echo $procesoed->id;?></h3>

<div>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$procesoed,
	'attributes'=>array(
                array(
                        'label' => $procesoed->getAttributeLabel('fecha'),
                        'value' => $procesoed->FechaProcesoFormato,
                ),                               
                array(
                        'label' => $procesoed->_periodo->getAttributeLabel('periodo'),
                        'value' => $procesoed->_periodo->nombre,
                ),
                'descripcion',
                array(
                        'label' => $procesoed->getAttributeLabel('evaluador'),
                        'value' => $procesoed->_evaluador->nombrecompleto,
                ),   
                array(
                        'label' => $procesoed->getAttributeLabel('estado'),
                        'value' => $procesoed->EstadoProceso,
                ),                
	),
)); ?>
</div>

<div>
<div class="divcolaboradoresevaluados">
    
<table border="1" id="tblcolaboradoresevaluados" class="tblcolaboradoresevaluados">
  <thead>
    <tr>
      <th style="display: none">idec</th>
      <th></th>      
      <th></th> 
      <th></th>       
      <th colspan="3" id="thcompromisos">Compromisos</th> 
      <th colspan="2" id="thevaluacion">Evaluacion</th>       
      <th></th>
    </tr>
    <tr id="trencabezados">
      <th style="display: none">idec</th>      
      <th>Cedula</th> 
      <th>Colaborador</th>
      <th>Puesto</th> 
      <th>Estado</th> 
      <th>Fecha Registro de Compromisos</th>
      <th>Fecha Evaluacion de Compromisos</th>
      <th>Estado</th>
      <th>Fecha Evaluacion</th> 
      <th>Acciones</th>
    </tr>    
  </thead>  
  <tbody>
      <?php
    foreach($procesoed->_evaluaciondesempenos as $ed){
        echo '<tr>';
        echo '<th style="display: none" id="ided">'; echo $ed->id; echo '</th>';
        echo '<th>'; echo $ed->_colaborador->cedula; echo '</th>';
        echo '<th>'; echo $ed->_colaborador->nombrecompleto; echo '</th>';
        echo '<th>'; echo $ed->_colaborador->nombrepuestoactual; echo '</th>';
        echo '<th>'; echo $ed->EstadoCompromisosDescripcion; echo '</th>'; 
        echo '<th>'; echo $ed->FechaRegistroCompromisoFormato; echo '</th>'; 
        echo '<th>'; echo $ed->FechaCompromisoEvaluacionFormato; echo '</th>';         
        echo '<th>'; echo $ed->EstadoEvaluacionDescripcion; echo '</th>';
        echo '<th>'; echo $ed->FechaEvaluacionFormato; echo '</th>';           
        echo '<th>';  
        if(!$ed->EstadoCompromisosIndicador){
            $imgingresarcompromiso=CHtml::image(Yii::app()->request->baseUrl.'/images/icons/silk/script_add.png', 'Registrar Compromisos', array("id"=>"imgregistrarcompromisos", "cursor:pointer;"));
            echo CHtml::link($imgingresarcompromiso, array('procesoed/agregarcompromisos/'.$ed->id));        
        }else if(!$ed->EstadoEvaluacionIndicador){
            $imgvercompromiso=CHtml::image(Yii::app()->request->baseUrl.'/images/icons/silk/script_key.png', 'Ver Compromisos', array("id"=>"imgvercompromisos", "cursor:pointer;"));
            $imgevaluacion=CHtml::image(Yii::app()->request->baseUrl.'/images/icons/silk/award_star_add.png', 'Registrar Evaluacion', array("id"=>"imgregistrarevaluacion", "cursor:pointer;"));        
            echo CHtml::link($imgvercompromiso, array('#'));
            echo CHtml::link($imgevaluacion,array('procesoed/registrarevaluacion/'.$ed->id));
        }
        if($ed->EstadoEvaluacionIndicador){
           $imgreporte=CHtml::image(Yii::app()->request->baseUrl.'/images/icons/silk/chart_pie.png', 'Generar reporte', array("id"=>"imggenerarreporte", "cursor:pointer;"));        
           echo CHtml::link($imgreporte,'#');
        }
        echo'</th>';
        echo '</tr>';
    }?>
  </tbody>
</table>
    
</div>
    <div style="text-align: center"> 
   <?php
        echo CHtml::button('Volver atrás', array('id'=>'btnvolveratras','submit' => array('procesoed/admin'), 'class'=>'sexybutton sexysimple sexylarge'));
   ?>
    </div>
</div>
