<?php
/* @var $this ProcesoEvaluacionController */
/* @var $ec EvaluacionCompetencias */

?>

<div id="divhabilidadec" class="divhabilidadec">
    <p class="ptitulohabilidad">Calificación de Habilidades</p>
    <table id="tblhabilidadec" class="tblhabilidadec">
        <thead>
            <tr>
                <th id="idcompetencia"></th>
                <th id="tipocompetencia"></th>
                <th>Habilidad</th>
                <th>Descripción</th>
                <th>Método seleccionado</th> 
                <th>Variable equivalente en el método seleccionado</th>
                <th>Calificación variable equivalente</th>
                <th>Calificación</th>
                <th id="ponderacion">Ponderacion</th>
            </tr>
        <thead>
        <tbody>
            <?php
            $competencias = $ec->_puesto->competenciasactuales;
            $competenciascore = $ec->_puesto->competenciascoreactuales;
            if (!$competencias || count($competencias) < 3) {//CLEAN CODE REGLA DE NEGOCIO DEBE ESTA EN BD
                echo '<tr>';
                echo '<td id="idcompetencia">';
                echo "false";
                echo '</td>';
                echo '<td id="tipocompetencia">';
                echo "false";
                echo '</td>';
                echo '<td id="errorcompetencia">';
                echo "El puesto debe poseer mínimo 3 competencias para continuar con la evaluacion.";
                echo '</td>';
                Yii::app()->clientScript->registerScript('validadorcompetencias', "
                        $('#btnguardarec').attr('disabled', 'true');
                        $('#btnguardarec').hide();
                ");
            } else {
                foreach ($competenciascore as $competenciacore){
                    echo '<tr>';
                    echo '<td id="idcompetencia">';
                    echo $competenciacore["id"];
                    echo '</td>';
                    echo '<td id="tipocompetencia">';
                    echo "core";
                    echo '</td>';
                    echo '<td>';
                    echo $competenciacore["competencia"]." (Core)";
                    echo '</td>';
                    echo '<td>';
                    echo $competenciacore["descripcion"];
                    echo '</td>';
                    echo '<td>';
                    echo CHtml::dropDownList('metodoseleccionado', '', CHtml::listData(Metodoseleccionado::model()->findAll('estado=1'), 'metodo', 'metodo'), array('empty' => 'Seleccione el metodo de calificacion', 'id' => 'ddlmetodoseleccionado'));
                    echo '<p id="ddlmetodoseleccionadoerror"  class="mensajeerror">Debe seleccionar un metodo de calificacion</p>';                    
                    echo '</td>';
                    echo '<td>';
                    echo CHtml::textField('variablequivalente', '', array('id' => 'tfvariablequivalente', 'class' => 'tfvariablequivalente'));
                    echo '</td>';
                    echo '<td>';
                    echo CHtml::textField('calificacionvariablequivalente', '', array('id' => 'tfcalificacionvariablequivalente', 'class' => 'tfcalificacionvariablequivalente'));
                    echo '</td>';
                    echo '<td>';
                    echo CHtml::dropDownList('puntaje', '', CHtml::listData(Puntaje::model()->findAll('estado=1'), 'valor', 'valor'), array('empty' => 'Seleccione calificacion', 'id' => 'ddlpuntajehabilidades'));
                    echo '<p id="ddlpuntajehabilidadeserror"  class="mensajeerror">Debe seleccionar una calificacion</p>';
                    echo '</td>';
                    echo '<td id="ponderacion">';
                    echo $competenciacore["ponderacion"];
                    echo '</td>';
                    echo '</tr>';
                }                
                foreach ($competencias as $competencia) {                    
                    echo '<tr>';
                    echo '<td id="idcompetencia">';
                    echo $competencia["id"];
                    echo '</td>';
                    echo '<td id="tipocompetencia">';
                    echo "nocore";
                    echo '</td>';
                    echo '<td>';
                    echo $competencia["competencia"];
                    echo '</td>';
                    echo '<td>';
                    echo $competencia["descripcion"];
                    echo '</td>';
                    echo '<td>';
                    echo CHtml::dropDownList('metodoseleccionado', '', CHtml::listData(Metodoseleccionado::model()->findAll('estado=1'), 'metodo', 'metodo'), array('empty' => 'Seleccione el metodo de calificacion', 'id' => 'ddlmetodoseleccionado'));
                    echo '<p id="ddlmetodoseleccionadoerror"  class="mensajeerror">Debe seleccionar un metodo de calificacion</p>'; 
                    echo '</td>';
                    echo '<td>';
                    echo CHtml::textField('variablequivalente', '', array('id' => 'tfvariablequivalente', 'class' => 'tfvariablequivalente'));
                    echo '</td>';
                    echo '<td>';
                    echo CHtml::textField('calificacionvariablequivalente', '', array('id' => 'tfcalificacionvariablequivalente', 'class' => 'tfcalificacionvariablequivalente'));
                    echo '</td>';
                    echo '<td>';
                    echo CHtml::dropDownList('puntaje', '', CHtml::listData(Puntaje::model()->findAll('estado=1'), 'valor', 'valor'), array('empty' => 'Seleccione calificacion', 'id' => 'ddlpuntajehabilidades'));
                    echo '<p id="ddlpuntajehabilidadeserror"  class="mensajeerror">Debe seleccionar una calificacion</p>';
                    echo '</td>';
                    echo '<td id="ponderacion">';
                    echo $competencia["ponderacion"];
                    echo '</td>';
                    echo '</tr>';
                }
            }
            ?>           
        </tbody>
    </table>    
</div>