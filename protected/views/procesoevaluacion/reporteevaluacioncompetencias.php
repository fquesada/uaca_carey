<?php echo $this->renderPartial('_reporteencabezado', array('evaluacioncompetencias'=>$evaluacioncompetencias)); ?>

<!--[if IE]><script language="javascript" type="text/javascript" src="../../js/flotr2/lib/excanvas.js"></script><![endif]-->
<?php
Yii::app()->clientScript->registerCoreScript('jquery'); 
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/flotr2/lib/prototype.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/flotr2/flotr2.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/reporte_evaluacioncompetencias.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/reporteevaluacioncompetencias.css');
?>

<div class="contenreporte">
<div id="contentValoracionRelativa"></div>
</div>

<div class="contenreporte">
<div id="contentCoberturaRequisitos"></div>

<div id="contentComparacionCompetencias"></div>
</div>

<div id="promedioponderado">
    <p> Promedio Ponderado: 
    <?php
        echo " ".$evaluacioncompetencias->promedioponderado;
    ?>
    </p>
</div>

<div id="tbldesgloseevaluacion">
    <table>
        <thead>
        <th>Competencia</th>
        <th>Valor Relativo</th>
        <th>Calificación</th>
        </thead>
        <tbody>
            <?php
            for ($index = 0; $index < count($relativo); $index++) {                 
                 echo "<tr>";
                 echo "<td>".$relativo[$index]["eje"]."</td>";
                 echo "<td>".$relativo[$index]["calificacion"]."</td>";
                 echo "<td>".$calificado[$index]["calificacion"]."</td>";
                 echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>


