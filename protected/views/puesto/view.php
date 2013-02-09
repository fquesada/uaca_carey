<?php
/* @var $this PuestoController */
/* @var $model Puesto */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	$model->id,
);

$this->menu=array(
	//array('label'=>'Lista de Puestos', 'url'=>array('index')),
	array('label'=>'Crear Puesto', 'url'=>array('create')),
	array('label'=>'Actualizar Puesto', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Puesto', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Gestionar Puesto', 'url'=>array('admin')),
);
?>

<h1>Ver Puesto #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		'nombre',
		'descripcion',
		'codigo',
		'unidadnegocio',
		//'estado',
	),
)); ?>
