<?php
/* @var $this CompetenciaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Competencias',
);

$this->menu=array(
	array('label'=>'Create Competencia', 'url'=>array('create')),
	array('label'=>'Manage Competencia', 'url'=>array('admin')),
);
?>

<h1>Competencias</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
