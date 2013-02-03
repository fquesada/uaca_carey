<?php
/* @var $this ColaboradorController */
/* @var $model Colaborador */

$this->breadcrumbs=array(
	'Colaboradors'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Lista Colaboradores', 'url'=>array('index')),
	array('label'=>'Gestionar Colaboradores', 'url'=>array('admin')),
);
?>

<h1>Crear Colaborador</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>