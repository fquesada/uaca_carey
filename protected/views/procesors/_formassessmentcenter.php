<?php
/* @var $this ProcesoEvaluacionController */
?>

<div id="divindicadorassessmentcenter" class="divindicadorassessmentcenter">  
        <input id="cbassessmentcenter" type="checkbox" name="cbassessmentcenter">Activar solo para evaluaciones exclusivas en Assessment Center</input>        
</div>

<div id="divassessmentcenter" class="divassessmentcenter">
    <p class="ptituloassessmentcenter">Calificación de Assessment Center</p>
    <table id="tblassessmentcenter" class="tblassessmentcenter">
        <thead>
            <tr>                
                <th>Detalle calificación</th>               
                <th>Calificación <span class="span_lbl_califacionac">(La calificación debe ser un valor entre 0 y 5, se aceptan decimales, ejemplo: 3.5 )</th>
            </tr>
        <thead>
        <tbody>
            <th><?php echo CHtml::textarea('detalleassessmentcenter', '', array('id' => 'taassessmentcenter', 'class' => 'taassessmentcenter')); ?></th>                    
            <th> <?php echo CHtml::textField('puntajeac', '', array('id' => 'tfpuntajeassessmentcenter')); ?>           
            <p id="tfpuntajeassessmentcentererror" class="mensajeerror">Debe ingresar una calificación entre 0 y 5 (Se aceptan decimales, ejemplo: 3.5)</p>
            </th>          
        </tbody>
    </table>
</div>