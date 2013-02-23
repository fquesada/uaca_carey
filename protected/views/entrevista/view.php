<?php
/* @var $this EntrevistaController */
/* @var $model Entrevista */

$this->breadcrumbs=array(
	'Entrevistas'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Entrevista', 'url'=>array('index')),
	array('label'=>'Create Entrevista', 'url'=>array('create')),
	array('label'=>'Update Entrevista', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Entrevista', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Entrevista', 'url'=>array('admin')),
);
?>

<h1>View Entrevista #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'vacante',
		'fecha',
		'entrevistador',
		'entrevistado',
		'tipo',
		'estado',
	),
)); ?>
