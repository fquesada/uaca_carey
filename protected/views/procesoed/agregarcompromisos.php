<?php
/* @var $this ProcesoEvaluacionController */
/* @var $procesoed ProcesoEvaluacion */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/admined.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/admined.css');//CLEAN CODE

$this->breadcrumbs=array(
	'EC'=>array('admin'),
	'Gestionar proceso EC',
);
$this->menu=array(
	array('label'=>'Lista de Procesos ED' , 'url'=>array('admin')),	
        //array('label'=>'Editar Proceso EC' , 'url'=>array('editarprocesoec', 'id'=>$procesoed->id)),	
);
?>

<h3 style="text-align: center">Agregar compromisos<?php echo $procesoed->id;?></h3>

<div>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$procesoed,
	'attributes'=>array(
                array(
                        'label' => $procesoed->getAttributeLabel('fecha'),
                        'value' => $procesoed->FechaProcesoFormato,
                ),                               
                array(
                        'label' => $procesoed->_periodo->getAttributeLabel('periodo'),
                        'value' => $procesoed->_periodo->nombre,
                ),
                'descripcion',
                array(
                        'label' => $procesoed->getAttributeLabel('evaluador'),
                        'value' => $procesoed->_evaluador->nombrecompleto,
                ),   
                array(
                        'label' => $procesoed->getAttributeLabel('estado'),
                        'value' => $procesoed->EstadoProceso,
                ),                
	),
)); ?>
</div>
