<?php
/* @var $this UnidadnegocioController */
/* @var $model Unidadnegocio */
/* @var $form CActiveForm */
?>

<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/sexybuttons.css');
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'unidadnegocio-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'descripcion'); ?>
	</div>

<!--	<div class="row">
		<?php echo $form->labelEx($model,'empresa'); ?>
		<?php echo $form->textField($model,'empresa'); ?>
		<?php echo $form->error($model,'empresa'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'estado'); ?>
		<?php echo $form->textField($model,'estado'); ?>
		<?php echo $form->error($model,'estado'); ?>
	</div>-->

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', array('class'=>'sexybutton sexysimple sexylarge')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->