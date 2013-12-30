<?php
/* @var $this InfoadminController */
/* @var $model Infoadmin */

$this->breadcrumbs=array(
	'Gestionar',
);

$this->menu=array(
	
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('infoadmin-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Gestionar Información del Administrador</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'infoadmin-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'nombre',
		'correo',
		array(
			'class'=>'CButtonColumn',
                        'template'=>'{update}',
		),
	),
)); ?>
