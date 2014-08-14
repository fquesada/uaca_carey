<?php
/* @var $this ProcesoEDController */
/* @var $ed Evaluaciondesempeno */
?>

<div class="content_section_evaluacion">
        <p class="ptitulomeritos">Registro de Compromisos</p>
        <table id="tblmeritos" class="tblmeritos">
        <thead>
            <tr>
                <th id="idpuntualizacion"></th>
                <th>Puntualizacion</th>
                <th>Indicador</th>                
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
                    echo '</tr>';
                }
            }
        ?>
        </tbody>
    </table>
        
        
        
        <?php echo CHtml::textArea('comentario','',array('size'=>60,'maxlength'=>300, 'id'=>'txtcomment', 'class' => 'textarea_evaluacion_comentario', 'placeholder' => 'Comentarios adicionales sobre compromisos...')); ?>
</div>


<div class="content_section_evaluacion">
        <h2>Ejecución de la evaluación desempeño</h2>
        <table class="table_ejecucion_evaluacion" id="tblejecucion">
            <tbody>
                <tr>
                    <td class="label_column"><label for="ddlperiodo">Período de la evaluación</label></td>
                    <td class="data_column"><?php echo CHtml::dropDownList('periodo', 'periodo',CHtml::listData(Periodo::model()->findAll(), 'id', 'nombre'), array('empty'=>'Elija un periodo', 'id'=>'ddlperiodo')) ?> <div class="errored" id="ddlperiodoerror">  Debe seleccionar un periodo</div></td>
                    
                </tr>                  
                <tr>
                    <td class="label_column"><label for="dpfecha">Fecha de la evaluación</label></td>
                    <td class="data_column"><?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
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
                    ));?> <div class="errored" id="dpfechaerror">  Debe seleccionar una fecha</div></td>
                </tr>                  
            </tbody>
        </table>  
</div>
    

