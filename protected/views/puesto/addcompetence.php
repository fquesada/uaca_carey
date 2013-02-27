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
//<?php
//    Yii::app()->clientScript->registerScript('actualizar', "
//    $('.competenciaasociado-grid').update(function(){
//            $.fn.yiiGridView.update('competenciaasociado-grid');
//            return false;
//    });
//    ");
//?>

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
 <h5>Seleccione la competencia y el peso correspondiente que desea agregar al puesto y presione el botón "Asociar"</h5>
 
 <?php echo CHtml::beginForm('','POST',array('id'=>'formpeso'))?> 
 
 <?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'competenciaexistente-grid',
        'selectableRows'=>1,
        'dataProvider'=>$competencia->addcompetencia($model->id),
	'filter'=>$competencia,
	'columns'=>array(
                array(
                    'id' => 'compselect',
                    'class' => 'CCheckBoxColumn',
                ),
		'competencia',
		'descripcion',
	),
    )); ?>
     
     <?php
        echo CHtml::dropdownlist('peso','0',CHtml::listData(Ponderacion::model()->findAll(),'idponderacion','valor'), array('empty'=>'Seleccione el peso sobre el puesto que desea asignar a la competencia'))
     ?>
 
    <br></br>
     <?php echo CHtml::submitButton('Asociar',array('submit'=>'../save', 'class'=>'sexybutton sexysimple sexylarge'));?>
     
     <?php echo CHtml::endForm()?>
     
    
         <p></br> </br> </br> </p>
     <h1>Competencias asociadas</h1>
     
     
    <?php 
    $puestocomp = new Puestocompetencia();
    ?>
    
    <?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'competenciaasociado-grid',
        'dataProvider'=>$puestocomp->search($model->id),
	'columns'=>array(
                    'NombreCompetencia',
                    'ponderacion',
                    array(
                            'class'=>'CButtonColumn',
                            'htmlOptions'=>array('width'=>'20'),
                            'template'=>'{delete}',
                            'buttons'=>array(
                                'delete'=>array(
                                    'url'=>'Yii::app()->createUrl("puestocompetencia/delete", array("competencia"=>$data->competencia, "puesto"=>$data->puesto))',
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
                autoclose: '4000',
                modal:true
            });
     </script>
     <?php endif;?>