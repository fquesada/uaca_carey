<?php
/* @var $this MeritoController */
/* @var $model Merito */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
        'Actualizar',
);

$this->menu=array(
	array('label'=>'Crear Merito', 'url'=>array('create')),
	array('label'=>'Gestionar Merito', 'url'=>array('admin')),
);
?>

<h1>Actualizar Merito <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>