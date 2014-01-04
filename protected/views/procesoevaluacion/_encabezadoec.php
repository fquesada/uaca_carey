<?php
/* @var $this ProcesoEvaluacionController */
/* @var $ec EvaluacionCompetencias*/
/* @var $puntaje Puntaje*/
?>

<div id="divencabezadoec" class="divencabezadoec">
    <p> <i>Informacion evaluacion</i> </p>
    <p> <b>Colaborador:</b> <?php echo $ec->_colaborador->nombrecompleto?> </p>
    <p> <b>Cedula:</b> <?php echo $ec->_colaborador->cedula?> </p>
    <p> <b>Puesto:</b> <?php echo $ec->_colaborador->idpuestoactual?> </p>
    <p> <b>Puesto:</b> <?php echo $ec->_colaborador->nombrepuestoactual?> </p>
    <p> <b>Departamento:</b> <?php echo $ec->_colaborador->nombreunidadnegocioactual?> </p>
    <p> <b>Evaluador:</b> <?php echo $ec->_procesoevaluacion->_evaluador->nombrecompleto?> </p>
    <p> <b>Periodo:</b> <?php echo $ec->_procesoevaluacion->_periodo->nombre ?> </p>
</div>

<?php  //COLOCAR EN UN DIALOG ?>
<div id="divpuntaje" class="divpuntaje">
    <p> <i>Escala evaluacion</i> </p>
    <?php        
    foreach ($puntaje as $registropuntaje) {
        echo '<p>';
        echo '<b>'.$registropuntaje->valor.' = </b>';
        echo $registropuntaje->descripcion;
        echo '</p>';
    }
    ?>
</div>