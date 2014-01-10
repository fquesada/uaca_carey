<?php
/* @var $this MeritoController */
/* @var $model Merito */
/* @var $form CActiveForm */
?>

<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/sexybuttons.css');
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'merito-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
                <?php echo $form->labelEx($model,'tipomerito'); ?>
                <?php echo CHtml::activeDropDownList($model,'tipomerito',CHtml::listData(Tipomerito::model()->findAll(array('order'=>'id')), 'id', 'nombre'), array ('empty'=>'Seleccione un tipo'));?>
		<?php echo $form->error($model,'tipomerito'); ?>
        </div>  

	<div class="row">
		<?php echo $form->labelEx($model,'ponderacion'); ?>
		<?php echo $form->textField($model,'ponderacion'); ?>
		<?php echo $form->error($model,'ponderacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'puesto'); ?>
                <?php echo CHtml::activeDropDownList($model,'puesto',CHtml::listData(Puesto::model()->findAll(array('order'=>'id')), 'id', 'nombre'), array ('empty'=>'Seleccione un puesto'));?>
		<?php echo $form->error($model,'puesto'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>800)); ?>
		<?php echo $form->error($model,'descripcion'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', array('class'=>'sexybutton sexysimple sexylarge'));?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->