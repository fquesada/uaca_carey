<?php
/* @var $this MeritoController */
/* @var $model Merito */

$this->breadcrumbs=array(
	'Gestionar',
);

$this->menu=array(
	array('label'=>'Crear Merito', 'url'=>array('create')),
);

?>

<h1>Gestionar Meritos</h1>

<p>
Puede ingresar opcionalmente un operador comparativo (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>,
 <b>=</b>) al inicio de cada valor de búsqueda para especificar cómo se debe realizar la comparación.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'merito-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
                'NombreTipoMerito',
		'NombrePuesto',
      		'ponderacion',
                'descripcion',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
