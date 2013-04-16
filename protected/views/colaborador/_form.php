<?php
/* @var $this ColaboradorController */
/* @var $model Colaborador */
/* @var $form CActiveForm */
?>

<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/sexybuttons.css');
?>


<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'colaborador-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Los campos con  <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>
        <?php echo $form->errorSummary($historial); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'cedula'); ?>
		<?php echo $form->textField($model,'cedula'); ?>
		<?php echo $form->error($model,'cedula'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>20,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'apellido1'); ?>
		<?php echo $form->textField($model,'apellido1',array('size'=>20,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'apellido1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'apellido2'); ?>
		<?php echo $form->textField($model,'apellido2',array('size'=>20,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'apellido2'); ?>
	</div>
        
       <div class="row">
		<?php echo $form->labelEx($historial,'unidadnegocio'); ?>
		<?php echo $form->dropDownList($historial,'unidadnegocio', CHtml::listData(UnidadNegocio::model()->findAllByAttributes(array('estado' => '1')),'id','nombre'),array('empty' => 'Seleccione una unidad de negocio',
                            'ajax'=> array('type'=>'POST',
                                                            'url'=>CController::createUrl('Historicopuesto/getpuestos'),
                                                            'update'=> '#'.CHtml::activeId($historial,'puesto'),
                                                            
                                                            )
                                                      )
                            ); ?>
                <?php echo $form->error($historial,'unidadnegocio'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($historial,'puesto'); ?>
		<?php echo $form->dropDownList($historial,'puesto',CHtml::listData(Puesto::model()->findAllByAttributes(array('estado' => '1')),'id','nombre'),array('empty'=>'Seleccione un puesto')) ?>
                <?php echo $form->error($historial,'puesto'); ?>
        </div>
        
        <div class="row buttons">
                <?php echo CHtml::submitButton('Crear',array('class'=>'sexybutton sexysimple sexylarge'));?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->