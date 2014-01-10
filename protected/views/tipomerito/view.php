<?php
/* @var $this TipomeritoController */
/* @var $model Tipomerito */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
);

$this->menu=array(
	array('label'=>'Crear Tipo de merito', 'url'=>array('create')),
	array('label'=>'Actualizar Tipo de merito', 'url'=>array('update', 'id'=>$model->id)),
	//array('label'=>'Delete Tipomerito', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Gestionar Tipo de merito', 'url'=>array('admin')),
);
?>

<h1>Ver Tipo de merito</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'nombre',
	),
)); ?>
