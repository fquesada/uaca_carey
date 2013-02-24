<?php
/* @var $this PuestoController */
/* @var $model Puesto */
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
        'Agregar competencias'
    );
    ?>
    <h1>Puesto</h1>
    
    <?php $this->widget('zii.widgets.CDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                    'codigo',
                    'nombre',
                    'descripcion'		
            ),
    )); ?>
    
    <?php Yii::app()->session['puesto']=$model->id;?>
    
    <?php 
    $competencia = new Competencia();
    ?>
    
    <p></br> </br> </br> </p>
   
 <h1>Competencias disponibles</h1>
 
 <?php echo CHtml::beginForm('','POST',array('id'=>'formpeso'))?> 
 
 <?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'competenciaexistente-grid',
        'selectableRows'=>1,
        'dataProvider'=>$competencia->addcompetencia($model->id),
	'filter'=>$competencia,
	'columns'=>array(
                array(
                    'id' => 'compselect',
                    'class' => 'CCheckBoxColumn'
                ),
		'competencia',
		'descripcion',
	),
    )); ?>
     
     <?php
        echo CHtml::dropdownlist('peso','0',CHtml::listData(Ponderacion::model()->findAll(),'idponderacion','valor'), array('empty'=>'Seleccione el peso sobre el puesto que desea asignar a la competencia'))
     ?>
 
    <br></br>
     <?php echo CHtml::submitButton('Asociar',array('submit'=>'../save', 'class'=>'sexybutton sexysimple sexylarge'));
     //echo CHtml::ajaxSubmitButton('Asociar',Yii::app()->createUrl( 'puesto/save'),
        //array('type'=>'POST', 'data'=>array('peso'=>'3'))); ?>
     
     <?php echo CHtml::endForm()?>
     
    
         <p></br> </br> </br> </p>
     <h1>Competencias asociadas</h1>
     
     
    <?php 
    $puestocomp = new Competencia();
    ?>
    
    <?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'competenciaasociado-grid',
        'dataProvider'=>$puestocomp->competenciaasociados($model->id),
	'columns'=>array(
		'competencia',
		'descripcion',
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