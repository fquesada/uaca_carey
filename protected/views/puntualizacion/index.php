<?php
/* @var $this PuntualizacionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Puntualizacions',
);

$this->menu=array(
	array('label'=>'Create Puntualizacion', 'url'=>array('create')),
	array('label'=>'Manage Puntualizacion', 'url'=>array('admin')),
);
?>

<h1>Puntualizacions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
