<?php
/* @var $this ColaboradorController */
/* @var $model Colaborador */

$this->breadcrumbs=array(
	'Gestionar',
);

$this->menu=array(
	array('label'=>'Crear Colaborador', 'url'=>array('create')),
        array('label'=>'Reintegrar Colaborador', 'url'=>array('activate'))
);

?>

<h1>Gestionar Colaborador</h1>

<p>
Puede ingresar opcionalmente un operador comparativo (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>,
 <b>=</b>) al inicio de cada valor de búsqueda para especificar cómo se debe realizar la comparación.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'colaborador-grid',
	'dataProvider'=>$model->search(TRUE),
	'filter'=>$model,
        'template'=>"{pager}{items}{pager}{summary}",
	'columns'=>array(
		'cedula',
		'nombre',
		'apellido1',
		'apellido2',
                'nombreunidadnegocioactual',
                'nombrepuestoactual',
		array(
			'class'=>'CButtonColumn',
                        'htmlOptions'=>array('width'=>'90'),
                        'template'=>'{view}{update}{delete}{gestionpuesto}',
                        'buttons'=>array(
                            'update'=>array(
                                'label'=>'Actualizar',
                            ),
                            'gestionpuesto'=>array(
                                'label'=>'Gestionar puesto',
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/icons/silk/page_white_wrench.png',
                                'url'=>'Yii::app()->createUrl("colaborador/gestionpuesto", array("id"=>$data->id))'
                                
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
            autoclose: '5000',
            modal:true
        });
 </script>
 <?php endif;?>

