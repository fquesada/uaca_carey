<?php
/* @var $this OrigenevaluacionController */
/* @var $model Origenevaluacion */
/* @var $form CActiveForm */
?>

<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/sexybuttons.css');
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>45,'maxlength'=>45)); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Buscar', array('class'=>'sexybutton sexysimple sexylarge')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->