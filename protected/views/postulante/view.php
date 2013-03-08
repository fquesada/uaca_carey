<?php
/* @var $this PostulanteController */
/* @var $model Postulante */

$this->breadcrumbs=array(
	'Postulantes'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Lista Postulante', 'url'=>array('index')),
	array('label'=>'Crear Postulante', 'url'=>array('create')),
	array('label'=>'Modificar Postulante', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Postulante', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Gestionar Postulantes', 'url'=>array('admin')),
);
?>

<h1>Mostrar Postulante #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'cedula',
		'nombre',
		'apellido1',
		'apellido2',
		'estado',
	),
)); ?>
