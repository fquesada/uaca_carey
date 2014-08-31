<?php
/* @var $this ProcesoEDController */
/* @var $ed Evaluaciondesempeno */
?>

<div class="divRegistroCompromisos">
        <p class="pTituloCompromisos">Registro de Compromisos</p>
        <table id="tblCompromisos" class="tblCompromisos">
        <thead>
            <tr>
                <th id="idPuntualizacion"></th>
                <th>Puntualizacion</th>
                <th>Indicador</th>
                <th>Compromiso</th>                
            </tr>
        <thead>
        <tbody>
        
        <?php
                $puntualizaciones = $ed->_puesto->_puntualizaciones;
                if (!$puntualizaciones) {
                echo '<tr>';
                echo '<td id="idPuntualizacion">';                
                echo '</td>';
                echo '<td id="errorCompromisos">';
                echo "El puesto debe poseer puntualizaciones para continuar con la evaluacion.";
                echo '</td>';
                echo '</tr>';
                Yii::app()->clientScript->registerScript('validadorpuntualizaciones', "
                        $('#btncompromisos').attr('disabled', 'true');	                                                                                          
                ");
            } else {
                foreach ($puntualizaciones as $puntualizacion) {
                    echo '<tr>';
                    echo '<td id="idPuntualizacion">';
                    echo $puntualizacion->id;
                    echo '</td>';
                    echo '<td class="puntualizacion">';
                    echo $puntualizacion->puntualizacion;
                    echo '</td>';
                    echo '<td class="indicadorPuntualizacion">';
                    echo $puntualizacion->indicadorpuntualizacion;
                    echo '</td>';
                    echo '<td>';
                    echo CHtml::textArea('compromiso', '', array('id' => 'tacompromiso', 'class' => 'tacompromiso','placeholder' => 'Ingrese el compromiso', 'maxlength'=>800));
                    echo '<p id="tacompromisoerror"  class="mensajeerror">Debe ingresar el compromiso.</p>';
                    echo '</td>';
                    echo '</tr>';
                }
            }
        ?>
        </tbody>
    </table>
        
</div> 

<div class="divComentariosCompromisos">   
    <p class="pTituloComentarios">Comentarios Adicionales</p>
    <?php echo CHtml::textArea('comentario','',array('maxlength'=>300, 'id'=>'tacomentario', 'class' => 'tacomentario', 'placeholder' => 'Comentarios adicionales sobre compromisos...')); ?>
</div>


<div class="divFechaRevision">
    <p class="pTituloFechaEvaluacion">Fecha de Revision de los Compromisos</p>                          
                   <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'id' => 'dpFecha',
                        'name' => 'fechaevaluacion',                        
                        'language' => 'es',
                        'options' => array(                            
                            'showAnim'=>'fold',
                            'dateFormat'=>'dd-mm-yy',
                            'changeYear'=>true,
                            'changeMonth'=>true,
                            'showOn' => 'button',
                            'buttonImage'=>Yii::app()->baseUrl.'/images/icons/silk/calendar.png',
                            'buttonImageOnly' => true,
                            'onClose' => "js:function(dateText, inst){
                                        $('#dpFechaerror').hide();
                                                                         
                                }",
                        ),
                        'htmlOptions'=>array(
                            'class' => 'dpFecha',
                            'readonly' => 'readonly',
                            'style'=>'width: 118px; text-align: center'
                        ),
                    ));?> 
                    <p class="mensajeerror" id="dpFechaerror">Debe seleccionar una fecha</p>
                             
     
</div>
    

