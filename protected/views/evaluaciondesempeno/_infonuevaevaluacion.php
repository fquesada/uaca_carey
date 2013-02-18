<div class="content_section_evaluacion">
    <h2>Informacion de la evaluación desempeño</h2>
    <table class="table_info_evaluacion">
        <tbody>
            <tr>
                <td class="label_column"><label>Fecha registro</label></td>
                <td class="data_column"><?php echo $this->FechaMysqltoPhp($model->fecharegistrocompromiso);?></td>
                
                <td class="label_column"><label>Evaluador</label></td>
                <td class="data_column"><?php echo $model->evaluador;?></td>             
            </tr>
            <tr>
                <td class="label_column"><label>Colaborador</label></td>
                <td class="data_column"><?php echo $model->colaborador;?></td>
                
                <td class="label_column"><label>Puesto</label></td>
                <td class="data_column"><?php echo $model->puesto;?></td>
            </tr>
            <tr>
                <td class="label_column"><label>Fecha evaluacion</label></td>
                <td class="data_column"><?php echo $this->FechaMysqltoPhp($model->fechaevaluacion);?></td>
                
                <td class="label_column"><label>Periodo</label></td>
                <td class="data_column"><?php echo $model->periodo;?></td>
            </tr>            
        </tbody>
    </table>  
</div>