<?php
/* @var $this PuestoController */
/* @var $model Puesto */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	'Ver',
);

$this->menu=array(
	array('label'=>'Crear Puesto', 'url'=>array('create')),
	array('label'=>'Actualizar Puesto', 'url'=>array('update', 'id'=>$model->id)),
	//array('label'=>'Eliminar Puesto', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Seguro que desea borrar este elemento?')),
	array('label'=>'Gestionar Puesto', 'url'=>array('admin')),
);
?>

<h1>Ver Puesto</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'nombre',
		'codigo',
		),
)); ?>
