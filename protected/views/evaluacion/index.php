<?php
/* @var $this EvaluacionController */

$this->breadcrumbs=array(
	'Evaluacion',
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
<script type="text/javascript">



</script>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<div class="form">
    
    <div class="row">        
        
        <?php  echo CHtml::label('Nombre:', 'colaborador');?>
                
        <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
            'attribute'=>'colaborador',
            'name'=>'colaborador', 
            'id'=>'colaborador',
            'source'=>$this->createUrl('evaluacion/autocompletecolaborador'),
            // additional javascript options for the autocomplete plugin
            'options'=>array(
                 'showAnim'=>'fold',
                'minLength'=>'2',
                'select'=>"js: function(event, ui) {
                    $('#cedulaid').text(ui.item['cedula']);                      
                    $('#id').text(ui.item['id']); 
                    $('#puesto').text(ui.item['puesto']);                      
                    $('#unidad').text(ui.item['unidad']); 
                    $(this).prop('disabled', true);
                    $('#refrescar').show('slow');                    
                    $.fn.yiiGridView.update('evaluaciones-grid',{data: {idcolaborador:$('#id').text()}});    

                }",                
                 ),
              'htmlOptions'=>array('size'=>'30'),
            ));
        ?>
        
        <spa id="refrescar" style="display: none"><a href="javascript:location.reload()"><img src=<?php echo Yii::app()->baseUrl."/images/icons/silk/arrow_refresh.png" ?>></a></spa>
    </div>
    
    <div class="row">        
            <?php  echo CHtml::label('Cédula', 'cedulaid'); ?>
            <?php echo CHtml::label('-', 'cedulaid',array('id'=>'cedulaid')); ?>
        
    </div>
    
    <div class="row">        
            <?php  echo CHtml::label('Unidad de negocio', 'unidad'); ?>
            <?php echo CHtml::label('-', 'unidad',array('id'=>'unidad')); ?>
    </div>
    
    
    <div class="row">        
            <?php  echo CHtml::label('Puesto', 'puesto'); ?>
            <?php echo CHtml::label('-', 'puesto',array('id'=>'puesto')); ?>
    </div>
    
     <div class="row">                    
            <?php echo CHtml::label('-', 'id',array('id'=>'id','name'=>'id','style'=>'display:none')); ?>
    </div>
    
    
    <div id="historial">
        
        <?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'id'=>'evaluaciones-grid',
    'columns'=>array(
        'id',
        'periodo', 
        'fecharegistro',
        'puesto',
        'estadoevaluacion'
    ),
));
?>
    </div>
   
</div>