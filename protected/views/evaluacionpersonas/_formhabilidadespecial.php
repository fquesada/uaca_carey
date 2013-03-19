<br/>
<br/>

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
        'width'=>395,
        'height'=>270,
        'resizable' => false,
        'draggable' => false,
        'beforeClose' => 'js:function(){$("#divhabilidad").hide();}',
    ),
));?> 

<div id="divhabilidad" style="display: none">
    
    <div class="form">
        
    <div class="row">
            <?php echo CHtml::label('Habilidad Especial', 'txtnombrehabilidad');?>
            <?php echo CHtml::textField('txtnombrehabilidad','', array('id'=>'txtnombrehabilidad','maxlength' => '45'));?>        
    </div> 

    <div class="row">
            <?php echo CHtml::label('Descripcion de la habilidad', 'txtareadescripcionhabilidad');?>
            <?php echo CHtml::textArea('txtareadescripcionhabilidad','', array('id'=>'txtareadescripcionhabilidad', 'rows' => '5', 'cols' => '40', 'maxlength' => '180'));?>        
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
      <th></th> 
    </tr>
  </thead>  
  <tbody>       
  </tbody>
</table>
    
</div>

