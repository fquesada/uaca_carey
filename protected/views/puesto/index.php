<?php
/* @var $this PuestoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Puestos',
);

$this->menu=array(
	array('label'=>'Crear Puesto', 'url'=>array('create')),
	array('label'=>'Gestionar Puesto', 'url'=>array('admin')),
);
?>

<h1>Puestos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
