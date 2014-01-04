<?php
/* @var $this ProcesoEvaluacionController */
/* @var $ec EvaluacionCompetencias */
?>

<div id="divmeritosec" class="divmeritosec">
    <p> <i>Calificar meritos</i> </p>
    <?php
    if (!$ec->_puesto->meritosactuales)
        echo 'El puesto debe poseer meritos para continuar con la evaluacion.';
    else {
        foreach ($ec->_puesto->meritosactuales as $merito) {
            echo '<p>';
            echo '<b>' . $merito->puesto . ' = </b>';
            echo $merito->descripcion;
            echo '</p>';
        }
    }
    ?>
</div>

<div class="row">
    <?php echo CHtml::label('Periodo *', 'periodo'); ?>
    <?php echo CHtml::dropDownList('ddlperiodo', 'nombre', CHtml::listData(Periodo::model()->findAll(), 'id', 'nombre'), array('empty' => 'Elija el periodo', 'id' => 'ddlperiodo'))
    ?>       
    <div id="ddlperiodoerror" class="errorevaluacionpersona">Debe seleccionar un periodo</div>
</div> 

<div class="row">
    <?php echo CHtml::label('Nombre del proceso *', 'descripcion'); ?>
    <?php echo CHtml::textArea('txtareadescripcion', '', array('id' => 'txtdescripcion', 'rows' => '3', 'cols' => '40', 'maxlength' => '90')); ?>                    
    <div id="txtdescripcionerror" class="errorevaluacionpersona">Debe ingresar el nombre del proceso.</div>
</div>
