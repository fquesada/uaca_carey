<?php
/* @var $this ProcesoEvaluacionController */
/* @var $procesoec ProcesoEvaluacion */
/* @var $indicadoreditar Indicador Editar*/
?>


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
    'id'=>'dialogpostulante',
    'options'=>array(
        'title'=>'Agregar Postulante',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>375,
        'height'=>375,
        'resizable' => false,
        'draggable' => false,
        'beforeClose' => 'js:function(){$("#divpostulante").hide();}',
    ),
));
?>

<div id="divpostulante" style="display: none">    
    <div class="form">        
    
    <div class="row">        
            <?php  echo CHtml::label('Cédula', 'cedulapostulante'); ?>            
            <?php echo CHtml::textField('txtcedulapostulante','', array('id'=>'cedulapostulante')); ?>
        
    </div>
    <div class="row">        
            <?php  echo CHtml::label('Nombre', 'nombrepostulante'); ?>            
            <?php echo CHtml::textField('txtnombrepostulante','', array('id'=>'txtnombrepostulante')); ?>
        
    </div>
        
    <div class="row">        
            <?php  echo CHtml::label('Primer Apellido', 'apellido1postulante'); ?>            
            <?php echo CHtml::textField('txtapellido1postulante','', array('id'=>'txtapellido1postulante')); ?>
        
    </div>
    <div class="row">        
            <?php  echo CHtml::label('Segundo Apellido', 'apellido2postulante'); ?>            
            <?php echo CHtml::textField('txtapellido2postulante','', array('id'=>'txtapellido2postulante')); ?>
        
    </div>
        
        <div id="ddlpostulanteerror" class="errorevaluacionpersona">El campo cédula debe ser un número y todos los campos son requeridos.</div>
        </br>        
    <div class="row buttons">                    
        <button  id="btnagregarpostulante" type="button" class="sexybutton sexysimple"><span class="accept">Agregar colaborador</span></button>
    </div>
           
    </div>
      
</div>

<?php $this->endWidget();?>



<div>
    
<table border="1" id="tblpostulantes">
  <thead>
    <tr>
      <th style="display: none">id</th>
      <th>Cédula</th>      
      <th>Postulante</th> 
      <th>Acciones</th>
    </tr>
  </thead>  
  <tbody>   
      <?php
      if($indicadoreditar){
          foreach ($procesoec->_evaluacionescompetencias as $ec) {              
              $postulante = Postulante::model()->findbyPk($ec->colaborador);
              echo '<tr>';
              echo '<td name="id" style="display: none">';
              echo $postulante->id;
              echo '</td>';
              echo '<td name="cedula">';
              echo $postulante->cedula;
              echo '</td>';
              echo '<td name="nombre" style="display: none">';
              echo $postulante->nombre;
              echo '</td>';
              echo '<td name="apellido1" style="display: none">';
              echo $postulante->apellido1;
              echo '</td>';
              echo '<td name="apellido2" style="display: none">';
              echo $postulante->apellido2;
              echo '</td>';
              echo '<td name="nombrecompleto">';
              echo $postulante->nombrecompleto;
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
  <div id="tblpostulanteserror" class="errorevaluacionpersona">Debe agregar al menos un postulante</div>  
</div>