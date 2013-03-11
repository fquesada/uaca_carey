<?php
/* @var $this OrigenevaluacionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Origenevaluacions',
);

$this->menu=array(
	array('label'=>'Crear Origen de evaluación', 'url'=>array('create')),
	array('label'=>'Gestionar Origen de evaluación', 'url'=>array('admin')),
);
?>

<h1>Origen de evaluación</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
