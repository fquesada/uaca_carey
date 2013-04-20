<?php
/* @var $this HistoricopuestoController */
/* @var $model Historicopuesto */

$this->breadcrumbs=array(
	'Historicopuestos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Historicopuesto', 'url'=>array('index')),
	array('label'=>'Create Historicopuesto', 'url'=>array('create')),
	array('label'=>'View Historicopuesto', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Historicopuesto', 'url'=>array('admin')),
);
?>

<h1>Update Historicopuesto <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>