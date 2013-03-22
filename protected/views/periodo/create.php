<?php
/* @var $this PeriodoController */
/* @var $model Periodo */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Gestionar Periodo', 'url'=>array('admin')),
);
?>

<h1>Crear Periodo</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>