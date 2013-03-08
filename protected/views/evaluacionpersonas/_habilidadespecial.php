<br/>
<br/>

<div>
                    
<button  id="btncrearevaluacionpersona" type="submit" class="sexybutton sexysimple"><span class="add">Agregar habilidad especial</span></button>

</div>

<br/>
<br/>

<div>
    
<table border="1">
  <thead>
    <tr>
      <th>Habilidad Especial</th>      
      <th>Descripción</th> 
    </tr>
  </thead>  
  <tbody>
    <tr>
      <td>Actualmente no hay habilidades.</td>      
    </tr>   
  </tbody>
</table>
    
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogHabilidades',
    'options'=>array(
        'title'=>'Crear Habilidad Especial',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>550,
        'height'=>470,
    ),
));?>

<div id="divhabilidad">
    
    <div class="form">
        
    <div class="row">
            <?php echo CHtml::label('Habilidad Especial', 'txtnombrehabilidad');?>
            <?php echo CHtml::textField('txtnombrehabilidad','', array('id'=>'txtnombrehabilidad','maxlength' => '45'));?>        
    </div> 

    <div class="row">
            <?php echo CHtml::label('Descripcion de la habilidad', 'txtareadescripcionhabilidad');?>
            <?php echo CHtml::textArea('txtareadescripcionhabilidad','', array('id'=>'txtareadescripcionhabilidad', 'rows' => '5', 'cols' => '40', 'maxlength' => '180'));?>        
    </div>   
           
    </div>
      
</div><!-- form -->
    
</div>
 
<?php $this->endWidget();?>