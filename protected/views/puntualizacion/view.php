<?php
/* @var $this PuntualizacionController */
/* @var $model Puntualizacion */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Crear Puntualización', 'url'=>array('create')),
	array('label'=>'Actualizar Puntualización', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Gestionar Puntualización', 'url'=>array('admin')),
);
?>

<h1>Ver Puntualización</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'puntualizacion',
		'indicadorpuntualizacion',
	),
)); ?>
