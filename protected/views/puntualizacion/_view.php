<?php
/* @var $this PuntualizacionController */
/* @var $data Puntualizacion */
?>

<div class="view">

<!--	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />-->

	<b><?php echo CHtml::encode($data->getAttributeLabel('puntualizacion')); ?>:</b>
	<?php echo CHtml::encode($data->puntualizacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('indicadorpuntualizacion')); ?>:</b>
	<?php echo CHtml::encode($data->indicadorpuntualizacion); ?>
	<br />

<!--	<b><?php echo CHtml::encode($data->getAttributeLabel('estado')); ?>:</b>
	<?php echo CHtml::encode($data->estado); ?>
	<br />-->


</div>