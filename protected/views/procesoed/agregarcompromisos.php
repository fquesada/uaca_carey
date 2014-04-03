<?php
/* @var $this ProcesoEvaluacionController */
/* @var $evaluacion ProcesoEvaluacion */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/admined.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/admined.css');//CLEAN CODE

$this->breadcrumbs=array(
	'EC'=>array('admin'),
	'Gestionar proceso EC',
);
$this->menu=array(
	array('label'=>'Lista de Procesos ED' , 'url'=>array('admin')),	
);
?>

<h3 style="text-align: center">Agregar compromisos<?php echo $evaluacion->id;?></h3>

<div>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$evaluacion,
	'attributes'=>array(
                array(
                        'label' => $evaluacion->getAttributeLabel('fecha'),
                        'value' => $evaluacion->fechaevaluacion,
                ),                               
                array(
                        'label' => $evaluacion->_puesto->getAttributeLabel('puesto'),
                        'value' => $evaluacion->_puesto->nombre,
                ),   
                array(
                        'label' => $evaluacion->_colaborador->getAttributeLabel('colaborador'),
                        'value' => $evaluacion->_colaborador->nombrecompleto,
                ),                
	),
)); ?>
</div>

<?php echo CHtml::beginForm('','post',array('id'=>'formcompromisos'))?>
<?php echo $this->renderPartial('_formnuevoscompromisos', array('model'=>$evaluacion)); ?>

<div class="content_section_submit">        
                  <?php echo CHtml::submitButton('Guardar Compromisos',array('id'=>'btncompromiso', 'class'=>'sexybutton sexysimple sexylarge')); ?>                  
</div>

<?php echo CHtml::endForm()?>
