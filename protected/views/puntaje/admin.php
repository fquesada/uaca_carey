<?php
/* @var $this PuntajeController */
/* @var $model Puntaje */

$this->breadcrumbs=array(
	'Gestionar',
);

$this->menu=array(
	array('label'=>'Crear Puntaje', 'url'=>array('create')),
);

?>

<h1>Gestionar Puntajes</h1>

<p>
Puede ingresar opcionalmente un operador comparativo (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>,
 <b>=</b>) al inicio de cada valor de búsqueda para especificar cómo se debe realizar la comparación.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'puntaje-grid',
	'dataProvider'=>$model->search(),
	'template'=>"{pager}\n{items}\n{pager}\n{summary}",
	'columns'=>array(
		'valor',
                'descripcion',
		array(
			'class'=>'CButtonColumn',
                        'template'=>'{update}{delete}',
                        'buttons'=>array(
                            'update'=>array(
                                'label'=>'Actualizar',
                            ),
                        ),
                    
		),
	),
)); ?>
