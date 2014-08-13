<?php
/* @var $this ProcesoEvaluacionController */
/* @var $ec EvaluacionCompetencias*/
/* @var $puntaje Puntaje*/
$postulante = Postulante::model()->findByPk($ec->colaborador);
$vacante = Vacante::model()->findByAttributes(array('procesoevaluacion'=>$ec->_procesoevaluacion->id));
?>

<div id="divencabezadoec" class="divencabezadoec">
    <p class="pencabezadoec">Informacion evaluación</p>
    <p style="display:none"><?php echo CHtml::label($ec->id, 'idec', array('id'=>'lblidec'))?></p>
    <p> <b>Colaborador:</b> <?php echo $postulante->nombrecompleto?> </p>
    <p> <b>Cedula:</b> <?php echo $postulante->cedula?> </p>   
    <p> <b>Puesto:</b> <?php echo $vacante->_puesto->nombre?> </p>   
    <p> <b>Evaluador:</b> <?php echo $ec->_procesoevaluacion->_evaluador->nombrecompleto?> </p>
    <p> <b>Periodo:</b> <?php echo $ec->_procesoevaluacion->_periodo->nombre ?> </p>
</div>

<?php  //COLOCAR EN UN DIALOG ?>
<p class="pescalacalificacion">Escala de calificación <?php echo CHtml::image(Yii::app()->request->baseUrl.'/images/icons/silk/information.png', 'Escala calificacion', array("id"=>"imgescalacalificacion", "cursor:pointer;"));?></p>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'infoescalacalificacion',
    'options'=>array(
        'title'=>'Escala calificación',
        'autoOpen'=>false,
        'modal'=>false,
        'width'=>600,
        'height'=>350,
        'resizable' => true,
        'draggable' => true,
        'beforeClose' => 'js:function(){$("#divescalacalificacion").hide();}',
    ),
));
?>
<div id="divescalacalificacion" class="divescalacalificacion">    
    <?php        
    foreach ($puntaje as $registropuntaje) {
        echo '<p>';
        echo '<b>'.$registropuntaje->valor.' = </b>';
        echo $registropuntaje->descripcion;
        echo '</p>';
    }
    ?>
</div>

<?php $this->endWidget();?>