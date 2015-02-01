<?php
/* @var $this ProcesoEvaluacionController */
/* @var $procesoec ProcesoEvaluacion */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/adminprocesoec.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/adminprocesoec.css'); //CLEAN CODE

$evaluaciones = $procesoec->_evaluacionescompetencias;


function estadoProceso($estado) {                               
if ($estado == "Finalizado") {
return true;
} else {
return false;
}
}

$this->breadcrumbs = array(
    'EC' => array('admin'),
    'Gestionar proceso EC',
);

if(estadoProceso($procesoec->EstadoProceso)){
    $this->menu = array(
    array('label' => 'Lista de Procesos EC', 'url' => array('admin')));
}
else{
$this->menu = array(
    array('label' => 'Lista de Procesos EC', 'url' => array('admin')),
    array('label' => 'Editar Proceso EC', 'url' => array('editarprocesoec', 'id' => $procesoec->id)),
);
}
?>

<h3 style="text-align: center">Gestionar Proceso EC #<?php echo $procesoec->id; ?></h3>

<div>
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $procesoec,
        'attributes' => array(
            array(
                'label' => $procesoec->getAttributeLabel('fecha'),
                'value' => $procesoec->FechaProcesoFormato,
            ),
            array(
                'label' => $procesoec->_periodo->getAttributeLabel('periodo'),
                'value' => $procesoec->_periodo->nombre,
            ),
            'descripcion',
            array(
                'label' => $procesoec->getAttributeLabel('evaluador'),
                'value' => $procesoec->_evaluador->nombrecompleto,
            ),
            array(
                'label' => $procesoec->getAttributeLabel('estado'),
                'value' => $procesoec->EstadoProceso,
            ),
        ),
    ));
    ?>
</div>


<div class="divBtnEnlaces"> 
<?php
if(!estadoProceso($procesoec->EstadoProceso)){
    echo CHtml::htmlButton('<span class="accept">Ver Enlaces de Evaluaciones</span>', array('id' => 'verenlaces', 'class' => 'sexybutton sexysimple')); 
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
                    <th colspan="2" id="thevaluacion">Evaluación</th>      
                    <th></th>
                </tr>
                <tr id="trencabezados">
                    <th style="display: none">idec</th>      
                    <th>Cédula</th> 
                    <th>Colaborador</th>
                    <th>Puesto</th> 
                    <th>Estado</th> 
                    <th>Fecha Evaluación</th> 
                    <th>Acciones</th>
                </tr>    
            </thead>  
            <tbody>
                <?php
                foreach ($evaluaciones as $ec) {
                    echo '<tr>';
                    echo '<th style="display: none" id="idec">';
                    echo $ec->id;
                    echo '</th>';
                    echo '<th>';
                    echo $ec->_colaborador->cedula;
                    echo '</th>';
                    echo '<th>';
                    echo $ec->_colaborador->nombrecompleto;
                    echo '</th>';
                    echo '<th>';
                    echo $ec->_puesto->nombre;
                    echo '</th>';
                    echo '<th>';
                    echo $ec->estadoevaluaciondescripcion;
                    echo '</th>';
                    echo '<th>';
                    echo $ec->fechaevaluacionecformato;
                    echo '</th>';
                    echo '<th>';
                    $imgcorreo = CHtml::image(Yii::app()->request->baseUrl . '/images/icons/silk/email_go.png', 'links evaluacion', array("id" => "imgenviarcorreo", "cursor:pointer;"));
                    if (!$ec->estadoevaluacionindicador)
                        echo CHtml::link($imgcorreo, Yii::app()->getBaseUrl(true) . '/index.php/procesoevaluacion/evaluarprocesoec/' . CommonFunctions::encrypt($ec->id));
                    $imgreporte = CHtml::image(Yii::app()->request->baseUrl . '/images/icons/silk/chart_pie.png', 'Generar reporte', array("id" => "imggenerarreporte", "cursor:pointer;"));
                    if ($ec->estadoevaluacionindicador)
                        echo CHtml::link($imgreporte, '#');
                    echo'</th>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>

    </div>
    <div style="text-align: center"> 
    <?php
    echo CHtml::button('Volver atrás', array('id' => 'btnvolveratras', 'submit' => array('procesoevaluacion/admin'), 'class' => 'sexybutton sexysimple sexylarge'));
    ?>
    </div>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogenlaces',
    'options' => array(
        'title' => 'Enlaces de evaluaciones',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 500,
        'resizable' => false,
        'draggable' => false,
        'beforeClose' => 'js:function(){$("#divenlaces").hide();}',
    ),
));
?>    

    <div id="divenlaces" >    

        <p>A continuación se muestra la información que debe ser enviada por correo al Evaluador.</p>
        <p>Favor proceder a copiarla.</p>
        <br>

    <?php
    foreach ($evaluaciones as $eclink) {
        if (!$eclink->estadoevaluacionindicador) {
            echo 'Nombre: ' . $eclink->_colaborador->nombrecompleto . '<br/>';
            echo 'Cédula: ' . $eclink->_colaborador->cedula . '<br/>';
            echo 'Puesto: ' . $eclink->_colaborador->nombrepuestoactual . '<br/>';
            echo '<a href="' . Yii::app()->getBaseUrl(true) . '/index.php/procesoevaluacion/evaluarprocesoec/' . CommonFunctions::encrypt($eclink->id) . '">' . 'Click para ir a la evaluación' . '</a>';
            echo '<hr>';
        }
    }
    ?>

    </div>

    <?php $this->endWidget(); ?>  


    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogenlacesinvidual',
        'options' => array(
            'title' => 'Enlace de la evaluación',
            'autoOpen' => false,
            'modal' => true,
            'width' => 500,
            'height' => 275,
            'resizable' => false,
            'draggable' => false,
            'beforeClose' => 'js:function(){
            $("#contenidoenlaceindividual").html();
            $("#divenlacesinvidual").hide();}',
        ),
    ));
    ?>       
    <div id="divenlacesinvidual" >  

        <p>A continuación se muestra la información que debe ser enviada por correo al Evaluador.</p>
        <p>Favor proceder a copiarla.</p>
        <br>

        <div id="contenidoenlaceindividual"></div>    
    </div>

<?php $this->endWidget(); ?>      


</div>