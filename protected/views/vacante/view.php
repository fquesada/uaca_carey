<?php
/* @var $this VacanteController */
/* @var $model Vacante */

$this->breadcrumbs=array(
	'Vacantes'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Vacante', 'url'=>array('index')),
	array('label'=>'Create Vacante', 'url'=>array('create')),
	array('label'=>'Update Vacante', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Vacante', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Vacante', 'url'=>array('admin')),
);
?>

<h1>View Vacante #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'unidadnegocio',
		'puesto',
		'periodo',
		'fechareclutamiento',
		'fechaseleccion',
	),
)); ?>
