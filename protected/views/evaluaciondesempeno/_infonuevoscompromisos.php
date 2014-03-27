<div class="content_section_evaluacion">
    <h2>Informacion de la evaluación desempeño</h2>
    <table class="table_info_evaluacion">
        <tbody>
            <tr>
                <td class="label_column"><label>Fecha registro</label></td>
                <td class="data_column"><?php echo $this->obtenerfechahoy();?></td>
            </tr>
            <tr>
                <td class="label_column"><label>Evaluador</label></td>
                <td class="data_column"><?php echo $model['nombreevaluador'];?></td>
            </tr>
            <tr>
                <td class="label_column"><label>Colaborador</label></td>
                <td class="data_column"><?php echo $model['nombrecolaborador'];?></td>
            </tr>
            <tr>
                <td class="label_column"><label>Puesto</label></td>
                <td class="data_column"><?php echo $model['nombrepuesto'];?></td>
            </tr>  
        </tbody>
    </table>  
</div>
