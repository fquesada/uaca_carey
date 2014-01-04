<?php
/* @var $this ProcesoEvaluacionController */
/* @var $ec EvaluacionCompetencias*/
?>

<div id="divmeritosec" class="divmeritosec">
    <p> <i>Calificar meritos</i> </p>
    <?php
    if(!$ec->_puesto->meritosactuales)
        echo 'El puesto debe poseer meritos para continuar con la evaluacion.';
    else{
    foreach ($ec->_puesto->meritosactuales as $merito) {
        echo '<p>';
        echo '<b>'.$merito->puesto.' = </b>';
        echo $merito->descripcion;
        echo '</p>';
    }
    }
    ?>
</div>
