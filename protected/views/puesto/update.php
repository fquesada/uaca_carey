<?php
/* @var $this PuestoController */
/* @var $model Puesto */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Actualizar',
);

$this->menu=array(
	//array('label'=>'Lista de Puestos', 'url'=>array('index')),
	array('label'=>'Crear Puesto', 'url'=>array('create')),
	array('label'=>'Ver Puesto', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Gestionar Puesto', 'url'=>array('admin')),
);
?>

<h1>Actualizar Puesto <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>