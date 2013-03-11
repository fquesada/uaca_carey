<?php
/* @var $this OrigenevaluacionController */
/* @var $model Origenevaluacion */

$this->breadcrumbs=array(
	'Origenevaluacions'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Lista Origen de evaluación', 'url'=>array('index')),
	array('label'=>'Crear Origen de evaluación', 'url'=>array('create')),
	array('label'=>'Modificar Origen de evaluación', 'url'=>array('update', 'id'=>$model->id)),
	//array('label'=>'Delete Origenevaluacion', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Gestionar Origen de evaluación', 'url'=>array('admin')),
);
?>

<h1>View Origenevaluacion #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
	),
)); ?>
