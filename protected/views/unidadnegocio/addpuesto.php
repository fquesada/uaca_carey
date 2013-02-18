<?php
/* @var $this UnidadnegocioController */
/* @var $model Unidadnegocio */
/* @var $form CActiveForm */
?>

<?php
    //CSS
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/messi.min.css');
    
    //JS
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/messi.min.js');
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
    
    <?php Yii::app()->session['unidadnegocio']=$model->id;?>
    
    <?php 
    $puesto = new Puesto();
    ?>
    
    <p></br> </br> </br> </p>
     <h1>Puestos disponibles</h1>
     
 <?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'puestoexistente-grid',
        //'selectableRows'=>1,
        //'selectionChanged'=>'seleccionarPuesto',
        'dataProvider'=>$puesto->addPuesto($model->id),
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
                                'url'=>'Yii::app()->createUrl("unidadnegocio/save", array("idpuesto"=>$data->id))',
                            )
                        )
		),
	),
    )); ?>
     
     
         <p></br> </br> </br> </p>
     <h1>Puestos asociados</h1>
     
     
    <?php 
    $unpuesto = new Puesto();
    ?>
    
    <?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'puestoasociado-grid',
        'dataProvider'=>$unpuesto->puestosasociados($model->id),
	'columns'=>array(
		'nombre',
		'descripcion',
                'codigo',
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
         