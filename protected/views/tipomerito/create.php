<?php
/* @var $this TipomeritoController */
/* @var $model Tipomerito */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Gestionar Tipo de merito', 'url'=>array('admin')),
);
?>

<h1>Crear Tipo de merito</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>