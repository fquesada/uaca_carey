<?php
/* @var $this PonderacionController */
/* @var $model Ponderacion */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Gestionar Ponderación', 'url'=>array('admin')),
);
?>

<h1>Crear Ponderación</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>