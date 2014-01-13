<?php
/* @var $this ProcesoEvaluacionController */
/* @var $ec EvaluacionCompetencias*/
/* @var $puntaje Puntaje*/
/* @var $competenciascore Competenciascore*/

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/evaluarprocesoec.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/evaluarprocesoec.css');

?>

<?php echo CHtml::beginForm()?>

<?php echo $this->renderPartial('_encabezadoec', array('ec'=>$ec, 'puntaje' => $puntaje)); ?>
<?php echo $this->renderPartial('_formassessmentcenter'); ?>
<?php echo $this->renderPartial('_formmeritosec', array('ec'=>$ec)); ?>
<?php echo $this->renderPartial('_formcompetenciasec', array('ec'=>$ec, 'competenciascore' => $competenciascore)); ?>
<?php echo $this->renderPartial('_formhabilidadesnoequivalentes'); ?>

</br>
<div class="row buttons" style="text-align: center">                
                  <?php echo CHtml::submitButton('Guardar evaluacion',array('id'=>'btnguardarec', 'class'=>'sexybutton sexysimple sexylarge'));?>
</div>
<?php echo CHtml::endForm()?>