<?php
/* @var $this EvaluacionpersonasController */
/* @var $habilidadesespeciales HabilidadesEspeciales*/
/* @var $evaluacionpersonanombre string*/
/* @var $hashabilidades boolean*/
?>
<div>
    

<h4 style="text-align:center"><?php echo $evaluacionpersonanombre; ?></h4>    
<table border="1" id="tblhabilidades">
  <thead>
    <tr>
      <th>Evaluación Especial</th>      
      <th>Descripción</th> 
      <th>Ponderación</th>      
    </tr>
  </thead>  
  <tbody>   
      <?php
      if($hashabilidades){      
        foreach ($habilidadesespeciales as $habilidades) {
            echo "<tr>";
            echo "<td>".$habilidades->nombre."</td>";
            echo "<td>".$habilidades->descripcion."</td>";
            echo "<td>".$habilidades->ponderacion."</td>";
            echo "</tr>";
        }      
      }
      else{
           echo "<tr><td>Este proceso no posee habilidades</td></tr>";
      }
      ?>
  </tbody>
</table>
    
</div>