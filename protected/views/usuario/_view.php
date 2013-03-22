<?php
/* @var $this UsuarioController */
/* @var $data Usuario */
$fechamysql = CommonFunctions::datemysqltophp($model->fechacreacion)
?>

<div class="view">


	<b><?php echo CHtml::encode($data->getAttributeLabel('login')); ?>:</b>
	<?php echo CHtml::encode($data->login); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('password')); ?>:</b>
	<?php echo CHtml::encode($data->password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fechacreacion')); ?>:</b>
	<?php echo CHtml::encode($data->$fechamysql); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('empresa')); ?>:</b>
	<?php echo CHtml::encode($data->empresa); ?>
	<br />


</div>