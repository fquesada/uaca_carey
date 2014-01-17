<?php
/* @var $this ProcesoEvaluacionController */
/* @var $procesoec ProcesoEvaluacion */
/* @var $indicadoreditar Indicador Editar*/
?>

<div class="form">
    <p>Campos con * son obligatorios.</p> 
    
    <div class="row">
            <?php echo CHtml::label('Periodo *', 'periodo');?>
            <?php if(!$indicadoreditar)    
                    echo CHtml::dropDownList('ddlperiodo','', CHtml::listData(Periodo::model()->findAll(), 'id', 'nombre'), array('empty'=>'Elija el periodo', 'id'=>'ddlperiodo'));
                  else
                    echo CHtml::dropDownList('ddlperiodo',$procesoec ->periodo, CHtml::listData(Periodo::model()->findAll(), 'id', 'nombre'), array('empty'=>'Elija el periodo', 'id'=>'ddlperiodo'));  
                      ?>       
            <div id="ddlperiodoerror" class="errorevaluacionpersona">Debe seleccionar un periodo</div>
    </div> 
    
    <div class="row">
            <?php echo CHtml::label('Nombre del proceso *', 'descripcion');?>          
            <?php if(!$indicadoreditar)   
                    echo CHtml::textArea('txtareadescripcion','', array('id'=>'txtdescripcion', 'rows' => '3', 'cols' => '40', 'maxlength' => '90'));
                else
                    echo CHtml::textArea('txtareadescripcion',$procesoec->descripcion, array('id'=>'txtdescripcion', 'rows' => '3', 'cols' => '40', 'maxlength' => '90'));
            ?>                    
            <div id="txtdescripcionerror" class="errorevaluacionpersona">Debe ingresar el nombre del proceso.</div>
    </div>
    
    <fieldset>
            <legend>Búsqueda de Colaborador por nombre</legend>
    <div class="row">
            <?php echo CHtml::label('Evaluador *', 'evaluador');?>
            <?php 
            if(!$indicadoreditar){
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
                        $('#puestoevaluador').text(ui.item['puesto']);                                                              
                        $('#idevaluador').val(ui.item['id']); 
                        $('#imgborrarevaluador').show();
                        $('#btnbusquedacolaboradores').removeAttr('disabled'); 

                     }

                    }",                
                     ),
                  'htmlOptions'=>array('size'=>'30'),
                ));
            }
            else{
                echo CHtml::textField('colaborador', $procesoec->_evaluador->nombrecompleto, array('id' => 'busquedaevaluador','size'=>'30'));
                Yii::app()->clientScript->registerScript('activarevaluador', "
                        $('#busquedaevaluador').attr('disabled', 'true');	                                                                   
                        $('#btnbusquedacolaboradores').removeAttr('disabled'); 
                ");
            }                  
        
            ?>                   
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/icons/silk/decline.png", "Borrar Colaborador seleccionado", 
                    array("id"=>"imgborrarevaluador", "style" => "padding-left:5px; cursor:pointer; display:none")); ?>
            <div id="busquedaevaluadorerror" class="errorevaluacionpersona">Debe seleccionar un evaluador</div>
    </div>  
    <div class="row">        
            <?php  echo CHtml::label('Puesto', 'puesto'); ?>            
            <?php if(!$indicadoreditar)  
                    echo CHtml::label('-', 'puesto',array('id'=>'puestoevaluador','name'=>'puesto')); 
                  else
                    //echo CHtml::label($procesoec->_evaluador->puesto, 'puesto',array('id'=>'puestoevaluador','name'=>'puesto'));
            ?>
        
    </div>
    <div class="row">                  
            <?php if(!$indicadoreditar) 
                    echo CHtml::hiddenField('idevaluador', '-',array('id'=>'idevaluador','name'=>'id')); 
                  else 
                    echo CHtml::hiddenField('idevaluador', $procesoec->evaluador,array('id'=>'idevaluador','name'=>'id')); 
            ?>        
    </div>   
    </fieldset>
 
      
</div>