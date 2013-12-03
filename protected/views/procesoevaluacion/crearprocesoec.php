<?php
/* @var $this EvaluacionpersonasController */
/* @var $model Evaluacionpersonas */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/messi.min.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/messi.min.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/evaluacionpersonas.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/evaluacionpersonas.css');

Yii::app()->clientScript->registerScript('autocomplete', '
  $["ui"]["autocomplete"].prototype["_renderItem"] = function( ul, item) {
                return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( $( "<a></a>" ).html( item.label ) )
                .appendTo( ul );
            };
  
',
  CClientScript::POS_READY
);


$this->breadcrumbs=array(
	'EC'=>array('admin'),
	'Nuevo proceso EC',
);

$this->menu=array(
	array('label'=>'EC' , 'url'=>array('admin')),	
);
?>



<h3 style="text-align: center">Nuevo proceso EC</h3>


<?php echo CHtml::beginForm()?>

<?php // echo $this->renderPartial('_formevaluacionpersona'); ?>

<?php echo $this->renderPartial('_formnuevoprocesoevaluacion'); ?>

<?php // echo $this->renderPartial('_formhabilidadespecial'); ?>

<?php echo $this->renderPartial('_formagregarcolaborador'); ?>

</br>
<div class="row buttons" style="text-align: center">        
        
                  <?php echo CHtml::submitButton('Crear proceso EC',array('id'=>'btncrearproceso', 'class'=>'sexybutton sexysimple sexylarge'));?>
</div>
<?php echo CHtml::endForm()?>
