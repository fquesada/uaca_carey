<?php
/* @var $this CompetenciaController */
/* @var $model Competencia */
/* @var $form CActiveForm */
?>

<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/sexybuttons.css');
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'competencia-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'competencia'); ?>
		<?php echo $form->textField($model,'competencia',array('size'=>60,'maxlength'=>400)); ?>
		<?php echo $form->error($model,'competencia'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textArea($model,'descripcion',array('style'=>'width: 375px; height: 100px;')); ?>
		<?php echo $form->error($model,'descripcion'); ?>
	</div>
        
        <div class="row">
                <?php echo $form->labelEx($model,'tipocompetencia'); ?>
                <?php echo $form->dropdownlist($model,'tipocompetencia',
                    CHtml::listData($model->findAll(),'tipocompetencia', 'tipocomp'),
                        array('empty' => 'Seleccione un tipo')
                );?>
        </div>

	<div class="row">
		<?php echo $form->labelEx($model,'pregunta'); ?>
		<?php echo $form->textArea($model,'pregunta',array('style'=>'width: 375px; height: 300px;')); ?>
		<?php echo $form->error($model,'pregunta'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', array('class'=>'sexybutton sexysimple sexylarge')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->