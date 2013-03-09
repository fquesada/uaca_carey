<?php
/* @var $this UsuarioController */
/* @var $model Usuario */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'usuario-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'contraseña actual'); ?>
		<?php echo $form->passwordField($model,'password_actual',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'password_actual'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'contraseña nueva'); ?>
		<?php echo $form->passwordField($model,'password_nueva',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'password_nueva'); ?>
	</div>
        
         <div class="row">
                <?php echo $form->labelEx($model,'confirmar contraseña'); ?>
                <?php echo $form->passwordField($model,'confirmarPassword',array('size'=>60,'maxlength'=>100,'value'=>'')); ?>
                <?php echo $form->error($model,'confirmarPassword'); ?>
        </div>
        
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->