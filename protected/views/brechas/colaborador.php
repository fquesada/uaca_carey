<?php
/* @var $this BrechasController */


Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/brechas.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/brechas.css');
Yii::app()->clientScript->registerScript('autocomplete', '
  $["ui"]["autocomplete"].prototype["_renderItem"] = function( ul, item) {
                return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( $( "<a></a>" ).html( item.label ) )
                .appendTo( ul );
            };
  
', CClientScript::POS_READY
);

$this->breadcrumbs = array(
    'Análisis de Brechas por Colaborador',
);

$this->menu = array(
    array('label' => 'Inicio', 'url' => array('site/index')),
    array('label' => 'Análisis de Brechas en Competencias', 'url' => array('brechas/competencias')),
    array('label' => 'Análisis de Brechas en Desempeño', 'url' => array('brechas/desempeno')),
);
?>

<h3 style="text-align: center">Análisis de Brechas por Colaborador</h3>

<div class="divBusquedaColaborador">
    <?php
    echo CHtml::label('Buscar Colaborador:', 'colaborador');
    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
        'attribute' => 'colaborador',
        'name' => 'colaborador',
        'id' => 'busquedaevaluador',
        'source' => $this->createUrl('brechas/AutocompleteColaborador'),
        // additional javascript options for the autocomplete plugin
        'options' => array(
            'showAnim' => 'fold',
            'minLength' => '2',
            'select' => "js: function(event, ui) {
                    if(ui.item['value']!='')
                        cargarHistoricoEvaluaciones(ui.item['id']); 
                    else
                        $('#divCargando').css('display', 'none');	
                    }",
        ),
        'htmlOptions' => array('size' => '30'),
    ));
    ?>            
</div>  

<div id="divHistoricoEvaluaciones" class="divHistoricoEvaluaciones">
    <div id="divCargando" class="divCargando">
    
    <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/preload.GIF", "Cargando", 
                    array("id"=>"imgCargando", "class"=>"imgCargando")); 
          echo CHtml::label('Cargando...','')
    ?>
    </div>
        
    <div id="divColaborador" class="divColaborador">
    
    <div>
    
   <div id="divEvaluaciones" class="divEvaluaciones">
    
    <div>
  
</div>

<div style="text-align: center"> 
    <?php
    echo CHtml::button('Volver atrás', array('id' => 'btnvolveratras', 'submit' => array('site/index'), 'class' => 'sexybutton sexysimple sexylarge'));
    ?>
</div>
