<?php
/* @var $this ProcesoEDController */
/* @var $procesoed ProcesoEvaluacion */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/adminprocesoed.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/adminprocesoed.css');


$evaluaciones = $procesoed->_evaluaciondesempenos;

function estadoProceso($estado) {                               
if ($estado == "Finalizado") {
return true;
} else {
return false;
}
}

$this->breadcrumbs = array(
    'ED' => array('admin'),
    'Gestionar proceso ED',
);

if(estadoProceso($procesoed->EstadoProceso)){
$this->menu = array(
    array('label' => 'Lista de Procesos ED', 'url' => array('admin')));    
}else{
$this->menu = array(
    array('label' => 'Lista de Procesos ED', 'url' => array('admin')),
    array('label' => 'Editar Proceso ED', 'url' => array('editar', 'id' => $procesoed->id)),
);
}
?>

<h3 style="text-align: center">Gestionar Proceso ED #<?php echo $procesoed->id; ?></h3>

<div>
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $procesoed,
        'attributes' => array(
            array(
                'label' => $procesoed->getAttributeLabel('fecha'),
                'value' => $procesoed->FechaProcesoFormato,
            ),
            array(
                'label' => $procesoed->_periodo->getAttributeLabel('periodo'),
                'value' => $procesoed->_periodo->nombre,
            ),
            'descripcion',
            array(
                'label' => $procesoed->getAttributeLabel('evaluador'),
                'value' => $procesoed->_evaluador->nombrecompleto,
            ),
            array(
                'label' => $procesoed->getAttributeLabel('estado'),
                'value' => $procesoed->EstadoProceso,
            ),
        ),
    ));
    ?>
</div>

<div class="divBtnEnlaces">  

<?php
function mostrarBotonEnlacesCompromisos($evalucionesed){
    $mostrarboton = false;
    foreach ($evalucionesed as $edlinkdesempeno) {
        if (!$edlinkdesempeno->EstadoCompromisosIndicador) {
           $mostrarboton = true;
        }
    }
    return $mostrarboton;
}

function mostrarBotonEnlacesDesempeno($evalucionesed){
    $mostrarboton = false;
    foreach ($evalucionesed as $edlinkdesempeno) {
        if ($edlinkdesempeno->EstadoCompromisosIndicador) {
           $mostrarboton = true;
        }
    }
    return $mostrarboton;
}  

if(!estadoProceso($procesoed->EstadoProceso)){
    if(mostrarBotonEnlacesCompromisos($evaluaciones)){
        echo CHtml::htmlButton('<span class="accept">Ver Enlaces de Compromisos</span>', array('id' => 'verenlacescompromisos', 'class' => 'sexybutton sexysimple')); 
    }    
    if(mostrarBotonEnlacesDesempeno($evaluaciones)){
        echo CHtml::htmlButton('<span class="accept">Ver Enlaces de Evaluaciones</span>', array('id' => 'verenlacesdesempeno', 'class' => 'sexybutton sexysimple'));     
    }
}
?>
</div>

<div>
    <div class="divcolaboradoresevaluados">

        <table border="1" id="tblcolaboradoresevaluados" class="tblcolaboradoresevaluados">
            <thead>
                <tr>
                    <th style="display: none">idec</th>
                    <th></th>      
                    <th></th> 
                    <th></th>       
                    <th colspan="3" id="thcompromisos">Compromisos</th> 
                    <th colspan="2" id="thevaluacion">Evaluación</th>       
                    <th></th>
                </tr>
                <tr id="trencabezados">
                    <th style="display: none">idec</th>      
                    <th>Cédula</th> 
                    <th>Colaborador</th>
                    <th>Puesto</th> 
                    <th>Estado</th> 
                    <th>Fecha Registro de Compromisos</th>
                    <th>Fecha Evaluación de Compromisos</th>
                    <th>Estado</th>
                    <th>Fecha Evaluación</th> 
                    <th>Acciones</th>
                </tr>    
            </thead>  
            <tbody>
                <?php
                foreach ($evaluaciones as $ed) {
                    echo '<tr>';
                    echo '<th style="display: none" id="ided">';
                    echo $ed->id;
                    echo '</th>';
                    echo '<th>';
                    echo $ed->_colaborador->cedula;
                    echo '</th>';
                    echo '<th>';
                    echo $ed->_colaborador->nombrecompleto;
                    echo '</th>';
                    echo '<th>';
                    echo $ed->_puesto->nombre;
                    echo '</th>';
                    echo '<th>';
                    echo $ed->EstadoCompromisosDescripcion;
                    echo '</th>';
                    echo '<th>';
                    echo $ed->FechaRegistroCompromisoFormato;
                    echo '</th>';
                    echo '<th>';
                    echo $ed->FechaCompromisoEvaluacionFormato;
                    echo '</th>';
                    echo '<th>';
                    echo $ed->EstadoEvaluacionDescripcion;
                    echo '</th>';
                    echo '<th>';
                    echo $ed->FechaEvaluacionFormato;
                    echo '</th>';
                    echo '<th>';
                    if (!$ed->EstadoCompromisosIndicador) {
                        $imgingresarcompromiso = CHtml::image(Yii::app()->request->baseUrl . '/images/icons/silk/script_add.png', 'Registrar Compromisos', array("id" => "imgregistrarcompromisos", "cursor:pointer;"));
                        echo CHtml::link($imgingresarcompromiso, array('procesoed/agregarcompromisos/' . CommonFunctions::encrypt($ed->id)), array('title'=>'Registrar compromisos'));
                    } else if (!$ed->EstadoEvaluacionIndicador) {
                        $imgvercompromiso = CHtml::image(Yii::app()->request->baseUrl . '/images/icons/silk/script_key.png', 'Ver Compromisos', array("id" => "imgvercompromisos", "cursor:pointer;"));
                        $imgevaluacion = CHtml::image(Yii::app()->request->baseUrl . '/images/icons/silk/award_star_add.png', 'Registrar Evaluacion', array("id" => "imgregistrarevaluacion", "cursor:pointer;"));
                        echo CHtml::link($imgvercompromiso, array('#'), array('title'=>'Ver compromisos'));
                        echo CHtml::link($imgevaluacion, array('procesoed/registrarevaluacion/' . CommonFunctions::encrypt($ed->id)), array('title'=>'Registrar evaluación'));
                    }
                    if ($ed->EstadoEvaluacionIndicador) {
                        $imgreporte = CHtml::image(Yii::app()->request->baseUrl . '/images/icons/silk/chart_pie.png', 'Generar reporte', array("id" => "imggenerarreporte", "cursor:pointer;"));
                        echo CHtml::link($imgreporte, '#', array('title'=>'Generar reporte'));
                    }
                    echo'</th>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>

    </div>
    <div style="text-align: center"> 
<?php
echo CHtml::button('Volver atrás', array('id' => 'btnvolveratras', 'submit' => array('procesoed/admin'), 'class' => 'sexybutton sexysimple sexylarge'));
?>
    </div>

        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialogenlacescompromisos',
            'options' => array(
                'title' => 'Enlaces de Registro de Compromisos',
                'autoOpen' => false,
                'modal' => true,
                'width' => 500,
                'height' => 500,
                'resizable' => false,
                'draggable' => false,
                'beforeClose' => 'js:function(){$("#divenlacescompromisos").hide();}',
            ),
        ));
        ?>    

    <div id="divenlacescompromisos" >    

        <p>A continuación se muestra la información que debe ser enviada por correo al Evaluador para que proceda a registrar los Compromisos de Desempeño.</p>
        <p>Favor proceder a copiarla.</p>
        <br>

<?php
foreach ($evaluaciones as $edlinkcompromisos) {
    if (!$edlinkcompromisos->EstadoCompromisosIndicador && !$edlinkcompromisos->EstadoEvaluacionIndicador) {
        echo 'Nombre: ' . $edlinkcompromisos->_colaborador->nombrecompleto . '<br/>';
        echo 'Cédula: ' . $edlinkcompromisos->_colaborador->cedula . '<br/>';
        echo 'Puesto: ' . $edlinkcompromisos->_colaborador->nombrepuestoactual . '<br/>';
        echo '<a href="' . Yii::app()->getBaseUrl(true) . '/index.php/procesoed/agregarcompromisos/' . CommonFunctions::encrypt($edlinkcompromisos->id) . '">' . 'Click para ir a la evaluación' . '</a>';
        echo '<hr>';
    }
}
?>

    </div>

<?php $this->endWidget(); ?>      

        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialogenlacesdesempeno',
            'options' => array(
                'title' => 'Enlaces de Evaluación de Desempeño',
                'autoOpen' => false,
                'modal' => true,
                'width' => 500,
                'height' => 500,
                'resizable' => false,
                'draggable' => false,
                'beforeClose' => 'js:function(){$("#divenlacesdesempeno").hide();}',
            ),
        ));
        ?>    

    <div id="divenlacesdesempeno" >    

        <p>A continuación se muestra la información que debe ser enviada por correo al Evaluador para que proceda a realizar las Evaluaciones de Desempeño.</p>
        <p>Favor proceder a copiarla.</p>
        <br>

<?php
foreach ($evaluaciones as $edlinkdesempeno) {
    if ($edlinkdesempeno->EstadoCompromisosIndicador && !$edlinkdesempeno->EstadoEvaluacionIndicador) {
        echo 'Nombre: ' . $edlinkdesempeno->_colaborador->nombrecompleto . '<br/>';
        echo 'Cédula: ' . $edlinkdesempeno->_colaborador->cedula . '<br/>';
        echo 'Puesto: ' . $edlinkdesempeno->_colaborador->nombrepuestoactual . '<br/>';
        echo '<a href="' . Yii::app()->getBaseUrl(true) . '/index.php/procesoed/agregarcompromisos/' . CommonFunctions::encrypt($edlinkdesempeno->id) . '">' . 'Click para ir a la evaluación' . '</a>';
        echo '<hr>';
    }
}
?>

    </div>

<?php $this->endWidget(); ?>
    
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogenlacescompromisosinvidual',
        'options' => array(
            'title' => 'Enlace de Registro de Compromisos',
            'autoOpen' => false,
            'modal' => true,
            'width' => 500,
            'height' => 275,
            'resizable' => false,
            'draggable' => false,
            'beforeClose' => 'js:function(){
            $("#contenidocompromisosindividual").html();
            $("#divenlacescompromisosinvidual").hide();}',
        ),
    ));
    ?>       
    <div id="divenlacescompromisosinvidual" >  
        <p>A continuación se muestra la información que debe ser enviada por correo al Evaluador para que proceda a registrar los Compromisos de Desempeño.</p>
        <p>Favor proceder a copiarla.</p>
        <br>
        <div id="contenidocompromisosindividual"></div>    
    </div>

<?php $this->endWidget(); ?>        

    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogenlacesdesempenoinvidual',
        'options' => array(
            'title' => 'Enlaces de Evaluación de Desempeño',
            'autoOpen' => false,
            'modal' => true,
            'width' => 500,
            'height' => 275,
            'resizable' => false,
            'draggable' => false,
            'beforeClose' => 'js:function(){
            $("#contenidodesempenoindividual").html();
            $("#divenlacesdesempenoinvidual").hide();}',
        ),
    ));
    ?>       
    <div id="divenlacesdesempenoinvidual" >  
        <p>A continuación se muestra la información que debe ser enviada por correo al Evaluador para que proceda a realizar la Evaluación de Desempeño.</p>
        <p>Favor proceder a copiarla.</p>
        <br>
        <div id="contenidodesempenoindividual"></div>    
    </div>

<?php $this->endWidget(); ?>      
    
</div>
