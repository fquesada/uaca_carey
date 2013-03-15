<?php
/* @var $this PeriodoController */
/* @var $model Periodo */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Crear Periodo', 'url'=>array('create')),
	array('label'=>'Gestionar Periodo', 'url'=>array('admin')),
);
?>

<h1>Actualizar Periodo <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>