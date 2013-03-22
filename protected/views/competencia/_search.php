<?php
/* @var $this CompetenciaController */
/* @var $model Competencia */
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

<!--	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>-->

	<div class="row">
		<?php echo $form->label($model,'competencia'); ?>
		<?php echo $form->textField($model,'competencia',array('size'=>60,'maxlength'=>400)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>800)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pregunta'); ?>
		<?php echo $form->textField($model,'pregunta',array('size'=>60,'maxlength'=>1500)); ?>
	</div>

<!--	<div class="row">
		<?php echo $form->label($model,'estado'); ?>
		<?php echo $form->textField($model,'estado'); ?>
	</div>-->

	<div class="row buttons">
		<?php echo CHtml::submitButton('Buscar', array('class'=>'sexybutton sexysimple sexylarge')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->