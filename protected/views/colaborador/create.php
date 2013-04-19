<?php
/* @var $this ColaboradorController */
/* @var $model Colaborador */

$this->breadcrumbs=array(
	'Gestionar'=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Gestionar Colaborador', 'url'=>array('admin')),
);
?>

<h1>Crear Colaborador</h1>



<?php echo $this->renderPartial('_form', array('model'=>$model, 'historial'=>$historial )); ?>
