<?php
/* @var $this MeritoController */
/* @var $model Merito */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	'Ver',
);

$this->menu=array(
	array('label'=>'Crear Merito', 'url'=>array('create')),
	array('label'=>'Actualizar Merito', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Merito', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Gestionar Merito', 'url'=>array('admin')),
);
?>

<h1>Ver Merito</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'tipomerito',
		'ponderacion',
		'puesto',
		'descripcion',
	),
)); ?>
