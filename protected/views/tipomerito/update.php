<?php
/* @var $this TipomeritoController */
/* @var $model Tipomerito */

$this->breadcrumbs=array(
	'Gestionar'=>array('index'),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Crear Tipo de merito', 'url'=>array('create')),
	array('label'=>'Gestionar Tipo de merito', 'url'=>array('admin')),
);
?>

<h1>Actualizar Tipo de merito </h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>