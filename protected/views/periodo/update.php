<?php
/* @var $this PeriodoController */
/* @var $model Periodo */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Crear Periodo', 'url'=>array('create')),
	array('label'=>'Gestionar Periodo', 'url'=>array('admin')),
);
?>

<h1>Actualizar Periodo</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>