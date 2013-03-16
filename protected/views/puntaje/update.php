<?php
/* @var $this PuntajeController */
/* @var $model Puntaje */

$this->breadcrumbs=array(
	'Puntajes'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Crear Puntaje', 'url'=>array('create')),
	array('label'=>'Gestionar Puntaje', 'url'=>array('admin')),
);
?>

<h1>Actualizar Puntaje <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>