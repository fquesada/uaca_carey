<?php
/* @var $this ProcesoEvaluacionController */
/* @var $procesoec ProcesoEvaluacion */
/* @var $indicadoreditar Indicador Editar*/

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/messi.min.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/messi.min.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/evaluacionpersonas.js');//CLEAN CODE
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/evaluacionpersonas.css');//CLEAN CODE
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

if(!$indicadoreditar){
    $this->breadcrumbs=array(
            'EC'=>array('admin'),
            'Nuevo proceso EC',
    );
    $this->menu=array(
	array('label'=>'Lista de Procesos EC' , 'url'=>array('admin')),	        
    );
}else{
    $this->breadcrumbs=array(
            'EC'=>array('admin'),
            'Editar proceso EC',
    );
    $this->menu=array(
	array('label'=>'Lista de Procesos EC' , 'url'=>array('admin')),	
        array('label'=>'Crear Proceso EC' , 'url'=>array('crearprocesoec')),
    );
}
?>

<h3 style="text-align: center"><?php if(!$indicadoreditar) echo "Nuevo proceso EC"; else echo "Editar proceso EC #".$procesoec->id;?></h3>

<?php echo CHtml::beginForm()?>

<?php 
    if(!$indicadoreditar){
        echo $this->renderPartial('_formprocesoevaluacion', array('indicadoreditar' => $indicadoreditar ));
        echo $this->renderPartial('_formagregarcolaborador', array('indicadoreditar' => $indicadoreditar )); 
    }else{
        echo $this->renderPartial('_formprocesoevaluacion', array('procesoec'=>$procesoec,'indicadoreditar' => $indicadoreditar )); 
        echo $this->renderPartial('_formagregarcolaborador', array('procesoec'=>$procesoec,'indicadoreditar' => $indicadoreditar ));       
        echo CHtml::hiddenField('idproceso', $procesoec->id,array('id'=>'idprocesoec','name'=>'idprocesoec'));
         echo CHtml::hiddenField('indicadoreditar', "true",array('id'=>'indicadoreditar','name'=>'indicadoreditar'));
    }
?>



</br>
<div class="row buttons" style="text-align: center">  
                <?php if(!$indicadoreditar)
                        echo CHtml::submitButton('Crear proceso EC',array('id'=>'btncrearprocesoEC', 'class'=>'sexybutton sexysimple sexylarge'));
                   else
                        echo CHtml::submitButton('Guardar proceso EC',array('id'=>'btnguardarprocesoEC', 'class'=>'sexybutton sexysimple sexylarge')); 
                   ?>
</div>
<?php echo CHtml::endForm()?>
