<?php
/* @var $this OrigenevaluacionController */
/* @var $model Origenevaluacion */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Gestionar Origen de evaluación', 'url'=>array('admin')),
);
?>

<h1>Crear Origen de evaluación</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>