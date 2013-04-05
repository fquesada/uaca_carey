<?php
/* @var $this PuestoController */
/* @var $model Puesto */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Crear Puesto', 'url'=>array('create')),
	array('label'=>'Ver Puesto', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Gestionar Puesto', 'url'=>array('admin')),
);
?>

<h1>Actualizar Puesto</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>