<?php
/* @var $this ProcesoEvaluacionController */
?>

<div id="divindicadorassessmentcenter" class="divindicadorassessmentcenter">  
        <input id="cbassessmentcenter" type="checkbox" name="cbassessmentcenter">Activar calificacion de Assessment Center</input>        
</div>

<div id="divassessmentcenter" class="divassessmentcenter">
    <p class="ptituloassessmentcenter">Calificación de Assessment Center</p>
    <table id="tblassessmentcenter" class="tblassessmentcenter">
        <thead>
            <tr>                
                <th>Detalle calificacion</th>               
                <th>Calificación</th>
            </tr>
        <thead>
        <tbody>
            <th><?php echo CHtml::textarea('detalleassessmentcenter', '', array('id' => 'taassessmentcenter', 'class' => 'taassessmentcenter')); ?></th>
            <th> <?php echo CHtml::dropDownList('puntajeac', 'puntajeac', CHtml::listData(Puntaje::model()->findAll('estado=1'), 'valor', 'valor'), array('empty' => 'Seleccione calificacion', 'id' => 'ddlpuntajeassessmentcenter')); ?>
            <p id="ddlpuntajeassessmentcentererror" class="mensajeerror">Debe seleccionar una calificacion</p>
            </th>          
        </tbody>
    </table>
</div>