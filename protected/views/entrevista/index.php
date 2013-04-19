<?php
/* @var $this EntrevistaController */

$this->breadcrumbs=array(
	'Entrevista',
);
?>
<h1>Entrevista</h1>

<div class="form">
<?php echo CHtml::beginForm('entrevista/excel','post'); ?>
     
 
    <div class="row">
        <?php echo CHtml::label('Puesto', 'puesto') ?>
        <?php echo CHtml::dropDownList('puesto','puesto', CHtml::listData(Puesto::model()->findAll(array('order'=>'nombre','condition'=>'estado=:estado', 'params'=>array(':estado'=>1))),'id', 'nombre'),array('empty' => 'Selecione un puesto')); ?>
    </div>          
 
    <div class="row submit">
        <?php echo CHtml::SubmitButton('Generar',  array(
            'class'=>'sexybutton sexysimple')); ?>
    </div>
    
 
<?php echo CHtml::endForm(); ?>
        
</div>