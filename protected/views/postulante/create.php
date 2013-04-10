<?php
/* @var $this PostulanteController */
/* @var $model Postulante */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Gestionar Postulantes', 'url'=>array('admin')),
);
?>

<h1>Crear Postulante</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>