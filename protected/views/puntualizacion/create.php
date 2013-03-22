<?php
/* @var $this PuntualizacionController */
/* @var $model Puntualizacion */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Gestionar Puntualización', 'url'=>array('admin')),
);
?>

<h1>Crear Puntualización</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>