<div id="reporteencabezado">

    <div id="tituloreporte" style="text-align: center">
        <h3>Modelo de Gestión por Competencias</h3>
        <h4>Modelo ampliado por evaluación de competencias</h4>
    </div>
    <div id="dividcompetenciapersonas" style="display: none">
    <?php
    echo CHtml::label($evaluacioncompetencias->id, '', array("id"=>"lblidcompetencia"));
    echo CHtml::label($evaluacioncompetencias->_evaluacionpersonas->id, '', array("id"=>"lblidpersonas"));
    ?>
    </div>
    <div id="reporteinfo">
            <table>
                <tbody>
                    <tr>
                        <td>Puesto:</td>
                        <td><?php echo $evaluacioncompetencias->_evaluacionpersonas->_puesto->nombre; ?></td>          
                        <td>Tipo de reclutamiento:</td>
                        <td><?php echo $evaluacioncompetencias->tipoevaluado; ?></td>
                    </tr>
                    <tr>
                        <td>Nombre:</td>
                        <td><?php echo $evaluacioncompetencias->_evaluado->nombrecompleto;  ?></td>
                        <td>Cédula:</td>
                        <td><?php echo $evaluacioncompetencias->_evaluado->cedula;  ?></td>
                    </tr>            
                    <tr>
                        <td>Evaluador:</td>
                        <td><?php echo $evaluacioncompetencias->_evaluador->nombrecompleto; ?></td>
                        <td>Fecha evaluación:</td>
                        <td><?php echo $this->gridmysqltophpdate($evaluacioncompetencias->fechaevaluacion); ?></td>
                    </tr>            
                </tbody>
            </table>        
        </div>
    
</div>
