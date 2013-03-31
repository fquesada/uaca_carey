<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<body>
<div class="MenuAdministracion">
    <div id="Administracion">
        <h1>Administración</h1>
    </div>
    <div class="Menu">
           <a href="colaborador/admin" class="btn">Colaborador</a>
           <a href="competencia/admin" class="btn">Competencia</a>
           <a href="origenevaluacion/admin" class="btn">Origen de Evaluación</a>
           <a href="periodo/admin" class="btn">Período</a>
   </div>
    <div class="Menu">
           <a href="ponderacion/admin" class="btn">Ponderación</a>
           <a href="postulante/admin" class="btn">Postulante</a>
           <a href="puesto/admin" class="btn">Puesto</a>
           <a href="puntaje/admin" class="btn">Puntaje</a>
   </div>
     <div class="Menu">
           <a href="puntualizacion/admin" class="btn">Puntualización</a>
           <a href="unidadnegocio/admin" class="btn">Unidad de Negocio</a>
           <a href="usuario/admin" class="btn">Usuario</a>
   </div>
</div>
</body>
