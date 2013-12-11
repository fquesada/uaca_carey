<?php
/* @var $this ProcesoevaluacionController */
/* @var $model Procesoevaluacion */
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/messi.min.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/messi.min.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/procesoevaluacion.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/procesoevaluacion.css');


$this->breadcrumbs=array(
	'Evaluación de competencias'=>array('admin'),
	'Gestionar personas',
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

$this->menu=array(
	array('label'=>'Gestión de evaluación de competencias' , 'url'=>array('admin')),	
);
?>

<h3 style="text-align: center">Gestión de personas</h3>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
                array('label' => 'Nombre proceso', 'name' => 'descripcion'),                
                array('label' => 'Puesto', 'name' => '_puesto.nombre'),		
                array('label' => 'Fecha', 'name' => 'fecha', 'value' => $this->gridmysqltophpdate($model->fecha)),
                                
	),
)); ?>

<br/>
<div class="form">
    
        <?php echo CHtml::beginForm('','post',array('id'=>'formagregarpersona')); ?>
        <fieldset>
            <legend>Búsqueda de persona por nombre</legend>
        <div class="row">     
        
        <?php  echo CHtml::label('Nombre:', 'colaborador');?>
                
        <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
            'attribute'=>'colaborador',
            'name'=>'colaborador', 
            'id'=>'colaborador',
            'source'=>$this->createUrl('procesoevaluacion/AutocompleteEvaluado'),
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
   </fieldset>
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
                       'template'=>'{evaluar}{reporte}',
                       'buttons'=>array(
                           'evaluar'=>array(
                               'label'=>'Evaluar competencias',
                               'imageUrl'=>Yii::app()->request->baseUrl.'/images/icons/silk/script_start.png',
                               'visible' => '($data->estadoevaluacion==="Finalizado")?false:true;',
                               //'url'=>'Yii::app()>createUrl("puesto/addcompetence", array("id"=>$data>id))'                               
                           ),
                           'reporte'=>array(
                                'label'=>'Ver reporte',
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/icons/silk/chart_pie.png',
                                'url'=>'Yii::app()->createUrl("procesoevaluacion/reporteevaluacioncompetencias", array("idevaluacioncompetencias" => $data->id, "idevaluaciondesempeno" => $data->evaluaciondesempeno))',
                                'visible' => '($data->estadoevaluacion==="Finalizado")?true:false;',
                                
                            )
                       )
                      
               ),
    ),
));
?>
    </div>
