<?php
/* @var $this PuntualizacionController */
/* @var $model Puntualizacion */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Crear Puntualización', 'url'=>array('create')),
	array('label'=>'Ver Puntualización', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Gestionar Puntualización', 'url'=>array('admin')),
);
?>

<h1>Actualizar Puntualización <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>