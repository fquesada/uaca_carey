<?php
/* @var $model Historicopuesto*/
/* @var $colaborador Colaborador*/
/* @var $indicador Boolean*/
/* @var $ingresos Int
/* @var $form CActiveForm */
?>

<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/sexybuttons.css');
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'puestonuevo-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'unidadnegocio'); ?>
		<?php echo $form->dropdownlist($model,'unidadnegocio',
                            CHtml::listData(Unidadnegocio::model()->findAll(),'id','nombre'),
                                array(
                                    'ajax'=>array(
                                        'type'=>'POST',
                                        'url'=>  CController::createUrl('Historicopuesto/obtenerpuestos'),
                                        'update'=>'#'.CHtml::activeId($model, 'puesto'),
                                    ),
                                    'prompt'=>'Seleccione una unidad de negocio'
                                )                            
                        );
                ?>
		<?php echo $form->error($model,'unidadnegocio'); ?>
	</div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'puesto'); ?>
		<?php echo $form->dropDownList($model,'puesto',                    
                        array(/*'prompt'=>'Seleccione un puesto'*/)); ?>
		<?php echo $form->error($model,'codigo'); ?>
	</div>
        
        <br></br>


	<div class="row buttons">
                <?php //echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar',array('class'=>'sexybutton sexysimple sexylarge')); ?>
                <?php
                    if($indicador){
                        if($ingresos == 1)
                            echo CHtml::submitButton('Actualizar',array('submit'=>'../actualizarpuesto?idcolaborador='. $colaborador->id, 'class'=>'sexybutton sexysimple sexylarge'));
                        else
                            echo CHtml::submitButton('Actualizar',array('submit'=>'../colaborador/actualizarpuesto?idcolaborador='. $colaborador->id, 'class'=>'sexybutton sexysimple sexylarge'));
                    }
                    else{
                        if($ingresos == 1)
                            echo CHtml::submitButton('Asignar',array('submit'=>'../asignarpuesto?idcolaborador='. $colaborador->id, 'class'=>'sexybutton sexysimple sexylarge'));
                        else
                            echo CHtml::submitButton('Asignar',array('submit'=>'../colaborador/asignarpuesto?idcolaborador='. $colaborador->id, 'class'=>'sexybutton sexysimple sexylarge'));
                    }
                ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->