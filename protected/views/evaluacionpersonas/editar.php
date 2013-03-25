<?php
/* @var $this EvaluacionpersonasController */
/* @var $model Evaluacionpersonas */
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/messi.min.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/messi.min.css');


$this->breadcrumbs=array(
	'Evaluacionpersonases'=>array('index'),
	'Agregar Personas',
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

/*$this->menu=array(
	array('label'=>'List Evaluacionpersonas', 'url'=>array('index')),
	array('label'=>'Manage Evaluacionpersonas', 'url'=>array('admin')),
);*/
?>

<script type="text/javascript">    

$(document).ready(function() {
    
$("#formagregarpersona").submit(function(event){
       event.preventDefault();   
       
       
        $.ajax({
                    type: "POST",
                    url: "../agregarpersona",  
                    data: $("#formagregarpersona").serialize(),
                    dataType: "json",
                    error: function (jqXHR, textStatus){
                        if (jqXHR.status === 0) {                            
                            messageerror("Problema de red, contacte al administrador de sistemas.");
                        } else if (jqXHR.status == 404) {
                            messagewarning("Solicitud no encontrada.");
                        } else if (jqXHR.status == 500) {
                            messageerror("Error 500. Ha ocurrido un problema con el servidor, contacte al administrador de sistemas.");
                        } else if (textStatus === 'parsererror') {
                            messagewarning("Ha ocurrido un inconveniente, intente nuevamente.");
                        } else if (textStatus === 'timeout') {
                            messageerror("Tiempo de espera excedido, intente nuevamente.");
                        } else if (textStatus === 'abort') {
                            messageerror("Se ha abortado la solicitud, intente nuevamente");
                        } else {
                            messageerror("Error desconocido, contacte al administrador de sistemas.");                            
                        }
                    },
                    success: function(resultado){
                        if(resultado.result){
                            $.fn.yiiGridView.update('historial-grid');                            
                            messagesuccess(resultado.value);
                        }else{
                            messageerror(resultado.value);
                        }                       
                        
                    }
            });
            
            $('#cedula').text('-');                             
            $('#colaborador').val('');                                              
            $('#id').val('');                              
            $('#tipo').val('');                             
            $('#colaborador').removeAttr("disabled");
            
            
        });
        
        
        function messagesuccess(message){         
        new Messi(message, 
        {   title: 'Éxito.', 
            titleClass: 'success',                                 
            modal:true,
            closeButton: false,
            buttons: [{id: 0, label: 'Cerrar', val: 'X'}]
                                    
        });
    }
    
    function messageerror(message){
        new Messi(message,
        {   
            title: 'Error', 
            titleClass: 'anim error',                                 
            modal:true                                          
        });
    }
    
    function messagewarning(message){
        new Messi(message,
        {   
            title: 'Advertencia', 
            titleClass: 'anim warning',                                 
            modal:true
        });
    }
       
        });
       

</script>

<h1>Agregar Personas a Evaluación</h1>



<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(		
		'_puesto.nombre',
                 'fecha',
                'descripcion'
	),
)); ?>


<div class="form">
    
        <?php echo CHtml::beginForm('','post',array('id'=>'formagregarpersona')); ?>

        <div class="row">     
        
        <?php  echo CHtml::label('Nombre:', 'colaborador');?>
                
        <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
            'attribute'=>'colaborador',
            'name'=>'colaborador', 
            'id'=>'colaborador',
            'source'=>$this->createUrl('evaluacionpersonas/AutocompleteEvaluado'),
            // additional javascript options for the autocomplete plugin
            'options'=>array(
                 'showAnim'=>'fold',
                'minLength'=>'2',
                'select'=>"js: function(event, ui) {
                    $('#colaborador').attr('disabled', 'true');		
                    $('#cedula').text(ui.item['cedula']);                                                              
                    $('#id').val(ui.item['id']);                              
                    $('#tipo').val(ui.item['tipo']);                              
                    
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
    <div class="row">                  
            <?php echo CHtml::hiddenField('tipo', '-',array('id'=>'tipo','name'=>'tipo')); ?>        
    </div>        
    <div class="row">                  
            <?php echo CHtml::hiddenField('idevaluacion', $model->id,array('id'=>'idevaluacion','name'=>'idevaluacion')); ?>        
    </div>      

    <div class="row buttons">
                <?php echo CHtml::submitButton('Agregar Persona'); ?>
        </div>
    <?php echo CHtml::endForm(); ?>

</div>


 <div id="historial">
        
        <?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'id'=>'historial-grid',
    'columns'=>array(
        'NombreEvaluado',        
        'tipoevaluado',   
    ),
));
?>
    </div>

