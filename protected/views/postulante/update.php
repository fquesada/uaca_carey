<?php
/* @var $this PostulanteController */
/* @var $model Postulante */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Crear Postulante', 'url'=>array('create')),
	array('label'=>'Mostrar Postulante', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Gestionar Postulantes', 'url'=>array('admin')),
);
?>

<h1>Actualizar Postulante</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>