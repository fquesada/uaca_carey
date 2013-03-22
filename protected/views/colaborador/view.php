<?php
/* @var $this ColaboradorController */
/* @var $model Colaborador */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Crear Colaborador', 'url'=>array('create')),
	array('label'=>'Actualizar Colaborador', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Colaborador', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Seguro que desea borrar este elemento?')),
	array('label'=>'Gestionar Colaborador', 'url'=>array('admin')),
);
?>

<h1>Ver Colaborador #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'cedula',
		'nombre',
		'apellido1',
		'apellido2',
		'NombreUnidadNegocio',
		'NombrePuesto',
	),
)); ?>
