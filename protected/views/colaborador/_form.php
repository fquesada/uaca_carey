<?php
/* @var $this ColaboradorController */
/* @var $model Colaborador */
/* @var $form CActiveForm */
?>

<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/sexybuttons.css');
?>


<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'colaborador-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos con  <span class="required">*</span> son requeridos.</p>

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
		<?php echo $form->labelEx($model,'unidadnegocio'); ?>
		<?php echo $form->dropDownList($model,'unidadnegocio', CHtml::listData(UnidadNegocio::model()->findAllByAttributes(array('estado' => '1')),'id','nombre'),array('empty' => 'Seleccione una unidad de negocio',
                            'ajax'=> array('type'=>'POST',
                                                            'url'=>CController::createUrl('colaborador/getpuestos'),
                                                            'update'=> '#'.CHtml::activeId($model,'puesto'),
                                                            
                                                            )
                                                      )
                            ); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'puesto'); ?>
		<?php echo $form->dropDownList($model,'puesto',CHtml::listData(Puesto::model()->findAllByAttributes(array('estado' => '1')),'id','nombre'),array('empty'=>'Seleccione un puesto')) ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', array('class'=>'sexybutton sexysimple sexylarge'));?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->