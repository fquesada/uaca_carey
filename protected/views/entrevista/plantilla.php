<?php
/* @var $this EntrevistaController */
/* @var $model Entrevista */

$this->breadcrumbs=array(
	'Entrevistas'=>array('index'),
	$model->id,
);

?>

<h1>Entrevista #<?php echo $model->id; ?></h1>


<style type="text/css">
table.sample {
	border-width: 1px;
	border-spacing: 2px;
	border-style: outset;
	border-color: gray;
	border-collapse: separate;
	background-color: white;
}
table.sample th {
	border-width: 1px;
	padding: 1px;
	border-style: inset;
	border-color: gray;
	background-color: white;
	-moz-border-radius: ;
}
table.sample td {
	border-width: 1px;
	padding: 1px;
	border-style: inset;
	border-color: gray;
	background-color: white;
	-moz-border-radius: ;
}
</style>

<table class="sample">
    
    <tr>
            <td  colspan="3" align="center">
                Entrevista
            </td>            
    </tr>
    
    <tr>
            <td  colspan="1" align="center">
                Entrevistado:
            </td>            
            <td  colspan="2" align="center">
                <?php echo $model->obtenerNombreEntrevistado(); ?>
            </td>          
    </tr>
       <tr>
            <td  colspan="1" align="center">
                Entrevistador:
            </td>            
            <td  colspan="2" align="center">
               <?php $entrevistador = Colaborador::model()->findByPk($model->entrevistador)->obtenerNombreCompleto();
                echo $entrevistador;
    ?>
            </td>          
    </tr>
    <tr>
            <td  colspan="1" align="center">
                Puesto:
            </td>            
            <td  colspan="2" align="center">
               <?php $puesto = Puesto::model()->findByPk($model->_vacante->puesto);
                echo $puesto->nombre;                
    ?>
            </td>          
    </tr>
    
    
     <tr>
            <td  colspan="3" align="center">
                Preguntas
            </td>            
    </tr>
    
    <tr>
            <td  align="center">
                Número
            </td>            
            <td  align="center">
                Pregunta
            </td> 
            <td  align="center">
                U.V
            </td> 
    </tr>
    
    <?php
    
    foreach($puesto->_competencias as $competencia)
    {   
        echo "<tr>";
        echo "<td>1</td>";
        echo "<td>".$competencia->pregunta."</td>";
        echo "<td></td>";
        echo "</tr>";
    }
    
    ?>
    
</table>
