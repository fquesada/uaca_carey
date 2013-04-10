<?php
/* @var $this PonderacionController */
/* @var $model Ponderacion */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Crear Ponderación', 'url'=>array('create')),
	array('label'=>'Gestionar Ponderación', 'url'=>array('admin')),
);
?>

<h1>Actualizar Ponderación</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>