<?php
/* @var $this CompetenciaController */
/* @var $model Competencia */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	$model->id,
);

$this->menu=array(
	//array('label'=>'List Competencia', 'url'=>array('index')),
	array('label'=>'Crear Competencia', 'url'=>array('create')),
	array('label'=>'Actualizar Competencia', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Competencia', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Seguro que desea borrar este elemento?')),
	array('label'=>'Gestionar Competencia', 'url'=>array('admin')),
);
?>

<h1>Ver Competencia #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		'competencia',
		'descripcion',
		'pregunta',
		//'estado',
	),
)); ?>
