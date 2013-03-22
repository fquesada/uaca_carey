

<?php
/* @var $this EvaluacionpersonasController */
/* @var $model Evaluacionpersonas */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/messi.min.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/messi.min.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/evaluacionpersonas.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/evaluacionpersonas.css');

$this->breadcrumbs=array(
	'Evaluacion'=>array('admin'),
	'Crear',
);
?>

<h3>Crear proceso evaluacion</h3>


<?php echo CHtml::beginForm()?>

<?php echo $this->renderPartial('_formevaluacionpersona'); ?>

<?php echo $this->renderPartial('_formhabilidadespecial'); ?>

</br>
<div class="row buttons">        
        
                  <?php echo CHtml::submitButton('Crear proceso evaluacion',array('id'=>'btncrearevaluacionpersona', 'class'=>'sexybutton sexysimple sexylarge'));?>
</div>
<?php echo CHtml::endForm()?>
