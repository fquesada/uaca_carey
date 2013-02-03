<?php
/* @var $this ColaboradorController */
/* @var $model Colaborador */

$this->breadcrumbs=array(
	'Colaboradors'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Lista Colaboradores', 'url'=>array('index')),
	array('label'=>'Crear Colaborador', 'url'=>array('create')),
	array('label'=>'Mostrar Colaborador', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Gestionar Colaboradores', 'url'=>array('admin')),
);
?>

<h1>Modificar Colaborador <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>