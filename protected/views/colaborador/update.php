<?php
/* @var $this ColaboradorController */
/* @var $model Colaborador */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Crear Colaborador', 'url'=>array('create')),
	array('label'=>'Gestionar Colaborador', 'url'=>array('admin')),
);
?>

<h1>Actualizar Colaborador</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
