<?php
/* @var $this ProcesoEDController */
/* @var $ed Evaluaciondesempeno */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/evaluarprocesoed.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.placeholder.min.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/evaluarprocesoed.css');

?>

<div id="divEncabezadoED" class="divEncabezadoED">
    <p class="pEncabezadoED">Evaluación de Desempeño (ED)</p>
    <p class="pEncabezadoED">Informacion evaluación</p>
    <p style="display:none"><?php echo CHtml::label($ed->id, 'ided', array('id'=>'lblided'))?></p>
    <p> <b>Colaborador:</b> <?php echo $ed->_colaborador->nombrecompleto?> </p>
    <p> <b>Cedula:</b> <?php echo $ed->_colaborador->cedula?> </p>   
    <p> <b>Puesto:</b> <?php echo $ed->_puesto->nombre?> </p>
    <p> <b>Departamento:</b> <?php echo $ed->UnidadNegocioEvaluacion?> </p>
    <p> <b>Evaluador:</b> <?php echo $ed->_procesoevaluacion->_evaluador->nombrecompleto?> </p>
    <p> <b>Periodo:</b> <?php echo $ed->_procesoevaluacion->_periodo->nombre ?> </p>
    <p> <b>Fecha Registro Compromisos:</b> <?php echo $ed->FechaRegistroCompromisoFormato?> </p>  
    <p> <b>Fecha Evaluacion Compromisos:</b> <?php echo $ed->FechaCompromisoEvaluacionFormato?> </p>  
</div>



<?php echo CHtml::beginForm('','post',array('id'=>'formcompromisos'))?>
<?php echo $this->renderPartial('_formcalificarcompromisos', array('ed'=>$ed)); ?>
<?php echo $this->renderPartial('_formcalificarcompetencias', array('ed'=>$ed)); ?>
<?php echo $this->renderPartial('_resultadoevaluacion', array('ed'=>$ed)); ?>


<div class="row buttons" style="text-align: center">       
                  <?php echo CHtml::submitButton('Guardar Evaluacion',array('id'=>'btnguardared', 'class'=>'sexybutton sexysimple sexylarge'));  ?>                  
</div>

<?php echo CHtml::endForm()?>
