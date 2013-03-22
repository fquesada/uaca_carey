<?php
/* @var $this OrigenevaluacionController */
/* @var $model Origenevaluacion */

$this->breadcrumbs=array(
	'Gestionar',
);

$this->menu=array(
	array('label'=>'Crear Origen de evaluación', 'url'=>array('create')),
);

?>

<h1>Gestionar Origen de evaluación</h1>

<p>
Puede ingresar opcionalmente un operador comparativo (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>,
 <b>=</b>) al inicio de cada valor de búsqueda para especificar cómo se debe realizar la comparación.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'origenevaluacion-grid',
	'dataProvider'=>$model->search(),
        'template'=>"{pager}\n{items}\n{pager}\n{summary}",
	'columns'=>array(
		'nombre',
		array(
			'class'=>'CButtonColumn',
                        'template'=>'{view}{update}',
		),
	),
)); ?>
