<?php echo $this->renderPartial('_reporteencabezado', array('evaluacioncompetencias'=>$evaluacioncompetencias)); ?>

<!--[if IE]><script language="javascript" type="text/javascript" src="../../js/flotr2/lib/excanvas.js"></script><![endif]-->
<?php
Yii::app()->clientScript->registerCoreScript('jquery'); 
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/flotr2/lib/prototype.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/flotr2/flotr2.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/reporte_evaluacioncompetencias.js');
?>

<div id="contentCoberturaRequisitos" style="width:800px;height:400px;"></div>
