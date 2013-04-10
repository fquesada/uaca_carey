<div>
                    
<button  id="btndialoghabilidadespecial" type="button" class="sexybutton sexysimple"><span class="add">Agregar habilidad especial</span></button>
<label>(Máximo 5 habilidades)</label>
</div>

<br/>
<br/>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogHabilidades',
    'options'=>array(
        'title'=>'Crear Habilidad Especial',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>375,
        'height'=>415,
        'resizable' => false,
        'draggable' => false,
        'beforeClose' => 'js:function(){$("#divhabilidad").hide();}',
    ),
));?> 

<div id="divhabilidad" style="display: none">
    
    <div class="form">
    <p>Campos con * son obligatorios.</p>   
        
    <div class="row">
            <?php echo CHtml::label('Habilidad Especial *', 'txtnombrehabilidad');?>
            <?php echo CHtml::textField('txtnombrehabilidad','', array('id'=>'txtnombrehabilidad','maxlength' => '45'));?>        
            <div id="txtnombrehabilidaderror" class="errorevaluacionpersona">Debe ingresar una habilidad.</div>
    </div> 

    <div class="row">
            <?php echo CHtml::label('Descripcion de la habilidad *', 'txtareadescripcionhabilidad');?>
            <?php echo CHtml::textArea('txtareadescripcionhabilidad','', array('id'=>'txtareadescripcionhabilidad', 'rows' => '5', 'cols' => '40', 'maxlength' => '180'));?>        
            <div id="txtareadescripcionhabilidaderror" class="errorevaluacionpersona">Debe ingresar la descripción de la habilidad.</div>
    </div>  
    
    <div class="row">
            <?php echo CHtml::label('Ponderación de la habilidad *', 'dllponderacion', array("style" => "display : inline"));?>
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/icons/silk/help.png", "Ayuda ponderacion", array("id"=>"imgponderacionhelp", "style" => "padding-left:5px; cursor:pointer")) ?>
            <?php echo CHtml::dropDownList('ponderacion', 'valor',
                        CHtml::listData(Ponderacion::model()->findAll(), 'valor', 'valor'), array('empty'=>'Elija la ponderación', 'id'=>'dllponderacion')) ?>		                 
            <div id="dllponderacionerror" class="errorevaluacionpersona">Debe seleccionar una ponderación.</div>
    </div>  
        
    <div class="row buttons">                    
        <button  id="btncrearhabilidad" type="button" class="sexybutton sexysimple"><span class="accept">Agregar habilidad especial</span></button>
    </div>
           
    </div>
      
</div>

<?php $this->endWidget();?>


<div>
    
<table border="1" id="tblhabilidades">
  <thead>
    <tr>
      <th>Habilidad Especial</th>      
      <th>Descripción</th> 
      <th>Ponderación</th>
      <th></th> 
    </tr>
  </thead>  
  <tbody>       
  </tbody>
</table>
    
</div>

