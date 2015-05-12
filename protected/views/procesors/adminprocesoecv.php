<?php
/* @var $this ProcesoRSController */
/* @var $procesoecv ProcesoEvaluacion */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/adminprocesoecv.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/adminprocesoecv.css');

$evaluaciones = $procesoecv->_evaluacionescompetencias;

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

<div class="divBtnEnlaces">                    
    <button  id="verenlaces" type="button" class="sexybutton sexysimple" ><span class="accept">Ver Enlaces de Evaluaciones</span></button>
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
      <th colspan="2" id="thevaluacion">Evaluación</th>      
      <th></th>
    </tr>
    <tr id="trencabezados">
      <th style="display: none">idec</th>      
      <th>Cédula</th> 
      <th>Postulante</th>
      <th>Puesto</th> 
      <th>Estado</th> 
      <th>Fecha Evaluación</th>            
      <th>Acciones</th>
    </tr>    
  </thead>  
  <tbody>
      <?php
    foreach($evaluaciones as $ec){
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
        $imgcorreo=CHtml::image(Yii::app()->request->baseUrl.'/images/icons/silk/email_go.png', 'Links de evaluación', array("id"=>"imgenviarcorreo", "cursor:pointer;"));
        if(!$ec->estadoevaluacionindicador)
            echo CHtml::link($imgcorreo, Yii::app()->getBaseUrl(true) . '/index.php/procesors/evaluarprocesoecv/' . CommonFunctions::encrypt($ec->id), array('title'=>'Links de evaluación'));
        $imgreporte=CHtml::image(Yii::app()->request->baseUrl.'/images/icons/silk/chart_pie.png', 'Generar reporte', array("id"=>"imggenerarreporte", "cursor:pointer;"));        
        if($ec->estadoevaluacionindicador)
            echo CHtml::link($imgreporte,'#', array('title'=>'Generar reporte'));
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
    
    
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogenlaces',
    'options' => array(
        'title' => 'Enlaces de evaluaciones',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 500,
        'resizable' => false,
        'draggable' => false,
        'beforeClose' => 'js:function(){$("#divenlaces").hide();}',
    ),
));
?>    

    <div id="divenlaces" >    

        <p>A continuación se muestra la información que debe ser enviada por correo al Evaluador.</p>
        <p>Favor proceder a copiarla.</p>
        <br>

    <?php
    foreach ($evaluaciones as $eclink) {
        if (!$eclink->estadoevaluacionindicador) {
            
             $postulante = Postulante::model()->findByPk($eclink->colaborador);
             $vacante = Vacante::model()->findByAttributes(array('procesoevaluacion'=>$procesoecv->id));           
            
            echo 'Nombre: ' . $postulante->nombrecompleto . '<br/>';
            echo 'Cédula: ' . $postulante->cedula . '<br/>';
            echo 'Puesto: ' . $vacante->_puesto->nombre . '<br/>';
            echo '<a href="' . Yii::app()->getBaseUrl(true) . '/index.php/procesors/evaluarprocesoecv/' . CommonFunctions::encrypt($eclink->id) . '">' . 'Click para ir a la evaluación' . '</a>';
            echo '<hr>';
        }
    }
    ?>

    </div>

    <?php $this->endWidget(); ?>  


    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogenlacesinvidual',
        'options' => array(
            'title' => 'Enlace de la evaluación',
            'autoOpen' => false,
            'modal' => true,
            'width' => 500,
            'height' => 275,
            'resizable' => false,
            'draggable' => false,
            'beforeClose' => 'js:function(){
            $("#contenidoenlaceindividual").html();
            $("#divenlacesinvidual").hide();}',
        ),
    ));
    ?>       
    <div id="divenlacesinvidual" >  

        <p>A continuación se muestra la información que debe ser enviada por correo al Evaluador.</p>
        <p>Favor proceder a copiarla.</p>
        <br>

        <div id="contenidoenlaceindividual"></div>    
    </div>

<?php $this->endWidget(); ?>      
    
    
    
</div>
