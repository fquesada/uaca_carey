<?php
/* @var $this UnidadnegocioController */
/* @var $model Unidadnegocio */

$this->breadcrumbs=array(
	'Gestionar',
);

$this->menu=array(
	array('label'=>'Crear Unidad de Negocio', 'url'=>array('create')),
);

?>

<h1>Gestionar Unidad de Negocios</h1>

<p>
Puede ingresar opcionalmente un operador comparativo (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>,
 <b>=</b>) al inicio de cada valor de búsqueda para especificar cómo se debe realizar la comparación.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'unidadnegocio-grid',
	'dataProvider'=>$model->search(),
	'template'=>"{pager}\n{items}\n{pager}\n{summary}",
	'columns'=>array(
                'codigo',
		'nombre',
		array(
			'class'=>'CButtonColumn',
                        'htmlOptions'=>array('width'=>'70'),
                        'template'=>'{view}{update}{delete}{addpuestos}',
                        'buttons'=>array(
                            'addpuestos'=>array(
                                'label'=>'Agregar puestos',
                                'imageUrl'=>  Yii::app()->request->baseUrl.'/images/icons/silk/add.png',
                                'url'=>'Yii::app()->createUrl("unidadnegocio/addpuesto", array("id"=>$data->id))'                          
                            )
                        )
		),
	),
)); ?>
