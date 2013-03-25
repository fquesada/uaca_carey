<?php
/* @var $this EvaluacionpersonasController */
/* @var $model Evaluacionpersonas */
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/messi.min.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/messi.min.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/evaluacionpersonas.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/evaluacionpersonas.css');


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
                    
                if(ui.item['value']!='')
                {
                    $('#colaborador').attr('disabled', 'true');	                    
                    $('#cedula').text(ui.item['cedula']);                                                              
                    $('#id').val(ui.item['id']);                              
                    $('#tipo').val(ui.item['tipo']);  
                    $('#btnagregarpersona').removeAttr('disabled'); 
                    $('#imgborrar').show();
                 }
                    
                }",                
                 ),
              'htmlOptions'=>array('size'=>'30'),
            ));
                        
        ?>
            
            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/icons/silk/decline.png", "Borrar Persona seleccionada", 
                    array("id"=>"imgborrar", "style" => "padding-left:5px; cursor:pointer; display:none")); ?>
              
                
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
                <?php echo CHtml::submitButton('Agregar Persona',array('disabled'=>'true','id'=>'btnagregarpersona','class'=>'sexybutton sexysimple')); ?>
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
        'TipoEvaluado',   
        'EstadoEvaluacion',   
         array(
                       'class'=>'CButtonColumn',
                       'htmlOptions'=>array('width'=>'10'),
                       'template'=>'{evaluar}',
                       'buttons'=>array(
                           'evaluar'=>array(
                               'label'=>'Evaluar competencias',
                               'imageUrl'=>Yii::app()->request->baseUrl.'/images/icons/silk/script_start.png',
                               //'url'=>'Yii::app()>createUrl("puesto/addcompetence", array("id"=>$data>id))'
                               
                           )                           
                       )
                      
               ),
    ),
));
?>
    </div>
