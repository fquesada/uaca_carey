<?php
/* @var $this ProcesoEvaluacionController */
/* @var $ec EvaluacionCompetencias*/
/* @var $puntaje Puntaje*/

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/evaluarprocesoecv.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/evaluarprocesoecv.css');

?>

<?php echo CHtml::beginForm()?>

<?php echo CHtml::button('Volver atrás', array('id'=>'btnvolveratras','submit' => array('procesors/adminprocesoecv/'.$ec->procesoevaluacion), 'class'=>'sexybutton sexysimple sexylarge')); ?>

<?php echo $this->renderPartial('_encabezadoec', array('ec'=>$ec, 'puntaje' => $puntaje)); ?>
<?php echo $this->renderPartial('_formmeritosec', array('ec'=>$ec)); ?>
<?php echo $this->renderPartial('_formcompetenciasec', array('ec'=>$ec)); ?>
<?php echo $this->renderPartial('_formassessmentcenter'); ?>
<div class="promedioponderado">
        <p>Promedio Ponderado: <span>0</span>
        </p>
</div>
<?php echo $this->renderPartial('_formhabilidadesnoequivalentes'); ?>


</br>
<div class="row buttons" style="text-align: center">                
                  <?php echo CHtml::submitButton('Guardar evaluacion',array('id'=>'btnguardarecv', 'class'=>'sexybutton sexysimple sexylarge'));?>
</br>   
                  <?php echo CHtml::button('Volver atrás', array('id'=>'btnvolveratras','submit' => array('procesors/adminprocesoecv/'.$ec->procesoevaluacion), 'class'=>'sexybutton sexysimple sexylarge')); ?>
</div>
<?php echo CHtml::endForm()?>