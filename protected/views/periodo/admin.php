<?php
/* @var $this PeriodoController */
/* @var $model Periodo */

$this->breadcrumbs=array(
	'Gestionar',
);

$this->menu=array(
	array('label'=>'Crear Periodo', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('periodo-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Gestionar Periodo</h1>

<p>
Puede ingresar opcionalmente un operador comparativo (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>,
 <b>=</b>) al inicio de cada valor de búsqueda para especificar cómo se debe realizar la comparación.
</p>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'periodo-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'nombre',
		array(
			'class'=>'CButtonColumn',
                        'template'=>'{update}{delete}',
		),
	),
)); ?>
