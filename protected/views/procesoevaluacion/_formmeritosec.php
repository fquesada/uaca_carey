<?php
/* @var $this ProcesoEvaluacionController */
/* @var $ec EvaluacionCompetencias */
?>

<div id="divmeritosec" class="divmeritosec">
    <p class="ptitulomeritos">Calificación de Méritos</p>
    <table id="tblmeritos" class="tblmeritos">
        <thead>
            <tr>
                <th id="idmerito"></th>
                <th>Mérito</th>
                <th>Descripción</th>
                <th>Calificación</th>
                <th id="ponderacion">Ponderacion</th>
            </tr>
        <thead>
        <tbody>
            <?php
            $meritos = $ec->_puesto->meritosactuales;
            if (!$meritos) {
                echo '<tr>';
                echo '<td id="idmerito">';
                echo "false";
                echo '</td>';
                echo '<td id="errormerito">';
                echo "El puesto debe poseer meritos para continuar con la evaluacion.";
                echo '</td>';
                Yii::app()->clientScript->registerScript('validadormeritos', "
                        $('#btnguardarec').attr('disabled', 'true');	                                                                                          
                ");
            } else {
                foreach ($meritos as $merito) {
                    echo '<tr>';
                    echo '<td id="idmerito">';
                    echo $merito->id;
                    echo '</td>';
                    echo '<td>';
                    echo $merito->_tipomerito->nombre;
                    echo '</td>';
                    echo '<td>';
                    echo $merito->descripcion;
                    echo '</td>';
                    echo '<td>';
                    echo CHtml::dropDownList('puntaje', 'puntaje', CHtml::listData(Puntaje::model()->findAll('estado=1'), 'valor', 'valor'), array('empty' => 'Seleccione calificacion', 'id' => 'ddlpuntajemeritos'));
                    echo '<p id="ddlpuntajemeritoserror"  class="mensajeerror">Debe seleccionar una calificacion</p>';
                    echo '</td>';                    
                    echo '<td id="ponderacion">';
                    echo $merito->ponderacion;
                    echo '</td>';
                    echo '</tr>';
                }
            }
            ?>           
        </tbody>
    </table>
</div>