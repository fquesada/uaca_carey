<?php
/* @var $this EvaluacionpersonasController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Evaluacionpersonases',
);

$this->menu=array(
	array('label'=>'Create Evaluacionpersonas', 'url'=>array('create')),
	array('label'=>'Manage Evaluacionpersonas', 'url'=>array('admin')),
);
?>

<h1>Evaluacionpersonases</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
