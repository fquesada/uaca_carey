<?php
/* @var $this UnidadnegocioController */
/* @var $model Unidadnegocio */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	'Crear',
);

$this->menu=array(
	//array('label'=>'List Unidadnegocio', 'url'=>array('index')),
	array('label'=>'Gestionar Unidad de Negocio', 'url'=>array('admin')),
);
?>

<h1>Crear Unidad de Negocio</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>