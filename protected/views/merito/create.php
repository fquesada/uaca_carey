<?php
/* @var $this MeritoController */
/* @var $model Merito */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	'Crear ',
);

$this->menu=array(
	array('label'=>'Gestionar Merito', 'url'=>array('admin')),
);
?>

<h1>Crear Merito</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>