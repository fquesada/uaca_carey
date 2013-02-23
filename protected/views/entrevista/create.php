<?php
/* @var $this EntrevistaController */


$this->breadcrumbs=array(
	'Entrevistas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Entrevista', 'url'=>array('index')),
	array('label'=>'Manage Entrevista', 'url'=>array('admin')),
);


Yii::app()->clientScript->registerScript('autocomplete', '
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

<h1>Generar Entrevista</h1>


<div class="form">

    <?php echo CHtml::beginForm('','get'); ?>
    
    <div class="row">
		<?php echo CHtml::label('Vacante:', 'vacante'); ?>
		<?php echo CHtml::dropDownList('Vacante','vacante', CHtml::listData(Vacante::model()->findAll(),'id', 'nombrevacante'),array('empty' => 'Selecione una unidad de negocio')); ?>
            		
    </div>

        <div class="row">     
        
        <?php  echo CHtml::label('Nombre:', 'colaborador');?>
                
        <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
            'attribute'=>'colaborador',
            'name'=>'colaborador', 
            'id'=>'colaborador',
            'source'=>$this->createUrl('entrevista/autocompleteentrevistado'),
            // additional javascript options for the autocomplete plugin
            'options'=>array(
                 'showAnim'=>'fold',
                'minLength'=>'2',
                'select'=>"js: function(event, ui) {
                    $('#cedula').text(ui.item['cedula']);                                                              
                    $('#id').val(ui.item['id']);                              

                }",                
                 ),
              'htmlOptions'=>array('size'=>'30'),
            ));
        ?>
                
    </div>

   <div class="row">        
            <?php  echo CHtml::label('Cédula', 'cedula'); ?>
            <?php echo CHtml::label('-', 'cedula',array('id'=>'cedula','name'=>'cedula')); ?>
        
    </div>
    <div class="row">                  
            <?php echo CHtml::hiddenField('id', '-',array('id'=>'id','name'=>'id')); ?>        
    </div>

    <div class="row buttons">
    <?php echo CHtml::submitButton('Generar', array('id'=>'btnAdd')); ?>
        </div>
    
    <?php echo CHtml::endForm(); ?>
</div>