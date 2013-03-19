<div class="form">

    <div class="row">
            <?php echo CHtml::label('Descripcion del proceso', 'descripcion');?>
            <?php echo CHtml::textArea('txtareadescripcion','', array('id'=>'txtdescripcion', 'rows' => '3', 'cols' => '40', 'maxlength' => '90'));?>                    
    </div>
    
    <div class="row">
            <?php echo CHtml::label('Puesto', 'puesto');?>
            <?php echo CHtml::dropDownList('ddlpuesto', 'nombre',
                        CHtml::listData(Puesto::model()->findAll(array('order' => 'nombre')), 'id', 'nombre'), array('empty'=>'Elija el puesto', 'id'=>'ddlpuesto')) ?>       
    </div>  
      
</div><!-- form -->