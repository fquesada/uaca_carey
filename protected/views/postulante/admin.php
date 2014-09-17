<?php
/* @var $this PostulanteController */
/* @var $model Postulante */

$this->breadcrumbs=array(
	'Gestionar',
);

$this->menu=array(
	array('label'=>'Crear Postulante', 'url'=>array('create')),
);

?>

<h1>Gestionar Postulantes</h1>

<p>
Puede ingresar opcionalmente un operador comparativo (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>,
 <b>=</b>) al inicio de cada valor de búsqueda para especificar cómo se debe realizar la comparación.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'postulante-grid',
	'dataProvider'=>$model->search(),
        'filter'=>$model,
	'template'=>"{pager}\n{items}\n{pager}\n{summary}",
	'columns'=>array(
		'cedula',
		'nombre',
		'apellido1',
		'apellido2',
		array(
			'class'=>'CButtonColumn',
                        'buttons'=>array(
                            'update'=>array(
                                'label'=>'Actualizar',
                            ),
                        ),
		),
	),
)); ?>
