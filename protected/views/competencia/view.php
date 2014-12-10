<?php
/* @var $this CompetenciaController */
/* @var $model Competencia */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	'Ver',
);

$this->menu=array(
	array('label'=>'Crear Competencia', 'url'=>array('create')),
	array('label'=>'Actualizar Competencia', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Competencia', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Seguro que desea borrar este elemento?')),
	array('label'=>'Gestionar Competencia', 'url'=>array('admin')),
);
?>

<h1>Ver Competencia</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'competencia',
		'descripcion',
                'tipocomp',
		'pregunta',
	),
)); ?>
