<?php
/* @var $this UnidadnegocioController */
/* @var $model Unidadnegocio */
/* @var $form CActiveForm */
?>

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
	'dataProvider'=>$puesto->search(),
	'filter'=>$puesto,
	'columns'=>array(
		'nombre',
		'descripcion',
                'codigo',
//		array(
//			'class'=>'CButtonColumn',
//                        'htmlOptions'=>array('width'=>'70'),
//                        'template'=>'{view}{update}{delete}{addpuestos}',
//                        'buttons'=>array(
//                            'addpuestos'=>array(
//                                'label'=>'Agregar puestos',
//                                'imageUrl'=>  Yii::app()->request->baseUrl.'/images/icons/silk/add.png',
//                                'url'=>'Yii::app()->createUrl("unidadnegocio/addpuesto", array("id"=>$data->id))'                          
//                            )
//                        )
//		),
	),
    )); ?>