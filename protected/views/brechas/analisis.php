<?php
/* @var $this BrechasController */


Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/brechas.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/brechas.css');
Yii::app()->clientScript->registerScript('autocomplete', '
  $["ui"]["autocomplete"].prototype["_renderItem"] = function( ul, item) {
                return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( $( "<a></a>" ).html( item.label ) )
                .appendTo( ul );
            };
  
', CClientScript::POS_READY
);

$this->breadcrumbs = array(
    'Análisis de Brechas',
);

$this->menu = array(
    array('label' => 'Inicio', 'url' => array('site/index')),
    array('label' => 'Historial de Evaluaciones', 'url' => array('brechas/HistoricoEvaluaciones')),   
);
?>

<h3 style="text-align: center">Análisis de Brechas</h3>

<div class="divFiltros">
        <p><span id="spTipoEvaluacion">Tipo de Evaluación</span></p> 
        <?php
        echo CHtml::dropDownList('ddlproceso','',array('EC' => 'Evaluación de Competencias', 'ED' => 'Evaluación de Desempeño'), array('id'=>'ddlproceso'));
        ?>
         
        <p><span id="spFechaInicio">Fecha inicio</span></p>
            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'id' => 'dpFechaInicio',
                        'name' => 'FechaInicio',                        
                        'language' => 'es',
                        'options' => array(                            
                            'showAnim'=>'fold',
                            'dateFormat'=>'dd-mm-yy',
                            'changeYear'=>true,
                            'changeMonth'=>true,
                            'showOn' => 'button',
                            'buttonImage'=>Yii::app()->baseUrl.'/images/icons/silk/calendar.png',
                            'buttonImageOnly' => true,
                            'onClose' => "js:function(dateText, inst){
                                        $('#dpFechaInicioerror').hide();
                                                                         
                                }",
                        ),
                        'htmlOptions'=>array(
                            'class' => 'dpFecha',
                            'readonly' => 'readonly',
                            'style'=>'width: 118px; text-align: center'
                        ),
                    ));?> 
          <p class="mensajeerror" id="dpFechaInicioerror"></p>  
          <p><span id="spFechaFinal">Fecha final</span></p>     
          <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'id' => 'dpFechaFinal',
                        'name' => 'FechaFinal',                        
                        'language' => 'es',
                        'options' => array(                            
                            'showAnim'=>'fold',
                            'dateFormat'=>'dd-mm-yy',
                            'changeYear'=>true,
                            'changeMonth'=>true,
                            'showOn' => 'button',
                            'buttonImage'=>Yii::app()->baseUrl.'/images/icons/silk/calendar.png',
                            'buttonImageOnly' => true,
                            'onClose' => "js:function(dateText, inst){
                                        $('#dpFechaFinalerror').hide();
                                                                         
                                }",
                        ),
                        'htmlOptions'=>array(
                            'class' => 'dpFecha',
                            'readonly' => 'readonly',
                            'style'=>'width: 118px; text-align: center'
                        ),
                    ));?> 
        <p class="mensajeerror" id="dpFechaFinalerror"></p>  
        <p><span id="spTipoCarga">Tipo de Análisis</span></p>
        <input id="cbmasiva" type="radio" name="tipocarga" value="masiva" checked>Análisis Global (Todos los colaboradores)</input>        
        <input id="cbdepartamento" type="radio" name="tipocarga" value="departamento">Por Departamento(s)</input>     
</div>  
        <?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogDepartamentos',
    'options'=>array(
        'title'=>'Seleccionar Departamentos',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>400,
        'height'=>600,
        'resizable' => false,
        'draggable' => false,
        'beforeClose' => 'js:function(event){$("#divDepartamentos").hide();}',
    ),
));
?>

<div id="divDepartamentos">    
    
     <button  id="btnMarcarTodosDepartamento" type="button" class="sexybutton sexysimple"><span class="accept">Marcar todos</span></button>
     <button  id="btnDesmarcarTodosDepartamento" type="button" class="sexybutton sexysimple"><span class="accept">Desmarcar todos</span></button>
    
    <?php
    echo CHtml::checkboxList('cblDepartamento', '', CHtml::listData(Unidadnegocio::model()->findAll('estado=1'), 'id', 'nombre'), array('id' => 'cblDepartamento', 'class' => 'cblDepartamento'));
    ?>
    <button  id="btnSeleccionDepartamento" type="button" class="sexybutton sexysimple"><span class="accept">Seleccionar Departamentos</span></button>
    <p class="mensajeerror" id="Departamentoerror">Debe seleccionar al menos un departamento.</p>  
</div>

<?php $this->endWidget();?>


<div id="divHistoricoEvaluaciones" class="divHistoricoEvaluaciones">
    <div id="divCargando" class="divCargando">
    
    <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/preload.GIF", "Cargando", 
                    array("id"=>"imgCargando", "class"=>"imgCargando")); 
          echo CHtml::label('Cargando...','')
    ?>
    </div>
    
    <div id="divNoEvaluaciones" class="divNoEvaluaciones"></div>
  
</div>

<div style="text-align: center"> 
    <?php
    echo CHtml::button('Generar Reporte', array('id' => 'btnGenerarAnalisis', 'class' => 'sexybutton sexysimple sexylarge'));
    ?>
</div>

<div style="text-align: center"> 
    <?php
    echo CHtml::button('Volver atrás', array('id' => 'btnvolveratras', 'submit' => array('site/index'), 'class' => 'sexybutton sexysimple sexylarge'));
    ?>
</div>
