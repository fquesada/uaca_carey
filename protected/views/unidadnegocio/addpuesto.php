<?php
/* @var $this UnidadnegocioController */
/* @var $model Unidadnegocio */
/* @var $form CActiveForm */
?>

<script>
    function seleccionarPuesto ()
    {
        var idpuesto = $.fn.yiiGridView.getSelection('puestoexistente-grid');
        
        
        
    }
</script>

    <?php
    $this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
        'Agregar puestos'
    );
    ?>
    <h1>Unidad de Negocio</h1>
    
    <?php $this->widget('zii.widgets.CDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                    'nombre',
                    'descripcion'		
            ),
    )); ?>
    
    <?php 
    $puesto = new Puesto();
    ?>
    
    <p></br> </br> </br> </p>
     <h1>Puestos disponibles</h1>
     
 <?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'puestoexistente-grid',
        //'selectableRows'=>1,
        //'selectionChanged'=>'seleccionarPuesto',
        'dataProvider'=>$puesto->addPuesto(),
	'filter'=>$puesto,
	'columns'=>array(
		'nombre',
		'descripcion',
                'codigo',
		array(
			'class'=>'CButtonColumn',
                        'htmlOptions'=>array('width'=>'20'),
                        'template'=>'{add}',
                        'buttons'=>array(
                            'add'=>array(
                                'label'=>'Agregar',
                                'imageUrl'=>  Yii::app()->request->baseUrl.'/images/icons/silk/add.png',
                                'url'=>'Yii::app()->createUrl("puesto/save", array("idpuesto"=>$data->id))'                          
                            )
                        )
		),
	),
    )); ?>
     
     
         <p></br> </br> </br> </p>
     <h1>Puestos asociados</h1>
     
     
    <?php 
    $unpuesto = new UnidadNegocioPuesto();
    ?>
    
    <?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'puestoasociado-grid',
        'dataProvider'=>$unpuesto->search($model->id),
	'columns'=>array(
		'puesto',
//		array(
//			'class'=>'CButtonColumn',
//                        'htmlOptions'=>array('width'=>'20'),
//                        'template'=>'{add}',
//                        'buttons'=>array(
//                            'add'=>array(
//                                'label'=>'Agregar',
//                                'imageUrl'=>  Yii::app()->request->baseUrl.'/images/icons/silk/add.png',
//                                'url'=>'Yii::app()->createUrl("unidadnegocio/addpuesto", array("id"=>$data->id))'                          
//                            )
//                        )
//		),
	),
    )); ?>