<?php
/* @var $this ProcesoEvaluacionController */
/* @var $procesoed ProcesoEvaluacion */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/admined.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/admined.css');//CLEAN CODE

$this->breadcrumbs=array(
	'EC'=>array('admin'),
	'Gestionar proceso EC',
);
$this->menu=array(
	array('label'=>'Lista de Procesos ED' , 'url'=>array('admin')),	
        //array('label'=>'Editar Proceso EC' , 'url'=>array('editarprocesoec', 'id'=>$procesoed->id)),	
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
      <th colspan="2" id="thevaluacion">Evaluacion</th> 
      <th colspan="2"  id="thcomunicado">Comunicado</th>
      <th></th>
    </tr>
    <tr id="trencabezados">
      <th style="display: none">idec</th>      
      <th>Cedula</th> 
      <th>Colaborador</th>
      <th>Puesto</th> 
      <th>Estado</th> 
      <th>Fecha Evaluacion</th>       
      <th>Cant. Envios</th>
      <th>Fecha Ultimo Envio</th>
      <th>Acciones</th>
    </tr>    
  </thead>  
  <tbody>
      <?php
    foreach($procesoed->_evaluacionesdesempeno as $ed){
        echo '<tr>';
        echo '<th style="display: none" id="idec">'; echo $ed->id; echo '</th>';
        echo '<th>'; echo $ed->_colaborador->cedula; echo '</th>';
        echo '<th>'; echo $ed->_colaborador->nombrecompleto; echo '</th>';
        echo '<th>'; echo $ed->_colaborador->nombrepuestoactual; echo '</th>';
        echo '<th>'; echo $ed->estadoevaluaciondescripcion; echo '</th>';
        echo '<th>'; echo $ed->fechaevaluacionecformato; echo '</th>';
        echo '<th class="tdcontadorenvios">'; echo $ed->_links->contadorenvios; echo '</th>';
        echo '<th>'; echo $ed->_links->fechaultimoenvioformato; echo '</th>';       
        echo '<th>';
        $imgcorreo=CHtml::image(Yii::app()->request->baseUrl.'/images/icons/silk/email_go.png', 'Enviar correo', array("id"=>"imgenviarcorreo", "cursor:pointer;"));
        if(!$ed->estadoevaluacionindicador)
        echo CHtml::link($imgcorreo, '#');
        $imgreporte=CHtml::image(Yii::app()->request->baseUrl.'/images/icons/silk/chart_pie.png', 'Generar reporte', array("id"=>"imggenerarreporte", "cursor:pointer;"));        
        if($ed->estadoevaluacionindicador)
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