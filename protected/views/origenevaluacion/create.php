<?php
/* @var $this OrigenevaluacionController */
/* @var $model Origenevaluacion */

$this->breadcrumbs=array(
	'Origenevaluacions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Lista Origen de evaluacion', 'url'=>array('index')),
	array('label'=>'Gestionar Origen de evaluación', 'url'=>array('admin')),
);
?>

<h1>Crear Origen de evaluación</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>