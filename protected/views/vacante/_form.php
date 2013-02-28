<?php
/* @var $this VacanteController */
/* @var $model Vacante */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vacante-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'unidadnegocio'); ?>
		<?php echo $form->dropDownList($model,'unidadnegocio', CHtml::listData(Unidadnegocio::model()->findAllByAttributes(array('estado' => '1')),'id', 'nombre'),array('empty' => 'Selecione una unidad de negocio', 'ajax' => array(
                                'type'=>'POST',
                                'url'=>CController::createUrl('vacante/unidadnegociopuesto'),
                                'update'=>'#'.CHtml::activeId($model,'puesto')))); ?>
            
		<?php echo $form->error($model,'unidadnegocio'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'puesto'); ?>
                 <?php echo $form->dropDownList($model,'puesto', array(),array('empty' => 'Selecione un puesto')); ?>		
		<?php echo $form->error($model,'puesto'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'periodo'); ?>
		<?php echo $form->dropDownList($model,'periodo', CHtml::listData(Periodo::model()->findAllByAttributes(array('estado' => '1')),'id', 'nombre'),array('empty' => 'Selecione un periodo')); ?>
		<?php echo $form->error($model,'periodo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fechareclutamiento'); ?>
		<?php $imagen = Yii::app()->baseUrl."/images/icons/silk/calendar.png";
                
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'language'=>'es',
                            'model'=>$model,
                            'attribute'=>'fechareclutamiento',
                            'flat'=>false,
                            'options'=>array(
                                'firstDay'=>1,
                                'showOn'=>"both",
                                'buttonImage'=> $imagen,
                                'buttonImageOnly'=> true,
                                //'minDate'=>-31,
                                //'maxDate'=>0,
                                'constrainInput'=>true,
                                'currentText'=>'Now',
                                //'dateFormat'=>'dd/mm/yy',
                                'dateFormat'=>'yy-mm-dd',
                            ),
                            'htmlOptions'=>array(
                            ),
                            )); ?>
		<?php echo $form->error($model,'fechareclutamiento'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fechaseleccion'); ?>
		<?php 
                
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'language'=>'es',
                            'model'=>$model,
                            'attribute'=>'fechaseleccion',
                            'flat'=>false,
                            'options'=>array(
                                'firstDay'=>1,
                                'showOn'=>"both",
                                'buttonImage'=> $imagen,
                                'buttonImageOnly'=> true,
                                //'minDate'=>-31,
                                //'maxDate'=>0,
                                'constrainInput'=>true,
                                'currentText'=>'Now',
                                //'dateFormat'=>'dd/mm/yy',
                                'dateFormat'=>'yy-mm-dd',
                            ),
                            'htmlOptions'=>array(
                            ),
                            )); ?>
		<?php echo $form->error($model,'fechaseleccion'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->