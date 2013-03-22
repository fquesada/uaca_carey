<?php
/* @var $this OrigenevaluacionController */
/* @var $model Origenevaluacion */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Crear Origen de evaluación', 'url'=>array('create')),
	array('label'=>'Actualizar Origen de evaluación', 'url'=>array('update', 'id'=>$model->id)),
	//array('label'=>'Delete Origenevaluacion', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Seguro que desea borrar este elemento?')),
	array('label'=>'Gestionar Origen de evaluación', 'url'=>array('admin')),
);
?>

<h1>Ver Origen Evaluación #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'nombre',
	),
)); ?>
