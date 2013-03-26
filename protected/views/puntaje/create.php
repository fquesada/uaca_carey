<?php
/* @var $this PuntajeController */
/* @var $model Puntaje */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Gestionar Puntaje', 'url'=>array('admin')),
);
?>

<h1>Crear Puntaje</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>