<?php
/* @var $this ProcesoEDController */
/* @var $proceso ProcesoEvaluacion tipo ED */
?>

<div class="form">
    <p>Campos con * son obligatorios.</p> 

    <div class="row">
        <?php echo CHtml::label('Periodo *', 'periodo'); ?>
        <?php
        echo CHtml::dropDownList('ddlperiodo', $proceso->periodo, CHtml::listData(Periodo::model()->findAll(), 'id', 'nombre'), array('empty' => 'Elija el periodo', 'id' => 'ddlperiodo'));
        ?>       
        <div id="ddlperiodoerror" class="errorevaluacionpersona">Debe seleccionar un periodo</div>
    </div> 

    <div class="row">
        <?php echo CHtml::label('Nombre del proceso *', 'descripcion'); ?>          
        <?php
        echo CHtml::textArea('txtareadescripcion', $proceso->descripcion, array('id' => 'txtdescripcion', 'rows' => '3', 'cols' => '40', 'maxlength' => '90'));
        ?>                    
        <div id="txtdescripcionerror" class="errorevaluacionpersona">Debe ingresar el nombre del proceso.</div>
    </div>

    <fieldset>
        <legend>Búsqueda de Colaborador por nombre</legend>
        <div class="row">
            <?php echo CHtml::label('Evaluador *', 'evaluador'); ?>
            <?php
            echo CHtml::textField('colaborador', $proceso->_evaluador->nombrecompleto, array('id' => 'busquedaevaluador', 'size' => '30'));
            Yii::app()->clientScript->registerScript('activarevaluador', "
                        $('#busquedaevaluador').attr('disabled', 'true');	                                                                   
                        $('#btnbusquedacolaboradores').removeAttr('disabled'); 
                ");
            ?>                   
            <?php echo CHtml::image(Yii::app()->request->baseUrl . "/images/icons/silk/decline.png", "Borrar Colaborador seleccionado", array("id" => "imgborrarevaluador", "style" => "padding-left:5px; cursor:pointer; display:none"));
            ?>
            <div id="busquedaevaluadorerror" class="errorevaluacionpersona">Debe seleccionar un evaluador</div>
        </div>  
        <div class="row">        
            <?php echo CHtml::label('Puesto', 'puesto'); ?>            
            <?php
            echo CHtml::label($proceso->_evaluador->nombrepuestoactual, 'puesto', array('id' => 'puestoevaluador', 'name' => 'puesto'));
            ?>

        </div>

        <div class="row">                  
            <?php
            echo CHtml::hiddenField('idevaluador', $proceso->evaluador, array('id' => 'idevaluador', 'name' => 'id'));
            ?>        
        </div>   
    </fieldset>

    <div id="opcionescargacolaborador" class="opcionescargacolaborador">
        <?php echo CHtml::label("Seleccione el tipo de carga de Colaboradores *", 'lblopcionescarga', array('id' => 'lblopcionescarga')); ?>
        <input id="cbmasiva" type="radio" name="tipocarga" value="masiva">Carga Masiva (Todos los colaboradores)</input>        
        <input id="cbdepartamento" type="radio" name="tipocarga" value="departamento">Departamento</input>     
        <input id="cbindividual" type="radio" name="tipocarga" value="individual">Individual</input>     
    </div>



    <div>
        <?php
        echo '<button  id="btnbusquedacolaboradores" type="button" class="sexybutton sexysimple" disabled="disabled"><span class="add">Buscar colaborador(es)</span></button>';
        ?>



    </div>
    </br>
    </br> 
    <?php
    echo $this->renderPartial('_formagregarcolaborador');
    ?>
    <div>

        <table border="1" id="tblcolaboradores">
            <thead>
                <tr>
                    <th style="display: none">id</th>
                    <th>Cédula</th>      
                    <th>Colaborador</th> 
                    <th>Puesto</th> 
                    <th>Acciones</th>
                </tr>
            </thead>  
            <tbody>   
                <?php
                foreach ($proceso->_evaluaciondesempenos as $ed) {
                    echo '<tr>';
                    echo '<td name="idcolaborador" style="display: none">';
                    echo $ed->colaborador;
                    echo '</td>';
                    echo '<td name="cedula">';
                    echo $ed->_colaborador->cedula;
                    echo '</td>';
                    echo '<td name="colaborador">';
                    echo $ed->_colaborador->nombrecompleto;
                    echo '</td>';
                    echo '<td name="puesto">';
                    echo $ed->_colaborador->nombrepuestoactual;
                    echo '</td>';
                    echo '<td>';
                    echo CHtml::image(Yii::app()->request->baseUrl . "/images/icons/silk/delete.png", "Eliminar colaborador", array("id" => "borrarcolaborador", "style" => "padding-left:5px; cursor:pointer;"));
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>

    </div>
    <div id="tblcolaboradoreserror" class="errorevaluacionpersona">Debe agregar al menos un colaborador</div>
</div>