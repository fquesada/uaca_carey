<?php
/* @var $this ProcesoEvaluacionController */
/* @var $procesoec ProcesoEvaluacion */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/messi.min.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/messi.min.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/evaluacionpersonas.js');//CLEAN CODE
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/evaluacionpersonas.css');//CLEAN CODE

$this->breadcrumbs=array(
	'EC'=>array('admin'),
	'Gestionar proceso EC',
);
$this->menu=array(
	array('label'=>'EC' , 'url'=>array('admin')),	
);
?>

<h3 style="text-align: center">Gestionar Proceso EC</h3>

