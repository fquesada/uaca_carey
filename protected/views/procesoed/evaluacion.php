<div class="content_evaluacion">

<?php
//Cargo el css de esta vista
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/evaluacion.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/nuevaevaluacion.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/sexybuttons.css');


//Cargo Jquery y JS que realiza la logica en la pagina
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/nuevaevaluacion.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.placeholder.min.js');

/* @var $this EvaluacionController */
/* @var $model Evaluacion */

$this->breadcrumbs=array(
	'Evaluacion del Desempeño'=>array('index'),
	'Evaluacion Compromisos',
);
?>

<?php echo $this->renderPartial('_infonuevaevaluacion', array('model'=>$model)); ?>
    
<?php echo CHtml::beginForm($this->createUrl('crearevaluaciondesempeno'))?>

<?php echo $this->renderPartial('_evaluarcompromisos', array('model'=>$model)); ?>
<?php echo $this->renderPartial('_evaluarcompetencias', array('model'=>$model)); ?>
<?php echo $this->renderPartial('_resultadosnuevaevaluacion', array('model'=>$model)); ?>
<?php // echo $this->renderPartial('_accionesmejoramiento', array('model'=>$model)); ?>


<div class="content_section_submit">        
        
                  <?php echo CHtml::submitButton('Guardar evaluación',array('id'=>'btnevaluacion', 'class'=>'sexybutton sexysimple sexylarge'));?>
</div

<?php echo CHtml::endForm()?>

</div>

