<?php
/* @var $this VacanteController */
/* @var $model Vacante */

$this->breadcrumbs=array(
	'Vacantes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Vacante', 'url'=>array('index')),
	array('label'=>'Manage Vacante', 'url'=>array('admin')),
);
?>

<h1>Create Vacante</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>