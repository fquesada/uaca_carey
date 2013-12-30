

<?php
/* @var $this ProcesoedController */
/* @var $model evaluaciondesempeno */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/messi.min.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/messi.min.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/procesoed.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/procesoevaluacion.css');

$this->breadcrumbs=array(
	'Evaluación de desempeño'=>array('admin'),
	'Creación proceso de evaluación de desempeño',
);

$this->menu=array(
	array('label'=>'Gestión de evaluación de desempeño' , 'url'=>array('admin')),	
);
?>



<h3 style="text-align: center">Crear proceso de evaluación de desempeño</h3>


<?php echo CHtml::beginForm()?>

<?php echo $this->renderPartial('_formevaluaciondesempeno'); ?>

</br>
<div class="row buttons" style="text-align: center">        
        
                  <?php echo CHtml::submitButton('Crear proceso',array('id'=>'btncrearprocesoevaluacion', 'class'=>'sexybutton sexysimple sexylarge'));?>
</div>
<?php echo CHtml::endForm()?>
