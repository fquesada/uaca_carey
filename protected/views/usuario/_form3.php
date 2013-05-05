<?php
/* @var $this UsuarioController */
/* @var $model Usuario */
/* @var $form CActiveForm */
?>

<?php
Yii::app()->clientScript->registerCoreScript('jquery');
?>

 <?php if($this->ObtenerEstadoPassword() == false):?>
     <script type="text/javascript">
            new Messi("Debe cambiar la contraseña antes de utilizar el sistema",
            { title: "Cambio inical de contraseña",
                titleClass: "info",
                buttons: [{id: 0, label: 'Close', val: 'X'}],
                modal:true         
            });
     </script>
     <?php endif;?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'usuario-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos con <span class="required">*</span> son requeridos.</p>

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
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar', array('class'=>'sexybutton sexysimple sexy large')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->