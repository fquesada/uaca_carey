<?php
/* @var $this CompetenciaController */
/* @var $data Competencia */
?>

<div class="view">

<!--	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />-->

	<b><?php echo CHtml::encode($data->getAttributeLabel('competencia')); ?>:</b>
	<?php echo CHtml::encode($data->competencia); ?>
	<br />
        
        <b><?php echo CHtml::encode($data->getAttributeLabel('tipocompetencia')); ?>:</b>
	<?php echo CHtml::encode($data->tipocompetencia); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pregunta')); ?>:</b>
	<?php echo CHtml::encode($data->pregunta); ?>
	<br />

<!--	<b><?php echo CHtml::encode($data->getAttributeLabel('estado')); ?>:</b>
	<?php echo CHtml::encode($data->estado); ?>
	<br />-->


</div>