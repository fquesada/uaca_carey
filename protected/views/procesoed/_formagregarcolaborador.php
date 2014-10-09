<?php
/* @var $this ProcesoEDController */
?>
</br>
</br>
</br>

<?php
//Este script sobreescribe el Jquery Autocomplete para permitir render HTML sobre los datos del json
Yii::app()->clientScript->registerScript('formatoautocomplete', '
  $["ui"]["autocomplete"].prototype["_renderItem"] = function( ul, item) {
                return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( $( "<a></a>" ).html( item.label ) )
                .appendTo( ul );
            };  
', CClientScript::POS_READY
);
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogcolaboradores',
    'options' => array(
        'title' => 'Agregar Colaborador',
        'autoOpen' => false,
        'modal' => true,
        'width' => 375,
        'height' => 250,
        'resizable' => false,
        'draggable' => false,
        'beforeClose' => 'js:function(){$("#divcolaborador").hide();}',
    ),
));
?>

<div id="divcolaborador">    
    <div class="form">        
        <fieldset>
            <legend>Búsqueda de Colaborador por nombre</legend>
            <div class="row">
                <?php echo CHtml::label('Colaborador', 'buscarcolaborador'); ?>
                <?php
                $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                    'attribute' => 'colaborador',
                    'name' => 'colaborador',
                    'id' => 'busquedacolaborador',
                    'source' => $this->createUrl('procesoed/AutocompleteEvaluado'),
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => '2',
                        'select' => "js: function(event, ui) {                    
                if(ui.item['value']!='')
                {
                    $('#busquedacolaborador').attr('disabled', 'true');	                    
                    $('#puestocolaborador').text(ui.item['puesto']);                                                              
                    $('#idcolaborador').val(ui.item['id']);
                    $('#cedulacolaborador').val(ui.item['cedula']);
                    $('#btnagregarcolaborador').removeAttr('disabled'); 
                    $('#imgborrarcolaborador').show();
                 }                    
                }",
                    ),
                    'htmlOptions' => array('size' => '30'),
                ));
                ?>                   
                <?php echo CHtml::image(Yii::app()->request->baseUrl . "/images/icons/silk/decline.png", "Borrar Colaborador seleccionado", array("id" => "imgborrarcolaborador", "style" => "padding-left:5px; cursor:pointer; display:none"));
                ?>
                <div id="ddlpuestoerror" class="errorevaluacionpersona">Debe seleccionar un puesto</div>
            </div>  
            <div class="row">        
                <?php echo CHtml::label('Puesto', 'puestocolaborador'); ?>            
                <?php echo CHtml::label('-', 'puesto', array('id' => 'puestocolaborador', 'name' => 'puesto')); ?>

            </div>
            <div class="row">                  
                <?php echo CHtml::hiddenField('id', '-', array('id' => 'idcolaborador', 'name' => 'idcolaborador')); ?>    
                <?php echo CHtml::hiddenField('cedula', '-', array('id' => 'cedulacolaborador', 'name' => 'cedulacolaborador')); ?>
            </div>
        </fieldset>       
        <div class="row buttons">                    
            <button  id="btnagregarcolaborador" type="button" class="sexybutton sexysimple" disabled="disabled"><span class="accept">Agregar colaborador</span></button>
        </div>

    </div>

</div>

<?php $this->endWidget(); ?>