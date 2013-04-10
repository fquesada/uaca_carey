<?php
/* @var $this PuntajeController */
/* @var $model Puntaje */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	'Update',
);

$this->menu=array(
	array('label'=>'Crear Puntaje', 'url'=>array('create')),
	array('label'=>'Gestionar Puntaje', 'url'=>array('admin')),
);
?>

<h1>Actualizar Puntaje</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>