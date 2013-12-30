<?php
/* @var $this InfoadminController */
/* @var $model Infoadmin */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Gestionar Información', 'url'=>array('admin')),
);
?>

<h1>Actualizar Información del Administrador</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>