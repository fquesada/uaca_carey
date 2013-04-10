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
           <a href="#" class="boton">Función 1</a>
           <a href="#" class="boton">Función 2</a>
           <a href="#" class="boton">Función 3</a>
       </div>
   </div>
    <div id="Competencias">
       <div id="TituloC">
           <h1 align="center">Evaluación de Competencias</h1>
       </div>
       <div id="ContenidoC">
           <br>
           <?php echo CHtml::link('Gestión de evaluaciones',array('evaluacionpersonas/admin'), array("class"=>"boton")); ?>
           <?php echo CHtml::link('Nueva evaluación',array('evaluacionpersonas/crear'), array("class"=>"boton")); ?>
           <a href="#" class="boton">Función 3</a>
       </div>
   </div>
     <div id="Desmpeño">
       <div id="TituloD">
           <h1 align="center">Evaluación de Desempeño</h1>
       </div>
       <div id="ContenidoD">
           <br>
           <a href="#" class="boton">Función 1</a>
           <a href="#" class="boton">Función 2</a>
           <a href="#" class="boton">Función 3</a>
       </div>
   </div>
</div>
</body>
