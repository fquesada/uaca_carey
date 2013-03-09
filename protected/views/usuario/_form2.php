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
		<?php echo $form->labelEx($model,'login'); ?>
		<?php echo $form->textField($model,'login',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'login'); ?>
	</div>

	<div class="row">		
		<?php echo $form->hiddenField($model,'password',array('value'=>$model->password)); ?>
	</div>

	<div class="row">
		<?php echo $form->hiddenField($model,'fechacreacion',array('value'=>$model->fechacreacion)); ?>	
	</div>

	<div class="row">
		<?php echo $form->hiddenField($model,'estado',array('value'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->hiddenField($model,'empresa',array('value'=>1)); ?>
	</div>
        
        <div class="row">
                <?php echo $form->labelEx($model,'colaborador'); ?>
                <?php echo $form->dropDownList($model,'colaborador', CHtml::listData(Colaborador::model()->findAll(),'id','nombre'),array('empty' => 'Selecione un colaborador')); ?>
        </div>
        
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->