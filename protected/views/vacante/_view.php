<?php
/* @var $this VacanteController */
/* @var $data Vacante */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unidadnegocio')); ?>:</b>
	<?php echo CHtml::encode($data->unidadnegocio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('puesto')); ?>:</b>
	<?php echo CHtml::encode($data->puesto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('periodo')); ?>:</b>
	<?php echo CHtml::encode($data->periodo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fechareclutamiento')); ?>:</b>
	<?php echo CHtml::encode($data->fechareclutamiento); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fechaseleccion')); ?>:</b>
	<?php echo CHtml::encode($data->fechaseleccion); ?>
	<br />


</div>