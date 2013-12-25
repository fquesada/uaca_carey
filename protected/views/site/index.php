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
           <?php echo CHtml::link('Generar entrevista',array('entrevista/index'), array("class"=>"boton")); ?>
           <?php echo CHtml::link('Crear proceso ECV',array('entrevista/index'), array("class"=>"boton")); ?>
           <?php echo CHtml::link('Gestionar proceso ECV',array('entrevista/index'), array("class"=>"boton")); ?>
       </div>
   </div>
    <div id="Competencias">
       <div id="TituloC">
           <h1 align="center">Evaluación de Competencias</h1>
       </div>
       <div id="ContenidoC">
           <br>
           <?php echo CHtml::link('Crear proceso EC',array('evaluacionpersonas/crear'), array("class"=>"boton")); ?>
           <?php echo CHtml::link('Gestionar proceso EC',array('evaluacionpersonas/admin'), array("class"=>"boton")); ?>
           <?php echo CHtml::link('Evaluar competencias',array('evaluacionpersonas/evaluar'), array("class"=>"boton")); ?>
       </div>
   </div>
     <div id="Desmpeño">
       <div id="TituloD">
           <h1 align="center">Evaluación de Desempeño</h1>
       </div>
       <div id="ContenidoD">
           <br>
           <?php echo CHtml::link('Crear proceso ED',array('evaluaciondesempeno/crear'), array("class"=>"boton")); ?>
           <?php echo CHtml::link('Gestionar proceso ED',array('evaluaciondesempeno/admin'), array("class"=>"boton")); ?>
           <?php echo CHtml::link('Evaluar desempeño',array('evaluaciondesempeno/evaluar'), array("class"=>"boton")); ?>
       </div>
   </div>
</div>
</body>
