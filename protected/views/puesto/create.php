<?php
/* @var $this PuestoController */
/* @var $model Puesto */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	'Crear',
);

$this->menu=array(
	//array('label'=>'Lista de Puestos', 'url'=>array('index')),
	array('label'=>'Gestionar Puesto', 'url'=>array('admin')),
);
?>

<h1>Crear Puesto</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>