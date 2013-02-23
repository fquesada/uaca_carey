<?php
/* @var $this EntrevistaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Entrevistas',
);

$this->menu=array(
	array('label'=>'Create Entrevista', 'url'=>array('create')),
	array('label'=>'Manage Entrevista', 'url'=>array('admin')),
);
?>

<h1>Entrevistas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
