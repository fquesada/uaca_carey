<div>                    
<button  id="btnagregarcolaboradores" type="button" class="sexybutton sexysimple"><span class="add">Agregar colaboradores</span></button>
</div>
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
',
  CClientScript::POS_READY
);
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogcolaboradores',
    'options'=>array(
        'title'=>'Agregar Colaborador',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>375,
        'height'=>415,
        'resizable' => false,
        'draggable' => false,
        'beforeClose' => 'js:function(){$("#divcolaborador").hide();}',
    ),
));
?>

<div id="divcolaborador" style="display: none">    
    <div class="form">        
    <fieldset>
            <legend>Búsqueda de Colaborador por nombre</legend>
    <div class="row">
            <?php echo CHtml::label('Colaborador', 'buscarcolaborador');?>
            <?php             
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
            'attribute'=>'colaborador',
            'name'=>'colaborador', 
            'id'=>'busquedacolaborador',
            'source'=>$this->createUrl('procesoevaluacion/AutocompleteEvaluado'),           
            'options'=>array(
                'showAnim'=>'fold',
                'minLength'=>'2',
                'select'=>"js: function(event, ui) {
                    
                if(ui.item['value']!='')
                {
                    $('#buscarcolaborador').attr('disabled', 'true');	                    
                    $('#cedulacolaborador').text(ui.item['cedula']);                                                              
                    $('#id').val(ui.item['id']);                              
                    $('#tipo').val(ui.item['tipo']);  
                    $('#btnagregarpersona').removeAttr('disabled'); 
                    $('#imgborrarcolaborador').show();
                 }
                    
                }",                
                 ),
              'htmlOptions'=>array('size'=>'30'),
            ));
            ?>                   
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/icons/silk/decline.png", "Borrar Colaborador seleccionado", 
                    array("id"=>"imgborrarcolaborador", "style" => "padding-left:5px; cursor:pointer; display:none")); ?>
            <div id="ddlpuestoerror" class="errorevaluacionpersona">Debe seleccionar un puesto</div>
    </div>  
    <div class="row">        
            <?php  echo CHtml::label('Cédula', 'cedulacolaborador'); ?>            
            <?php echo CHtml::label('-', 'cedula',array('id'=>'cedulacolaborador','name'=>'cedula')); ?>
        
    </div>
    </fieldset>       
    <div class="row buttons">                    
        <button  id="btncrearhabilidad" type="button" class="sexybutton sexysimple"><span class="accept">Agregar evaluación especial</span></button>
    </div>
           
    </div>
      
</div>

<?php $this->endWidget();?>


<div>
    
<table border="1" id="tblcolaboradores">
  <thead>
    <tr>
      <th>Cédula</th>      
      <th>Colaborador</th> 
      <th>Puesto</th>
      <th></th> 
    </tr>
  </thead>  
  <tbody>       
  </tbody>
</table>
    
</div>

