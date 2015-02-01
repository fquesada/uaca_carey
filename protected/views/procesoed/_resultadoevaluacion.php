<?php
/* @var $this ProcesoEDController */
/* @var $ed Evaluaciondesempeno */
?>

<div class="divevaluacioned"> 
  <p class="pTituloEvaluacion">Resultados de la Evaluación</p>
    <table class="table_evaluacion_resultado">
        <tbody>
            <tr>
                <td class="label_column">Nivel en Puntualizaciones</td>
                <td id="puntualizacionnivel" name="puntualizacionnivel">0</td>
            </tr> 
            <tr>
                <td class="label_column">Nivel en Competencias</td>
                <td id="competenciasnivel" name="competenciasnivel">0</td> 
            </tr>  
            <tr>                
                <td class="label_column">Evaluación Final *</td>
                <td id="evaluacion" name="evaluacion">0</td>
            </tr>
         </tbody>
         <tfoot>
            <tr> 
                <td class="label_column">Rango</td>
                <td id="rango" name="rango"></td>
            </tr>             
          </tfoot>
        
    </table> 
  
      <table class="table_evaluacion_rango" id="rangoevaluaciones">
        <thead>
            <tr>
                <th>Rango</th>
                <th>Interpretación</th>            
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="label_column">De 0 a 2</td>
                <td class="insuficiente" id="insuficiente">Desempeño Insuficiente</td>
            </tr> 
            <tr>
                <td class="label_column">Más de 2 y menos de 3</td>
                <td class="mejora" id="mejora">Oportunidad de Mejora</td> 
            </tr>
            <tr>
                <td class="label_column">De 3 a menos de 4</td>
                <td class="esperado" id="esperado">Desempeño esperado</td>
            </tr>
            <tr>
                <td class="label_column">De 4 a menos de 5</td>
                <td class="sobresaliente" id="sobresaliente">Desempeño sobresaliente</td>
            </tr>
            <tr>
                <td class="label_column">5</td>
                <td class="superior" id="superior">Desempeño superior</td>
            </tr>                                                                
        </tbody>
    </table> 
  
<p class="pexplicacionNotaFinal">* La evaluación final corresponde al promedio de lo obtenido en Nivel de Puntualizaciones y Nivel de Compromisos.</p>
  
  
</div>

<div class="divComentariosEvaluacionED">   
    <p class="pTituloComentarios">Comentarios Adicionales</p>
    <?php echo CHtml::textArea('comentario','',array('maxlength'=>300, 'id'=>'tacomentario', 'class' => 'tacomentario', 'placeholder' => 'Comentarios adicionales sobre la evaluación...')); ?>
</div>