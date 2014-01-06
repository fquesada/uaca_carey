<?php
/* @var $this MeritoController */
/* @var $data Merito */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipomerito')); ?>:</b>
	<?php echo CHtml::encode($data->tipomerito); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ponderacion')); ?>:</b>
	<?php echo CHtml::encode($data->ponderacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('puesto')); ?>:</b>
	<?php echo CHtml::encode($data->puesto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />


</div>