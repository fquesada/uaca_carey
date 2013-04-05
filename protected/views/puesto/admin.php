<?php
/* @var $this PuestoController */
/* @var $model Puesto */

$this->breadcrumbs=array(
	'Gestionar',
);

$this->menu=array(
	array('label'=>'Crear Puesto', 'url'=>array('create')),
);

?>

<h1>Gestionar Puesto</h1>

<p>
Puede ingresar opcionalmente un operador comparativo (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>,
 <b>=</b>) al inicio de cada valor de búsqueda para especificar cómo se debe realizar la comparación.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'puesto-grid',
	'dataProvider'=>$model->search(),
        'filter'=>$model,
	'template'=>"{pager}\n{items}\n{pager}\n{summary}",
	'columns'=>array(
		'nombre',
		'descripcion',
		'codigo',
		array(
			'class'=>'CButtonColumn',
                        'htmlOptions'=>array('width'=>'90'),
                        'template'=>'{view}{update}{delete}{addcompetence}{addpuntualizacion}',
                        'buttons'=>array(
                            'addcompetence'=>array(
                                'label'=>'Agregar competencias',
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/icons/silk/brick_add.png',
                                'url'=>'Yii::app()->createUrl("puesto/addcompetence", array("id"=>$data->id))'
                                
                            ),
                            'addpuntualizacion'=>array(
                                'label'=>'Agregar puntualizaciones',
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/icons/silk/book_add.png',
                                'url'=>'Yii::app()->createUrl("puesto/addpuntualizacion", array("id"=>$data->id))'
                                
                            ),                            
                        )
                       
		),
	),
)); ?>
