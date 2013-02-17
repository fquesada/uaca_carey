<?php
/* @var $this VacanteController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Vacantes',
);

$this->menu=array(
	array('label'=>'Create Vacante', 'url'=>array('create')),
	array('label'=>'Manage Vacante', 'url'=>array('admin')),
);
?>

<h1>Vacantes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
