<?php
/* @var $this EvaluacionpersonasController */
/* @var $model Evaluacionpersonas */

$this->breadcrumbs=array(
	'Evaluacion'=>array('admin'),
	'Crear',
);
?>

<h3>Crear proceso evaluacion</h3>


<?php echo CHtml::beginForm($this->createUrl('crearevaluacionpersona'))?>

<?php echo $this->renderPartial('_formevaluacionpersona', array('model'=>$model)); ?>

<?php echo $this->renderPartial('_habilidadespecial'); ?>
<?php echo $this->renderPartial('_formhabilidadespecial'); ?>

<div>        
        
                  <?php echo CHtml::submitButton('Crear proceso evaluacion',array('id'=>'btnevaluacion', 'class'=>'sexybutton sexysimple sexylarge'));?>
</div>

<?php echo CHtml::endForm()?>
