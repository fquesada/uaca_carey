<div class="content_evaluacion">

<?php

//CSS
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/css/evaluacion.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/sexybuttons.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/messi.min.css');

//Javascript
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/evaluacion.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.placeholder.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/messi.min.js');

$this->breadcrumbs=array(
	'Evaluaciones'=>array('index'),
	'Compromisos',
);
?>

<?php if(Yii::app()->user->hasFlash('success')):?>       
    <script type="text/javascript"> 
        new Messi('<?php echo Yii::app()->user->getFlash('success'); ?>', 
            {   title: 'Éxito.', 
                titleClass: 'success', 
                autoclose: '4000',
                modal:true                
            });
    </script>
    
<?php endif; ?>
    
<?php if(Yii::app()->user->hasFlash('warning')):?>       
     <script type="text/javascript"> 
        new Messi('<?php echo Yii::app()->user->getFlash('warning'); ?>', 
            {   title: 'Lo sentimos.', 
                titleClass: 'anim warning', 
                buttons: [{id: 0, label: 'Cerrar', val: 'X'}],
                modal:true                
            });
    </script>     
<?php endif;?> 

<?php echo $this->renderPartial('_infonuevoscompromisos', array('model'=>$model)); ?>

<?php // echo CHtml::beginForm($this->createUrl('evaluacion/crearnuevocompromisos'))?>
    
<?php echo CHtml::beginForm('','post',array('id'=>'formcompromisos'))?>
<?php echo $this->renderPartial('_agregarnuevoscompromisos', array('model'=>$model)); ?>

<div class="content_section_submit">        
                  <?php echo CHtml::submitButton('Guardar Compromisos',array('id'=>'btncompromiso', 'class'=>'sexybutton sexysimple sexylarge')); ?>                  
</div>

<?php echo CHtml::endForm()?>


</div>