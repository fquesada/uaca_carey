<?php
/* @var $this ProcesoEvaluacionController */
?>

<div id="divhabilidadnoequivalente" class="divhabilidadnoequivalente">
    <p class="ptitulohabilidadnoequivalente">Habilidades no Equivalentes al Puesto</p>
    <table id="tblhabilidadnoequivalente" class="tblhabilidadnoequivalente">
        <thead>
            <tr>
                <th id="idhabilidadnoequivalente"></th>
                <th>Método seleccionado</th>
                <th>Variable equivalente segun método seleccionado</th>
                <th>Variable equivalente segun manual de puestos</th>                
                <th>Calificación</th>
                <th>Puesto Potencial 1</th>
                <th>Puesto Potencial 2</th>                                
            </tr>
        <thead>
        <tbody>
            <?php
            for ($fila = 1; $fila < 6; $fila++) {
                echo '</p>';
                    echo '<tr>';
                    echo '<td id="idhabilidadnoequivalente">';
                    echo $fila;
                    echo '</td>';
                    echo '<td>';
                    echo CHtml::textField('metodovariablenoquivalente', '', array('id' => 'tfmetodovariablenoquivalente', 'class' => 'tfmetodovariablenoquivalente'));
                    echo '</td>';
                    echo '<td>';
                    echo CHtml::textField('variablenoquivalente', '', array('id' => 'tfvariablenoquivalente', 'class' => 'tfvariablenoquivalente'));
                    echo '</td>';
                    echo '<td>';
                    echo CHtml::dropDownList('competencia', '', CHtml::listData(Competencia::model()->findAll('estado=1'), 'id', 'competencia'), array('empty' => 'Seleccione habilidad', 'id' => 'ddlcompetencia', 'class'=>'ddlcompetencia'));
                    echo '</td>';
                    echo '<td>';
                    echo CHtml::dropDownList('puntajenoequivalente', '', CHtml::listData(Puntaje::model()->findAll('estado=1'), 'valor', 'valor'), array('empty' => 'Seleccione calificacion', 'id' => 'ddlpuntajenoequivalente'));
                    echo '</td>';                    
                    echo '<td>';
                    echo CHtml::dropDownList('puesto1', '', CHtml::listData(Puesto::model()->findAll('estado=1'), 'id', 'nombre'), array('empty' => 'Seleccione puesto', 'id' => 'ddlpuesto1', 'class'=>'ddlpuestonoequivalente'));
                    echo '</td>';
                    echo '<td>';
                    echo CHtml::dropDownList('puesto2', '', CHtml::listData(Puesto::model()->findAll('estado=1'), 'id', 'nombre'), array('empty' => 'Seleccione puesto', 'id' => 'ddlpuesto2', 'class'=>'ddlpuestonoequivalente'));
                    echo '</td>';                 
                    echo '</tr>';
            }
            ?>       
        </tbody>
    </table>
</div>
