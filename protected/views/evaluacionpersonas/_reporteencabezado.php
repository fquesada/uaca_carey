<div id="reporteencabezado">

    <div id="tituloreporte" style="text-align: center">
        <h3>Modelo de Gestion por Competencias</h3>
        <h4>Modelo ampliado por evaluacion de competencias</h4>
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
                        <td></td>
                        <td>Cedula:</td>
                        <td></td>
                    </tr>            
                    <tr>
                        <td>Evaluador:</td>
                        <td><?php echo $evaluacioncompetencias->_evaluador->nombrecompleto; ?></td>
                        <td>Fecha evaluacion:</td>
                        <td><?php echo $this->gridmysqltophpdate($evaluacioncompetencias->fechaevaluacion); ?></td>
                    </tr>            
                    <tr>
                        <td>Origen evaluacion</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                </tbody>
            </table>        
        </div>
    
</div>
