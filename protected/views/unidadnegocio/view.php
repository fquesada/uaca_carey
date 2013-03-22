<?php
/* @var $this UnidadnegocioController */
/* @var $model Unidadnegocio */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	$model->id,
);

$this->menu=array(
	//array('label'=>'List Unidadnegocio', 'url'=>array('index')),
	array('label'=>'Crear Unidad de Negocio', 'url'=>array('create')),
	array('label'=>'Actualizar Unidad de Negocio', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Unidad de Negocio', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Seguro que desea borrar este elemento?')),
	array('label'=>'Gestionar Unidad de Negocio', 'url'=>array('admin')),
);
?>

<h1>Ver Unidad de Negocio #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		'nombre',
		'descripcion',
		//'empresa',
		//'estado',
	),
)); ?>
