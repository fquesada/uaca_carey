<?php
/* @var $this UnidadnegocioController */
/* @var $model Unidadnegocio */
/* @var $form CActiveForm */
?>

<?php
    //CSS
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/messi.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/sexybuttons.css');
    
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
            ),
    )); ?>
    
    <?php Yii::app()->session['unidadnegocio']=$model->id;?>
    
    
    <?php echo CHtml::beginForm('','POST',array('id'=>'formpuesto'))?> 
    <?php 
    $puesto = new Puesto();
    ?>
    
    <p></br> </br> </br> </p>
     <h1>Paso 1: Puestos disponibles</h1>    
     <h5>Seleccione el o los puestos que desea agregar a la unidad de negocio y presione el botón "Asociar"</h5>
     
 <?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'puestoexistente-grid',
        'dataProvider'=>$puesto->addPuesto($model->id),
	'filter'=>$puesto,
        'template'=>"{pager}\n{items}\n{pager}\n{summary}",
	'columns'=>array(
                array(
                    'id' => 'puestoselect',
                    'class' => 'CCheckBoxColumn',
                    'selectableRows'=>'25',
                ),
		'codigo',
                'nombre',
                
	),
    )); ?>
      <?php echo CHtml::submitButton('Asociar',array('submit'=>'../save', 'class'=>'sexybutton sexysimple sexylarge'));?>

     
     <?php echo CHtml::endForm()?>
     
         <p></br> </br> </br> </p>
     <h1>Paso 2: Puestos asociados</h1>
     <h5>Verifique que el o los puestos hayan sido asociados correctamente</h5>
     
     
    <?php 
    $unpuesto = new UnidadNegocioPuesto();
    ?>
    
    <?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'puestoasociado-grid',
        'dataProvider'=>$unpuesto->search($model->id),
	'template'=>"{pager}\n{items}\n{pager}\n{summary}",
        'columns'=>array(
                    array(
                        'name'=>'CodigoPuesto',
                        'header'=>'Código'
                    ),
                    array(
                        'name'=>'NombrePuesto',
                        'header'=>'Nombre'
                    ),
                    array(
                            'class'=>'CButtonColumn',
                            'htmlOptions'=>array('width'=>'20'),
                            'template'=>'{delete}',
                            'buttons'=>array(
                                'delete'=>array(
                                    'url'=>'Yii::app()->createUrl("unidadnegociopuesto/delete", array("unidadnegocio"=>$data->unidadnegocio, "puesto"=>$data->puesto))',
                                )
                            )
                    ),
	),
        'afterAjaxUpdate'=>'js:function(id,data){$.fn.yiiGridView.update("puestoexistente-grid");}'
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
                autoclose: '4000',
                modal:true
            });
     </script>
     <?php endif;?>
         