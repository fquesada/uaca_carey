

<?php
/* @var $this ProcesoedController */
/* @var $model evaluaciondesempeno */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/messi.min.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/messi.min.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/procesoed.js');

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/procesoed.css');
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
            'Nuevo proceso ED',
    );
    $this->menu=array(
	array('label'=>'Lista de Procesos ED' , 'url'=>array('admin')),	        
    );
}else{
    $this->breadcrumbs=array(
            'EC'=>array('admin'),
            'Editar proceso ED',
    );
    $this->menu=array(
	array('label'=>'Lista de Procesos ED' , 'url'=>array('admin')),	
        array('label'=>'Crear Proceso ED' , 'url'=>array('crear')),
    );
}
?>

<h3 style="text-align: center"><?php if(!$indicadoreditar) echo "Nuevo proceso ED"; else echo "Editar proceso ED #".$evaluacion->id;?></h3>
</br>

<?php 
    if(!$indicadoreditar){
        echo CHtml::button('Volver atrás', array('id'=>'btnvolveratras','submit' => array('procesoed/admin'), 'class'=>'sexybutton sexysimple sexylarge'));
    }
    else{
        echo CHtml::button('Volver atrás', array('id'=>'btnvolveratras','submit' => array('procesoed/admined/'.$evaluacion->id), 'class'=>'sexybutton sexysimple sexylarge'));
        
    }
?>

<?php echo CHtml::beginForm()?>

<?php 
    if(!$indicadoreditar){
        echo $this->renderPartial('_formproceso', array('indicadoreditar' => $indicadoreditar ));
        echo $this->renderPartial('_formagregarcolaborador', array('indicadoreditar' => $indicadoreditar )); 
    }else{
        echo $this->renderPartial('_formproceso', array('procesoed'=>$evaluacion,'indicadoreditar' => $indicadoreditar )); 
        echo $this->renderPartial('_formagregarcolaborador', array('procesoed'=>$evaluacion,'indicadoreditar' => $indicadoreditar ));       
        echo CHtml::hiddenField('idproceso', $evaluacion->id,array('id'=>'idprocesoed','name'=>'idprocesoed'));
         echo CHtml::hiddenField('indicadoreditar', "true",array('id'=>'indicadoreditar','name'=>'indicadoreditar'));
    }
?>



<div class="row buttons" style="text-align: center">  
                <?php if(!$indicadoreditar){
                        echo CHtml::submitButton('Crear proceso ED',array('id'=>'btncrearprocesoed', 'class'=>'sexybutton sexysimple sexylarge'));                                                
                        echo '</br>';
                        echo '</br>';
                        echo CHtml::button('Volver atrás', array('id'=>'btnvolveratras','submit' => array('procesoed/admin'), 'class'=>'sexybutton sexysimple sexylarge'));
                }else{
                        echo CHtml::submitButton('Guardar proceso ED',array('id'=>'btnguardarprocesoed', 'class'=>'sexybutton sexysimple sexylarge')); 
                        echo '</br>';
                        echo '</br>';
                        echo CHtml::button('Volver atrás', array('id'=>'btnvolveratras','submit' => array('procesoed/admined/'.$evaluacion->id), 'class'=>'sexybutton sexysimple sexylarge'));
                }
                   ?>
</div>
<?php echo CHtml::endForm()?>