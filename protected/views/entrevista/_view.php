<?php
/* @var $this EntrevistaController */
/* @var $data Entrevista */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vacante')); ?>:</b>
	<?php echo CHtml::encode($data->vacante); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('entrevistador')); ?>:</b>
	<?php echo CHtml::encode($data->entrevistador); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('entrevistado')); ?>:</b>
	<?php echo CHtml::encode($data->entrevistado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo')); ?>:</b>
	<?php echo CHtml::encode($data->tipo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estado')); ?>:</b>
	<?php echo CHtml::encode($data->estado); ?>
	<br />


</div>