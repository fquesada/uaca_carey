<?php
/* @var $this ProcesoEDController */
/* @var $ed Evaluaciondesempeno */
?>

<div class="content_section_calificacioncompromisos">
        <p class="ptitulocompromisos">Calificación de Compromisos</p>
        <table id="tblcompromisos" class="tblcompromisos">
        <thead>
            <tr>
                <th id="idcompromiso"></th>
                <th>Puntualizacion</th>
                <th>Indicador</th>
                <th>Compromiso</th>                
                <th>Calificación</th> 
        <thead>
        <tbody>
        
        <?php
                
                $compromisos = $ed->_compromisos;
                
                foreach ($compromisos as $compromiso) {
                    echo '<tr>';
                    echo '<td id="idcompromiso">';
                    echo $compromiso->id;
                    echo '</td>';
                    echo '<td>';
                    echo $compromiso->_puntualizacion->puntualizacion;
                    echo '</td>';
                    echo '<td>';
                    echo $compromiso->_puntualizacion->indicadorpuntualizacion;
                    echo '</td>';
                    echo '<td>';
                    echo $compromiso->compromiso;
                    echo '</td>';
                    echo '<td>';
                    echo CHtml::dropDownList('puntajep', 'puntajep', CHtml::listData(Puntaje::model()->findAll('estado=1'), 'valor', 'valor'), array('empty' => 'Seleccione calificacion', 'id' => 'ddlpuntajecompromisos'));
                    echo '<p id="ddlpuntajecompromisoserror"  class="mensajeerror">Debe seleccionar una calificacion</p>';
                    echo '</td>';
                    echo '</tr>';
                }            
        ?>
        </tbody>
    </table>
        
</div>        

<div class="promediopuntualizacion">
        <p>Promedio: <span>0</span>
        </p>
</div>

    

