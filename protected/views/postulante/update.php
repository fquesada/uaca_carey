<?php
/* @var $this PostulanteController */
/* @var $model Postulante */

$this->breadcrumbs=array(
	'Postulantes'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Crear Postulante', 'url'=>array('create')),
	array('label'=>'Mostrar Postulante', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Gestionar Postulantes', 'url'=>array('admin')),
);
?>

<h1>Modificar Postulante <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>