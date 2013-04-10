<?php
/* @var $this OrigenevaluacionController */
/* @var $model Origenevaluacion */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Crear Origen de evaluación', 'url'=>array('create')),
	array('label'=>'Ver Origen de evaluación', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Gestionar Origen de evaluación', 'url'=>array('admin')),
);
?>

<h1>Actualizar Origen de evaluación</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>