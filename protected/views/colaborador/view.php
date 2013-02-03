<?php
/* @var $this ColaboradorController */
/* @var $model Colaborador */

$this->breadcrumbs=array(
	'Colaboradors'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Lista Colaboradores', 'url'=>array('index')),
	array('label'=>'Crear Colaborador', 'url'=>array('create')),
	array('label'=>'Modificar Colaborador', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Borrar Colaborador', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Gestionar Colaboradores', 'url'=>array('admin')),
);
?>

<h1>Mostrar Colaborador #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'cedula',
		'nombre',
		'apellido1',
		'apellido2',
		'fechanacimiento',
		'fechaedicion',
		'activo',
		'empresa',
		'puesto',
	),
)); ?>
