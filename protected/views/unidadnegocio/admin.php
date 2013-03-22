<?php
/* @var $this UnidadnegocioController */
/* @var $model Unidadnegocio */

$this->breadcrumbs=array(
	'Gestionar',
);

$this->menu=array(
	//array('label'=>'List Unidadnegocio', 'url'=>array('index')),
	array('label'=>'Crear Unidad de Negocio', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('unidadnegocio-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Gestionar Unidad de Negocios</h1>

<p>
Puede ingresar opcionalmente un operador comparativo (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>,
 <b>=</b>) al inicio de cada valor de búsqueda para especificar cómo se debe realizar la comparación.
</p>

<?php echo CHtml::link('Busqueda Avanzada','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'unidadnegocio-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		'nombre',
		'descripcion',
		//'empresa',
		//'estado',
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
