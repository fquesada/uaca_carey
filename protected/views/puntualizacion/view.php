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
	array('label'=>'Eliminar Puntualización', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Seguro que desea borrar este elemento?')),
	array('label'=>'Gestionar Puntualización', 'url'=>array('admin')),
);
?>

<h1>Ver Puntualización #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'puntualizacion',
		'indicadorpuntualizacion',
	),
)); ?>
