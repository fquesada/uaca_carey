<?php
/* @var $this ColaboradorController */
/* @var $model Colaborador */
/* @var $form CActiveForm */
$unidad = $model->unidadnegocio;
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'colaborador-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'cedula'); ?>
		<?php echo $form->textField($model,'cedula'); ?>
		<?php echo $form->error($model,'cedula'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'apellido1'); ?>
		<?php echo $form->textField($model,'apellido1',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'apellido1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'apellido2'); ?>
		<?php echo $form->textField($model,'apellido2',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'apellido2'); ?>
	</div>

	<div class="row">
		<?php echo $form->hiddenField($model,'estado',array('value'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'unidadnegocio'); ?>
		<?php echo $form->dropDownList($model,'unidadnegocio', CHtml::listData(UnidadNegocio::model()->findAll(),'id','nombre'),array('empty' => 'Seleccione una unidad de negocio')); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'puesto'); ?>
		<?php echo $form->dropDownList($model,'puesto', CHtml::listData(UnidadNegocioPuesto::model()->findAllByAttributes(array('unidadnegocio' => $unidad)),'id', 'nombre'),array('empty' => 'Selecione un puesto')) ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->