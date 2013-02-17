<?php
/* @var $this VacanteController */
/* @var $model Vacante */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'unidadnegocio'); ?>
		<?php echo $form->textField($model,'unidadnegocio'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'puesto'); ?>
		<?php echo $form->textField($model,'puesto'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'periodo'); ?>
		<?php echo $form->textField($model,'periodo'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fechareclutamiento'); ?>
		<?php echo $form->textField($model,'fechareclutamiento'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fechaseleccion'); ?>
		<?php echo $form->textField($model,'fechaseleccion'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->