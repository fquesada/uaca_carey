
<?php
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
?>

<div class="form">
    <p>Campos con * son obligatorios.</p> 
    
    
    <div class="row">
            <?php echo CHtml::label('Periodo *', 'periodo');
                 echo CHtml::dropDownList('periodo','', CHtml::listData(Periodo::model()->findAll(), 'id', 'nombre'), array('empty'=>'Elija el periodo', 'id'=>'periodo'));           
                    ?>
            <div id="periodoerror" class="errorprocesoevaluacion">Debe seleccionar un periodo</div>
    </div>
    
    <div class="row">
            <?php echo CHtml::label('Descripcion de proceso *', 'descripcion');?>
            <?php echo CHtml::textArea('txtdescripcion','', array('id'=>'txtdescripcion', 'rows' => '3', 'cols' => '40', 'maxlength' => '90'));?>                    
            <div id="txtdescripcionerror" class="errorprocesoevaluacion">Debe ingresar la descripción del proceso.</div>
    </div>
    
    <div class="row">
        
        <?php  echo CHtml::label('Evaluador:', 'lblcolaborador');?>
            <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
            'attribute'=>'colaborador',
            'name'=>'colaborador', 
            'id'=>'colaborador',
            'source'=>$this->createUrl('procesoed/AutocompleteEvaluado'),
            // additional javascript options for the autocomplete plugin
            'options'=>array(
                 'showAnim'=>'fold',
                'minLength'=>'2',
                'select'=>"js: function(event, ui) {
                    
                if(ui.item['value']!='')
                {
                    $('#colaborador').attr('disabled', 'true');	                    
                    $('#cedula').text(ui.item['cedula']);                                                              
                    $('#id').val(ui.item['id']);                                                          
                    $('#imgborrar').show();
                 }
                    
                }",                
                 ),
              'htmlOptions'=>array('size'=>'30'),
            ));
                        
        ?>        
        <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/icons/silk/decline.png", "Borrar Persona seleccionada", 
                    array("id"=>"imgborrar", "style" => "padding-left:5px; cursor:pointer; display:none")); ?>
        <div class="row">        
            <?php  echo CHtml::label('Cédula', 'cedula'); ?>
            <?php echo CHtml::label('-', 'cedula',array('id'=>'cedula','name'=>'cedula')); ?>
        
        </div>
        <div id="colaboradorerror" class="errorprocesoevaluacion">Debe ingresar un evaluador.</div>
        
          <div class="row">                  
            <?php echo CHtml::hiddenField('id', '-',array('id'=>'id','name'=>'id')); ?>        
        </div>
    </div>  
      
</div><!-- form -->