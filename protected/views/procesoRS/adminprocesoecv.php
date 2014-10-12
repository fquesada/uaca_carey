<?php
/* @var $this ProcesoEvaluacionController */
/* @var $procesoec ProcesoEvaluacion */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/adminprocesoecv.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/adminprocesoecv.css');//CLEAN CODE

$this->breadcrumbs=array(
	'ECV'=>array('admin'),
	'Gestionar proceso ECV',
);
$this->menu=array(
	array('label'=>'Lista de Procesos ECV' , 'url'=>array('admin')),	
        array('label'=>'Editar Proceso ECV' , 'url'=>array('editarprocesoecv', 'id'=>$procesoecv->id)),	
);
?>

<h3 style="text-align: center">Gestionar Proceso ECV #<?php echo $procesoecv->id;?></h3>

<div>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$procesoecv,
	'attributes'=>array(
                array(
                        'label' => $procesoecv->getAttributeLabel('fecha'),
                        'value' => $procesoecv->FechaProcesoFormato,
                ),                               
                array(
                        'label' => $procesoecv->_periodo->getAttributeLabel('periodo'),
                        'value' => $procesoecv->_periodo->nombre,
                ),
                'descripcion',
                array(
                        'label' => $procesoecv->getAttributeLabel('evaluador'),
                        'value' => $procesoecv->_evaluador->nombrecompleto,
                ),   
                array(
                        'label' => $procesoecv->getAttributeLabel('estado'),
                        'value' => $procesoecv->EstadoProceso,
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
      <th>Postulante</th>
      <th>Puesto</th> 
      <th>Estado</th> 
      <th>Fecha Evaluacion</th>            
      <th>Acciones</th>
    </tr>    
  </thead>  
  <tbody>
      <?php
    foreach($procesoecv->_evaluacionescompetencias as $ec){
        $postulante = Postulante::model()->findByPk($ec->colaborador);
        $vacante = Vacante::model()->findByAttributes(array('procesoevaluacion'=>$procesoecv->id));
        echo '<tr>';
        echo '<th style="display: none" id="idec">'; echo $ec->id; echo '</th>';
        echo '<th>'; echo $postulante->cedula; echo '</th>';
        echo '<th>'; echo $postulante->nombrecompleto; echo '</th>';
        echo '<th>'; echo $vacante->_puesto->nombre; echo '</th>';
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
        echo CHtml::button('Volver atrás', array('id'=>'btnvolveratras','submit' => array('procesors/admin'), 'class'=>'sexybutton sexysimple sexylarge'));
   ?>
    </div>
</div>
