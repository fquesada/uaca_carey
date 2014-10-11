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
		'nombre',
                'codigo',
		array(
			'class'=>'CButtonColumn',
                        'htmlOptions'=>array('width'=>'70'),
                        'template'=>'{view}{update}{addpuestos}',
                        'buttons'=>array(
                            'update'=>array(
                                'label'=>'Actualizar',
                            ),
                            'addpuestos'=>array(
                                'label'=>'Agregar puestos',
                                'imageUrl'=>  Yii::app()->request->baseUrl.'/images/icons/silk/page_white_add.png',
                                'url'=>'Yii::app()->createUrl("unidadnegocio/addpuesto", array("id"=>$data->id))'                          
                            )
                        )
		),
	),
)); ?>

 <?php if(Yii::app()->user->hasFlash('success')):?>
 <script type="text/javascript">
      new Messi('<?php echo Yii::app()->user->getFlash('success'); ?>',
        { title: 'Éxito.',
            titleClass: 'success',
            autoclose: '4000',
            modal:true
        });
 </script>
 <?php endif;?>

 <?php if(Yii::app()->user->hasFlash('error')):?>
 <script type="text/javascript">
      new Messi('<?php echo Yii::app()->user->getFlash('error'); ?>',
        { title: 'Error',
            titleClass: 'error',
            modal:true
        });
 </script>
 <?php endif;?>
