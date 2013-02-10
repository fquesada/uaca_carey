<div class="content_section_evaluacion">
        <h2>Ejecución de la evaluación</h2>
        <table class="table_ejecucion_evaluacion" id="tblejecucion">
            <tbody>
                <tr>
                    <td class="label_column"><label for="ddlperiodo">Período de la evaluación</label></td>
                    <td class="data_column"><?php echo CHtml::dropDownList('periodo', 'periodo',CHtml::listData(Periodo::model()->findAll(), 'id', 'nombre'), array('empty'=>'Elija un periodo', 'id'=>'ddlperiodo')) ?></td>                    
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
                            'buttonImageOnly' => true
                        ),
                        'htmlOptions'=>array(                            
                            'readonly' => 'readonly',
                            'style'=>'width: 118px; text-align: center'
                        ),
                    ));?></td>
                </tr>                  
            </tbody>
        </table>  
</div>
    
<div class="content_section_evaluacion">
        <h2>Compromisos</h2>
        <?php
                echo $this->obtenerpuntualizaciones($model['idpuesto']);
        ?>
        
        <?php echo CHtml::textArea('comentario','',array('size'=>60,'maxlength'=>300, 'id'=>'txtcomment', 'class' => 'textarea_evaluacion_comentario', 'placeholder' => 'Comentarios adicionales sobre compromisos...')); ?>
</div> 