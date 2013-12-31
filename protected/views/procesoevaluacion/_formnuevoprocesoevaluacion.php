<div class="form">
    <p>Campos con * son obligatorios.</p> 
    
    <div class="row">
            <?php echo CHtml::label('Periodo *', 'periodo');?>
            <?php echo CHtml::dropDownList('ddlperiodo', 'nombre',
                        CHtml::listData(Periodo::model()->findAll(), 'id', 'nombre'), array('empty'=>'Elija el periodo', 'id'=>'ddlperiodo')) ?>       
            <div id="ddlperiodoerror" class="errorevaluacionpersona">Debe seleccionar un periodo</div>
    </div> 
    
    <div class="row">
            <?php echo CHtml::label('Nombre del proceso *', 'descripcion');?>
            <?php echo CHtml::textArea('txtareadescripcion','', array('id'=>'txtdescripcion', 'rows' => '3', 'cols' => '40', 'maxlength' => '90'));?>                    
            <div id="txtdescripcionerror" class="errorevaluacionpersona">Debe ingresar el nombre del proceso.</div>
    </div>
    
    <fieldset>
            <legend>Búsqueda de Colaborador por nombre</legend>
    <div class="row">
            <?php echo CHtml::label('Evaluador *', 'evaluador');?>
            <?php 
            
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
            'attribute'=>'colaborador',
            'name'=>'colaborador', 
            'id'=>'busquedaevaluador',
            'source'=>$this->createUrl('procesoevaluacion/AutocompleteEvaluado'),
            // additional javascript options for the autocomplete plugin
            'options'=>array(
                'showAnim'=>'fold',
                'minLength'=>'2',
                'select'=>"js: function(event, ui) {
                    
                if(ui.item['value']!='')
                {
                    $('#busquedaevaluador').attr('disabled', 'true');	                    
                    $('#cedulaevaluador').text(ui.item['cedula']);                                                              
                    $('#idevaluador').val(ui.item['id']); 
                    $('#imgborrarevaluador').show();
                    $('#btnbusquedacolaboradores').removeAttr('disabled'); 

                 }
                    
                }",                
                 ),
              'htmlOptions'=>array('size'=>'30'),
            ));
                        
        
            ?>                   
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/icons/silk/decline.png", "Borrar Colaborador seleccionado", 
                    array("id"=>"imgborrarevaluador", "style" => "padding-left:5px; cursor:pointer; display:none")); ?>
            <div id="busquedaevaluadorerror" class="errorevaluacionpersona">Debe seleccionar un evaluador</div>
    </div>  
    <div class="row">        
            <?php  echo CHtml::label('Cédula', 'cedula'); ?>            
            <?php echo CHtml::label('-', 'cedula',array('id'=>'cedulaevaluador','name'=>'cedula')); ?>
        
    </div>
    <div class="row">                  
            <?php echo CHtml::hiddenField('idevaluador', '-',array('id'=>'idevaluador','name'=>'id')); ?>        
    </div>   
    </fieldset>
 
      
</div>