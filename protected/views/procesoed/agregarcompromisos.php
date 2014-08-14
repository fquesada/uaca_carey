<?php
/* @var $this ProcesoEDController */
/* @var $ed Evaluaciondesempeno */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/procesoed.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.placeholder.min.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/admined.css');//CLEAN CODE
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/procesoed.css');


$this->breadcrumbs=array(
	'Administrar ED'=>array('procesoed/admin'),
        'Administrar proceso ED'=>array('procesoed/adminprocesoed/'.$ed->procesoevaluacion),
	'Agregar Compromisos',
);

?>

<h3 style="text-align: center">Agregar compromisos <?php echo $ed->id;?></h3>

<div id="divencabezadoec" class="divencabezadoec">
    <p class="pencabezadoec">Informacion evaluación</p>
    <p style="display:none"><?php echo CHtml::label($ed->id, 'ided', array('id'=>'lblided'))?></p>
    <p> <b>Colaborador:</b> <?php echo $ed->_colaborador->nombrecompleto?> </p>
    <p> <b>Cedula:</b> <?php echo $ed->_colaborador->cedula?> </p>   
    <p> <b>Puesto:</b> <?php echo $ed->_colaborador->nombrepuestoactual?> </p>
    <p> <b>Departamento:</b> <?php echo $ed->_colaborador->nombreunidadnegocioactual?> </p>
    <p> <b>Evaluador:</b> <?php echo $ed->_procesoevaluacion->_evaluador->nombrecompleto?> </p>
    <p> <b>Periodo:</b> <?php echo $ed->_procesoevaluacion->_periodo->nombre ?> </p>
</div>



<?php echo CHtml::beginForm('','post',array('id'=>'formcompromisos'))?>
<?php echo $this->renderPartial('_formnuevoscompromisos', array('ed'=>$ed)); ?>

<div class="content_section_submit">        
                  <?php echo CHtml::submitButton('Crear proceso ED',array('id'=>'btncompromisos', 'class'=>'sexybutton sexysimple sexylarge'));  ?>                  
</div>

<?php echo CHtml::endForm()?>
