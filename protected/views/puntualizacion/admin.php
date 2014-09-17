<?php
/* @var $this PuntualizacionController */
/* @var $model Puntualizacion */

$this->breadcrumbs=array(
	'Gestionar',
);

$this->menu=array(
	//array('label'=>'Crear Puntualización', 'url'=>array('create')),
);

?>

<h1>Gestionar Puntualización</h1>

<p>
Puede ingresar opcionalmente un operador comparativo (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>,
 <b>=</b>) al inicio de cada valor de búsqueda para especificar cómo se debe realizar la comparación.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'puntualizacion-grid',
	'dataProvider'=>$model->search(),
        'filter'=>$model,
	'template'=>"{pager}\n{items}\n{pager}\n{summary}",
	'columns'=>array(
		'puntualizacion',
		'indicadorpuntualizacion',
		array(
			'class'=>'CButtonColumn',
                        'template'=>'{view}{update}',
                        'buttons'=>array(
                            'update'=>array(
                                'label'=>'Actualizar',
                            ),
                        ),
		),
	),
)); ?>
