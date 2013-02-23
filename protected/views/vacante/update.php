<?php
/* @var $this VacanteController */
/* @var $model Vacante */

$this->breadcrumbs=array(
	'Vacantes'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Vacante', 'url'=>array('index')),
	array('label'=>'Create Vacante', 'url'=>array('create')),
	array('label'=>'View Vacante', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Vacante', 'url'=>array('admin')),
);
?>

<h1>Update Vacante <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>