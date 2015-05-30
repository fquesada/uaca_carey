<?php
/* @var $this EntrevistaController */

$this->breadcrumbs=array(
	'Entrevista',
);
?>
<h1>Generar entrevista</h1>

<div class="form">
<?php echo CHtml::beginForm('excel','post'); ?>

<h5>Seleccione el puesto para el que desea generar la entrevista conducutal estructurada</h5>
    
    <div class="row">
        <?php echo CHtml::label('Puesto', 'puesto') ?>
        <?php  
        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'attribute'=>'puesto',
                'name'=>'puesto', 
                'id'=>'busquedapuesto',
                'source'=>$this->createUrl('procesoRS/AutocompletePuesto'),
                // additional javascript options for the autocomplete plugin
                'options'=>array(
                    'showAnim'=>'fold',
                    'minLength'=>'2',
                    'select'=>"js: function(event, ui) {

                    if(ui.item['value']!='')
                    {
                        $('#busquedapuesto').attr('disabled', 'true');	                                            
                        $('#idpuesto').val(ui.item['id']); 
                        $('#imgborrarpuesto').show();                        

                     }

                    }",                
                     ),
                  'htmlOptions'=>array('size'=>'30'),
                ));
        ?>
        
        <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/icons/silk/decline.png", "Borrar Puesto", 
                    array("id"=>"imgborrarpuesto", "style" => "padding-left:5px; cursor:pointer; display:none")); 
        
        echo CHtml::hiddenField('idpuesto', '-',array('id'=>'idpuesto','name'=>'idpuesto')); 
        ?>
    </div>          
 
    <div class="row submit">
        <?php echo CHtml::SubmitButton('Generar',  array(
            'class'=>'sexybutton sexysimple')); ?>
    </div>
    
 
<?php echo CHtml::endForm(); ?>
        
</div>