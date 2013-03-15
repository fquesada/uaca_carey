<?php
/* @var $this PostulanteController */
/* @var $model Postulante */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Crear Postulante', 'url'=>array('create')),
	array('label'=>'Actualizar Postulante', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Postulante', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Seguro que desea borrar este elemento?')),
	array('label'=>'Gestionar Postulante', 'url'=>array('admin')),
);
?>

<h1>Ver Postulante #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'cedula',
		'nombre',
		'apellido1',
		'apellido2',
	),
)); ?>
