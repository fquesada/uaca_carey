<?php
/* @var $this PuntualizacionController */
/* @var $model Puntualizacion */
/* @var $form CActiveForm */
?>

<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/sexybuttons.css');
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'puntualizacion-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'puntualizacion'); ?>
		<?php echo $form->textArea($model,'puntualizacion', array('width'=>386, 'height'=>166)); ?>
		<?php echo $form->error($model,'puntualizacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'indicadorpuntualizacion'); ?>
		<?php echo $form->textField($model,'indicadorpuntualizacion',array('size'=>60,'maxlength'=>800)); ?>
		<?php echo $form->error($model,'indicadorpuntualizacion'); ?>
	</div>

<!--	<div class="row">
		<?php echo $form->labelEx($model,'estado'); ?>
		<?php echo $form->textField($model,'estado'); ?>
		<?php echo $form->error($model,'estado'); ?>
	</div>-->

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', array('class'=>'sexybutton sexysimple sexylarge')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->