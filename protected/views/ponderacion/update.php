<?php
/* @var $this PonderacionController */
/* @var $model Ponderacion */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Crear Ponderación', 'url'=>array('create')),
	array('label'=>'Gestionar Ponderación', 'url'=>array('admin')),
);
?>

<h1>Actualizar Ponderación <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>