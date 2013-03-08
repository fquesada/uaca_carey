<?php
/* @var $this OrigenevaluacionController */
/* @var $model Origenevaluacion */

$this->breadcrumbs=array(
	'Origenevaluacions'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Lista Origen de evaluación', 'url'=>array('index')),
	array('label'=>'Crear Origen de evaluación', 'url'=>array('create')),
	array('label'=>'Mostrar Origen de evaluación', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Gestionar Origen de evaluación', 'url'=>array('admin')),
);
?>

<h1>Modificar Origen de evaluación <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>