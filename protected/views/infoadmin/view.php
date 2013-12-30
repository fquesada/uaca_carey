<?php
/* @var $this InfoadminController */
/* @var $model Infoadmin */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	'Ver',
);

$this->menu=array(
	array('label'=>'Actualizar Información', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Gestionar Información', 'url'=>array('admin')),
);
?>

<h1>Ver Información de Administrador</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'nombre',
		'correo',
	),
)); ?>
