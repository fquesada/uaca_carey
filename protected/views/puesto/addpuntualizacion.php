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
        'Agregar puntualización'
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
    $puntualizacion = new Puntualizacion();
    ?>
    
    <p></br> </br> </br> </p>
   
 <h1>Puntualizaciones disponibles</h1>
 <h5>Seleccione las puntualizaciones que desea agregar al puesto y presione el botón "Asociar"</h5>
 
 <?php echo CHtml::beginForm('','POST',array('id'=>'formpuntualizacion'))?> 
 
 <?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'puntualizacionexistente-grid',
        'dataProvider'=>$puntualizacion->addpuntualizacion($model->id),
	'filter'=>$puntualizacion,
	'columns'=>array(
                array(
                    'id' => 'puntualizacionselect',
                    'class' => 'CCheckBoxColumn',
                    'selectableRows'=>'25',
                ),
		'puntualizacion',
		'indicadorpuntualizacion',
	),
    )); ?>
     
     <br></br>
     <?php echo CHtml::submitButton('Asociar',array('submit'=>'../savepuntualizacion', 'class'=>'sexybutton sexysimple sexylarge'));?>
     
     <?php echo CHtml::endForm()?>
     
    
         <p></br> </br> </br> </p>
     <h1>Puntualizaciones asociadas</h1>
     
     
    <?php 
    $puestopun = new PuestoPuntualizacion();
    ?>
    
    <?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'puntualizacionasociado-grid',
        'dataProvider'=>$puestopun->search($model->id),
	'columns'=>array(
                    'NombrePunt',
                    'IndicadorPunt',
                    array(
                            'class'=>'CButtonColumn',
                            'htmlOptions'=>array('width'=>'20'),
                            'template'=>'{delete}',
                            'buttons'=>array(
                                'delete'=>array(
                                    'url'=>'Yii::app()->createUrl("puestopuntualizacion/delete", array("puntualizacion"=>$data->puntualizacion, "puesto"=>$data->puesto))',
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