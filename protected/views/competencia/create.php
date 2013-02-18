<?php
/* @var $this CompetenciaController */
/* @var $model Competencia */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	'Crear',
);

$this->menu=array(
	//array('label'=>'List Competencia', 'url'=>array('index')),
	array('label'=>'Gestionar Competencia', 'url'=>array('admin')),
);
?>

<h1>Crear Competencia</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>