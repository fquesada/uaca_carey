<?php
/* @var $this ProcesoEDController */
/* @var $evaluacion ProcesoED */
/* @var $indicadoreditar Indicador Editar*/
?>

<div class="form">
    <p>Campos con * son obligatorios.</p> 
    
    <div class="row">
            <?php echo CHtml::label('Periodo *', 'periodo');?>
            <?php if(!$indicadoreditar)    
                    echo CHtml::dropDownList('ddlperiodo','', CHtml::listData(Periodo::model()->findAll(), 'id', 'nombre'), array('empty'=>'Elija el periodo', 'id'=>'ddlperiodo'));
                  else
                    echo CHtml::dropDownList('ddlperiodo',$evaluacion ->periodo, CHtml::listData(Periodo::model()->findAll(), 'id', 'nombre'), array('empty'=>'Elija el periodo', 'id'=>'ddlperiodo'));  
                      ?>       
            <div id="ddlperiodoerror" class="errorevaluacionpersona">Debe seleccionar un periodo</div>
    </div> 
    
    <div class="row">
            <?php echo CHtml::label('Nombre del proceso *', 'descripcion');?>          
            <?php if(!$indicadoreditar)   
                    echo CHtml::textArea('txtareadescripcion','', array('id'=>'txtdescripcion', 'rows' => '3', 'cols' => '40', 'maxlength' => '90'));
                else
                    echo CHtml::textArea('txtareadescripcion',$evaluacion->descripcion, array('id'=>'txtdescripcion', 'rows' => '3', 'cols' => '40', 'maxlength' => '90'));
            ?>                    
            <div id="txtdescripcionerror" class="errorevaluacionpersona">Debe ingresar el nombre del proceso.</div>
    </div>
    
     <div class="row">
            <?php echo CHtml::label('Fecha evaluación *', 'fecha');?>
          <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                'name'=>'fecha',
                // additional javascript options for the date picker plugin
                'options'=>array(
                    'showAnim'=>'slide',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                    'dateFormat'=>'dd-mm-yy',
                ),
                'htmlOptions'=>array(
                    'style'=>'height:20px;',
                    'readonly'=>'readonly', 
                ),
            ));
            ?>
            <div id="ddlfechaerror" class="errorevaluacionpersona">Debe seleccionar un periodo</div>
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
                'source'=>$this->createUrl('procesoed/AutocompleteEvaluado'),
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
                        $('#opcionescargacolaborador').show(); 

                     }

                    }",                
                     ),
                  'htmlOptions'=>array('size'=>'30'),
                ));
            }
            else{
                echo CHtml::textField('colaborador', $evaluacion->_evaluador->nombrecompleto, array('id' => 'busquedaevaluador','size'=>'30'));
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
                    echo CHtml::label($evaluacion->_evaluador->nombrepuestoactual, 'puesto',array('id'=>'puestoevaluador','name'=>'puesto'));
            ?>
        
    </div>
   
    <div class="row">                  
            <?php if(!$indicadoreditar) 
                    echo CHtml::hiddenField('idevaluador', '-',array('id'=>'idevaluador','name'=>'id')); 
                  else 
                    echo CHtml::hiddenField('idevaluador', $evaluacion->evaluador,array('id'=>'idevaluador','name'=>'id')); 
            ?>        
    </div>   
    </fieldset>
 
    <div id="opcionescargacolaborador" class="opcionescargacolaborador">
         <?php echo CHtml::label("Seleccione el tipo de carga de Colaboradores *", 'lblopcionescarga',array('id'=>'lblopcionescarga'));?>
         <input id="cbmasiva" type="radio" name="tipocarga" value="masiva">Carga Masiva (Todos los colaboradores)</input>        
         <input id="cbdepartamento" type="radio" name="tipocarga" value="departamento">Departamento</input>     
         <input id="cbindividual" type="radio" name="tipocarga" value="individual">Individual</input>     
    </div>
    
    
    
    <div>
        <?php if(!$indicadoreditar) {
           echo CHtml::dropDownList('unidadnegocio','unidadnegocio',CHtml::listData(Unidadnegocio::model()->findAll('estado=1'), 'id', 'nombre'), array('empty' => 'Seleccione Departamento', 'id' => 'ddlcargadepartamento', 'class' => 'ddlcargadepartamento')); 
           Yii::app()->clientScript->registerScript('nomostrarbtnbusquedacolaboradores', "
                        $('#btnbusquedacolaboradores').css('display', 'none');	                                                                   
                       
           ");
           
           echo '<div id="cargaajax"></div>';
        }
        echo '<button  id="btnbusquedacolaboradores" type="button" class="sexybutton sexysimple" disabled="disabled"><span class="add">Buscar colaborador(es)</span></button>';
       ?>
        
        
  
    </div>
    </br>
    </br>  
</div>