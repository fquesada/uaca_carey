<?php
/* @var $this ProcesoEvaluacionController */
/* @var $procesoec ProcesoEvaluacion */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/adminprocesoec.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/adminprocesoec.css');//CLEAN CODE

$this->breadcrumbs=array(
	'EC'=>array('admin'),
	'Gestionar proceso EC',
);
$this->menu=array(
	array('label'=>'Lista de Procesos EC' , 'url'=>array('admin')),	
        array('label'=>'Editar Proceso EC' , 'url'=>array('editarprocesoec', 'id'=>$procesoec->id)),	
);
?>

<h3 style="text-align: center">Gestionar Proceso EC #<?php echo $procesoec->id;?></h3>

<div>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$procesoec,
	'attributes'=>array(
                array(
                        'label' => $procesoec->getAttributeLabel('fecha'),
                        'value' => $procesoec->FechaProcesoFormato,
                ),                               
                array(
                        'label' => $procesoec->_periodo->getAttributeLabel('periodo'),
                        'value' => $procesoec->_periodo->nombre,
                ),
                'descripcion',
                array(
                        'label' => $procesoec->getAttributeLabel('evaluador'),
                        'value' => $procesoec->_evaluador->nombrecompleto,
                ),   
                array(
                        'label' => $procesoec->getAttributeLabel('estado'),
                        'value' => $procesoec->EstadoProceso,
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
      <th colspan="2" id="thevaluacion">Evaluacion</th>      
      <th></th>
    </tr>
    <tr id="trencabezados">
      <th style="display: none">idec</th>      
      <th>Cedula</th> 
      <th>Colaborador</th>
      <th>Puesto</th> 
      <th>Estado</th> 
      <th>Fecha Evaluacion</th> 
      <th>Acciones</th>
    </tr>    
  </thead>  
  <tbody>
      <?php
    foreach($procesoec->_evaluacionescompetencias as $ec){
        echo '<tr>';
        echo '<th style="display: none" id="idec">'; echo $ec->id; echo '</th>';
        echo '<th>'; echo $ec->_colaborador->cedula; echo '</th>';
        echo '<th>'; echo $ec->_colaborador->nombrecompleto; echo '</th>';
        echo '<th>'; echo $ec->_colaborador->nombrepuestoactual; echo '</th>';
        echo '<th>'; echo $ec->estadoevaluaciondescripcion; echo '</th>';
        echo '<th>'; echo $ec->fechaevaluacionecformato; echo '</th>';      
        echo '<th>';
        $imgcorreo=CHtml::image(Yii::app()->request->baseUrl.'/images/icons/silk/email_go.png', 'Enviar correo', array("id"=>"imgenviarcorreo", "cursor:pointer;"));
        if(!$ec->estadoevaluacionindicador)
        echo CHtml::link($imgcorreo, '#');
        $imgreporte=CHtml::image(Yii::app()->request->baseUrl.'/images/icons/silk/chart_pie.png', 'Generar reporte', array("id"=>"imggenerarreporte", "cursor:pointer;"));        
        if($ec->estadoevaluacionindicador)
            echo CHtml::link($imgreporte,'#');
        echo'</th>';
        echo '</tr>';
    }?>
  </tbody>
</table>
    
</div>
    <div style="text-align: center"> 
   <?php
        echo CHtml::button('Volver atrás', array('id'=>'btnvolveratras','submit' => array('procesoevaluacion/admin'), 'class'=>'sexybutton sexysimple sexylarge'));
   ?>
    </div>
</div>
