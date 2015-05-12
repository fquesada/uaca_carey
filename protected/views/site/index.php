<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<body>
<div class="MenuInicial">
    <div id="Reclutamiento">
       <div id="TituloR">
           <h1 align="center">Reclutamiento y Selección</h1>
       </div>
       <div id="ContenidoR">
           <br>
           <?php echo CHtml::link('Generar entrevista',array('procesors/entrevista'), array("class"=>"boton")); ?>
           <?php echo CHtml::link('Crear proceso ECV',array('procesors/crearProcesoecv'), array("class"=>"boton")); ?>
           <?php echo CHtml::link('Gestionar proceso ECV',array('procesors/admin'), array("class"=>"boton")); ?>
       </div>
   </div>
    <div id="Competencias">
       <div id="TituloC">
           <h1 align="center">Evaluación de Competencias</h1>
       </div>
       <div id="ContenidoC">
           <br>
           <?php echo CHtml::link('Crear proceso EC',array('procesoevaluacion/crearprocesoec'), array("class"=>"boton")); ?>
           <?php echo CHtml::link('Gestionar proceso EC',array('procesoevaluacion/admin'), array("class"=>"boton")); ?>
       </div>
   </div>
     <div id="Desempeno">
       <div id="TituloD">
           <h1 align="center">Evaluación de Desempeño</h1>
       </div>
       <div id="ContenidoD">
           <br>
           <?php echo CHtml::link('Crear proceso ED',array('procesoed/crear'), array("class"=>"boton")); ?>
           <?php echo CHtml::link('Gestionar proceso ED',array('procesoed/admin'), array("class"=>"boton")); ?>
       </div>
   </div>
   <div id="Brechas">
       <div id="TituloB">
           <h1 align="center">Brechas</h1>
       </div>
       <div id="ContenidoB">
           <br>
           <?php echo CHtml::link('Historial de Evaluaciones',array('brechas/HistoricoEvaluaciones'), array("class"=>"boton")); ?>
           <?php echo CHtml::link('Análisis de Brechas',array('brechas/AnalisisBrechas'), array("class"=>"boton")); ?>          
       </div>
   </div>
</div>
</body>
