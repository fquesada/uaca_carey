<?php
/* @var $this ProcesoEvaluacionController */
/* @var $procesoec ProcesoEvaluacion */
/* @var $indicadoreditar Indicador Editar*/
?>

<div>                    
<button  id="btnbusquedacolaboradores" type="button" class="sexybutton sexysimple" disabled="disabled"><span class="add">Buscar colaborador(es)</span></button>
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
        'height'=>245,
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
                    $('#busquedacolaborador').attr('disabled', 'true');	                    
                    $('#cedulacolaborador').text(ui.item['cedula']);                                                              
                    $('#idcolaborador').val(ui.item['id']);
                    $('#btnagregarcolaborador').removeAttr('disabled'); 
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
    <div class="row">                  
            <?php echo CHtml::hiddenField('id', '-',array('id'=>'idcolaborador','name'=>'idcolaborador')); ?>        
    </div>
    </fieldset>       
    <div class="row buttons">                    
        <button  id="btnagregarcolaborador" type="button" class="sexybutton sexysimple" disabled="disabled"><span class="accept">Agregar colaborador</span></button>
    </div>
           
    </div>
      
</div>

<?php $this->endWidget();?>


<div>
    
<table border="1" id="tblcolaboradores">
  <thead>
    <tr>
      <th style="display: none">id</th>
      <th>Cédula</th>      
      <th>Colaborador</th> 
      <th>Puesto</th> 
      <th>Acciones</th>
    </tr>
  </thead>  
  <tbody>   
      <?php
      if($indicadoreditar){
          foreach ($procesoec->_evaluacionescompetencias as $ec) {
              echo '<tr>';
              echo '<td name="idcolaborador" style="display: none">';
              echo $ec->colaborador;
              echo '</td>';
              echo '<td name="cedula">';
              echo $ec->_colaborador->cedula;
              echo '</td>';
              echo '<td name="colaborador">';
              echo $ec->_colaborador->nombrecompleto;
              echo '</td>';
              echo '<td name="puesto">';
              echo $ec->_colaborador->nombrepuestoactual;
              echo '</td>';
              echo '<td>';
              echo CHtml::image(Yii::app()->request->baseUrl."/images/icons/silk/delete.png", "Eliminar colaborador", 
                    array("id"=>"borrarcolaborador", "style" => "padding-left:5px; cursor:pointer;"));       
              echo '</td>';
              echo '</tr>';
          }
      }
      ?>
  </tbody>
</table>
    
</div>
<div id="tblcolaboradoreserror" class="errorevaluacionpersona">Debe agregar al menos un colaborador</div>

