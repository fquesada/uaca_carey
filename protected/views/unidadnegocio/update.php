<?php
/* @var $this UnidadnegocioController */
/* @var $model Unidadnegocio */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Crear Unidad de Negocio', 'url'=>array('create')),
	array('label'=>'Ver Unidad de Negocio', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Gestionar Unidad de Negocio', 'url'=>array('admin')),
);
?>

<h1>Actualizar Unidad de Negocio</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>