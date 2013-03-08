<?php
/* @var $this PostulanteController */
/* @var $model Postulante */

$this->breadcrumbs=array(
	'Postulantes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Lista Postulantes', 'url'=>array('index')),
	array('label'=>'Gestionar Postulantes', 'url'=>array('admin')),
);
?>

<h1>Crear Postulante</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>