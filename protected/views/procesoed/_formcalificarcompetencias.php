<?php
/* @var $this ProcesoEDController */
/* @var $ed Evaluaciondesempeno */
?>

<div id="divcompetencia" class="divcompetencia">
    <p class="pTituloCompetencias">Calificación de Competencias</p>
    <table id="tblcompetencia" class="tblcompetencia">
        <thead>
            <tr>
                <th id="idcompetencia"></th>
                <th id="tipocompetencia"></th>
                <th>Competencia</th>
                <th>Descripción</th>             
                <th>Calificación</th>
                <th id="ponderacion">Ponderacion</th>
            </tr>
        <thead>
        <tbody>
            <?php            
            $competencias = $ed->_puesto->competenciasactuales;
            $competenciascore = $ed->_puesto->competenciascoreactuales;
            if (!$competencias) {
                echo '<tr>';
                echo '<td id="idcompetencia">';
                echo "false";
                echo '</td>';
                echo '<td id="tipocompetencia">';
                echo "false";
                echo '</td>';
                echo '<td id="errorcompetencia">';
                echo "El puesto debe poseer competencias para continuar con la evaluacion.";
                echo '</td>';
                Yii::app()->clientScript->registerScript('validadorcompetencias', "
                        $('#btnguardarec').attr('disabled', 'true');	                                                                                          
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
                    echo '<td id="competencia">';
                    echo $competenciacore["competencia"]." (Core)";
                    echo '</td>';
                    echo '<td id="descripcioncompetencia">';
                    echo $competenciacore["descripcion"];
                    echo '</td>';                  
                    echo '<td id="calificacioncompetencia">';
                    echo CHtml::dropDownList('puntajec', 'puntajec', CHtml::listData(Puntaje::model()->findAll('estado=1'), 'valor', 'valor'), array('empty' => 'Seleccione calificacion', 'id' => 'ddlpuntajecompetencias'));
                    echo '<p id="ddlpuntajecompetenciaserror"  class="mensajeerror">Debe seleccionar una calificacion</p>';
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
                    echo '<td id="competencia">';
                    echo $competencia["competencia"];
                    echo '</td>';
                    echo '<td id="descripcioncompetencia">';
                    echo $competencia["descripcion"];
                    echo '</td>';                   
                    echo '<td id="calificacioncompetencia">';
                    echo CHtml::dropDownList('puntajec', 'puntajec', CHtml::listData(Puntaje::model()->findAll('estado=1'), 'valor', 'valor'), array('empty' => 'Seleccione calificacion', 'id' => 'ddlpuntajecompetencias'));
                    echo '<p id="ddlpuntajecompetenciaserror"  class="mensajeerror">Debe seleccionar una calificacion</p>';
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

    
<div class="promediocompetencias">
        <p>Promedio: <span>0</span>
        </p>
</div>
