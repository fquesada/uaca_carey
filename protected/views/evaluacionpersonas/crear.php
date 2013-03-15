

<?php
/* @var $this EvaluacionpersonasController */
/* @var $model Evaluacionpersonas */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/evaluacionpersonas.js');

$this->breadcrumbs=array(
	'Evaluacion'=>array('admin'),
	'Crear',
);
?>

<h3>Crear proceso evaluacion</h3>


<?php echo CHtml::beginForm($this->createUrl('crearevaluacionpersona'))?>

<?php echo $this->renderPartial('_formevaluacionpersona', array('model'=>$model)); ?>

<?php echo $this->renderPartial('_habilidadespecial'); ?>

<div class="row buttons">        
        
                  <?php echo CHtml::submitButton('Crear proceso evaluacion',array('id'=>'btncrearevaluacionpersona', 'class'=>'sexybutton sexysimple sexylarge'));?>
</div>

<?php echo CHtml::endForm()?>
