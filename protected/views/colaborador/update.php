<?php
/* @var $this ColaboradorController */
/* @var $model Colaborador */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Crear Colaborador', 'url'=>array('create')),
	array('label'=>'Ver Colaborador', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Gestionar Colaborador', 'url'=>array('admin')),
);
?>

<h1>Actualizar Colaborador <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>