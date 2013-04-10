<?php
/* @var $this OrigenevaluacionController */
/* @var $model Origenevaluacion */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	'Ver',
);

$this->menu=array(
	array('label'=>'Crear Origen de evaluación', 'url'=>array('create')),
	array('label'=>'Actualizar Origen de evaluación', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Gestionar Origen de evaluación', 'url'=>array('admin')),
);
?>

<h1>Ver Origen Evaluación</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'nombre',
	),
)); ?>
