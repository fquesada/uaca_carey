<?php
/* @var $this CompetenciaController */
/* @var $model Competencia */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Actualizar',
);

$this->menu=array(
	//array('label'=>'List Competencia', 'url'=>array('index')),
	array('label'=>'Crear Competencia', 'url'=>array('create')),
	array('label'=>'Ver Competencia', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Gestionar Competencia', 'url'=>array('admin')),
);
?>

<h1>Actualizar Competencia <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>