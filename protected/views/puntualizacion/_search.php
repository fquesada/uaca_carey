<?php
/* @var $this PuntualizacionController */
/* @var $model Puntualizacion */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<!--	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>-->

	<div class="row">
		<?php echo $form->label($model,'puntualizacion'); ?>
		<?php echo $form->textField($model,'puntualizacion',array('size'=>60,'maxlength'=>800)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'indicadorpuntualizacion'); ?>
		<?php echo $form->textField($model,'indicadorpuntualizacion',array('size'=>60,'maxlength'=>800)); ?>
	</div>

<!--	<div class="row">
		<?php echo $form->label($model,'estado'); ?>
		<?php echo $form->textField($model,'estado'); ?>
	</div>-->

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search', array('class'=>'sexybutton sexysimple sexylarge')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->