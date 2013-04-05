<?php
/* @var $this CompetenciaController */
/* @var $model Competencia */

$this->breadcrumbs=array(
	'Gestionar',
);

$this->menu=array(
	array('label'=>'Crear Competencia', 'url'=>array('create')),
);

?>

<h1>Gestionar Competencia</h1>

<p>
Puede ingresar opcionalmente un operador comparativo (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>,
 <b>=</b>) al inicio de cada valor de búsqueda para especificar cómo se debe realizar la comparación.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'competencia-grid',
	'dataProvider'=>$model->search(),
        'filter'=>$model,
        'template' => "{pager}\n{items}\n{pager}\n{summary}",
	'columns'=>array(
		'competencia',
		'descripcion',
		'pregunta',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
