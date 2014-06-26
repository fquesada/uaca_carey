<?php
/* @var $this UnidadnegocioController */
/* @var $model Unidadnegocio */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	'Ver',
);

$this->menu=array(
	array('label'=>'Crear Unidad de Negocio', 'url'=>array('create')),
	array('label'=>'Actualizar Unidad de Negocio', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Unidad de Negocio', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Seguro que desea borrar este elemento?')),
	array('label'=>'Gestionar Unidad de Negocio', 'url'=>array('admin')),
);
?>

<h1>Ver Unidad de Negocio</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'nombre',
		'codigo',
	),
)); ?>
