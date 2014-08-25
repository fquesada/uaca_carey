<?php
/* @var $this ProcesoEDController */
/* @var $ed Evaluaciondesempeno */
?>

<div class="content_section_registrocompromisos">
        <p class="ptitulocompromisos">Registro de Compromisos</p>
        <table id="tblcompromisos" class="tblcompromisos">
        <thead>
            <tr>
                <th id="idpuntualizacion"></th>
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
                echo '<td id="idpuntualizacion">';                
                echo '</td>';
                echo '<td id="errorpuntualizacion">';
                echo "El puesto debe poseer puntualizaciones para continuar con la evaluacion.";
                echo '</td>';
                echo '</tr>';
                Yii::app()->clientScript->registerScript('validadorpuntualizaciones', "
                        $('#btncompromisos').attr('disabled', 'true');	                                                                                          
                ");
            } else {
                foreach ($puntualizaciones as $puntualizacion) {
                    echo '<tr>';
                    echo '<td id="idpuntualizacion">';
                    echo $puntualizacion->id;
                    echo '</td>';
                    echo '<td>';
                    echo $puntualizacion->puntualizacion;
                    echo '</td>';
                    echo '<td>';
                    echo $puntualizacion->indicadorpuntualizacion;
                    echo '</td>';
                    echo '<td>';
                    echo CHtml::textArea('compromiso', '', array('id' => 'tacompromiso', 'class' => 'tacompromiso','placeholder' => 'Ingrese el compromiso'));
                    echo '</td>';
                    echo '</tr>';
                }
            }
        ?>
        </tbody>
    </table>
        
</div>        
<div>   <?php echo CHtml::label("Comentarios Adicionales","", array('id' => 'lblcomentarioadicionales'))?>
        <?php echo CHtml::textArea('comentario','',array('size'=>60,'maxlength'=>300, 'id'=>'tacomentario', 'class' => 'tacomentario', 'placeholder' => 'Comentarios adicionales sobre compromisos...')); ?>
</div>


<div class="content_section_fechaevaluacion">
    <p class="ptitulofechaevaluacion">Fecha de Revision de los Compromisos</p>        
                   <label for="dpfecha">Fecha de Revision</label> 
                   <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'id' => 'dpfecha',
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
                                        $('#dpfechaerror').hide();
                                                                         
                                }",
                        ),
                        'htmlOptions'=>array(                            
                            'readonly' => 'readonly',
                            'style'=>'width: 118px; text-align: center'
                        ),
                    ));?> 
                    <div class="errored" id="divfechaerror">  Debe seleccionar una fecha
                    </div>
                             
     
</div>
    

