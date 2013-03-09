<?php
/* @var $this ColaboradorController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Colaboradors',
);

$this->menu=array(
	array('label'=>'Crear Colaborador', 'url'=>array('create')),
	array('label'=>'Gestionar Colaboradores', 'url'=>array('admin')),
);
?>

<h1>Colaboradores</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
