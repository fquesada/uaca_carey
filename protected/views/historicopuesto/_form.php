<?php
/* @var $this HistoricopuestoController */
/* @var $model Historicopuesto */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'historicopuesto-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'fechadesignacion'); ?>
		<?php echo $form->textField($model,'fechadesignacion'); ?>
		<?php echo $form->error($model,'fechadesignacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'colaborador'); ?>
		<?php echo $form->textField($model,'colaborador'); ?>
		<?php echo $form->error($model,'colaborador'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'puestoactual'); ?>
		<?php echo $form->textField($model,'puestoactual'); ?>
		<?php echo $form->error($model,'puestoactual'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'unidadnegocio'); ?>
		<?php echo $form->textField($model,'unidadnegocio'); ?>
		<?php echo $form->error($model,'unidadnegocio'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'puesto'); ?>
		<?php echo $form->textField($model,'puesto'); ?>
		<?php echo $form->error($model,'puesto'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->