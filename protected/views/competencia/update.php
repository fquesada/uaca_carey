<?php
/* @var $this CompetenciaController */
/* @var $model Competencia */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Crear Competencia', 'url'=>array('create')),
	array('label'=>'Gestionar Competencia', 'url'=>array('admin')),
);
?>

<h1>Actualizar Competencia</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>