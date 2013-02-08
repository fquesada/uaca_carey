<?php
/* @var $this ColaboradorController */
/* @var $model Colaborador */
/* @var $form CActiveForm */
 $idusuario= Yii::app()->user->id;
 $usuario= Usuario::model()->findByPk($idusuario);
 $numempresa = $usuario->empresa;   
 $fecha = date('Y-m-d');
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'colaborador-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'cedula'); ?>
		<?php echo $form->textField($model,'cedula'); ?>
		<?php echo $form->error($model,'cedula'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'apellido1'); ?>
		<?php echo $form->textField($model,'apellido1',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'apellido1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'apellido2'); ?>
		<?php echo $form->textField($model,'apellido2',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'apellido2'); ?>
	</div>

	<div class="row">
		<?php echo $form->hiddenField($model,'fechaedicion',array('value'=> $fecha)); ?>
		
	</div>

	<div class="row">
		<?php echo $form->hiddenField($model,'activo',array('size'=>1,'maxlength'=>1,'value'=> '1')); ?>
		
	</div>

	<div class="row">
                <?php if (Yii::app()->user->checkAccess('Admin') || Yii::app()->user->checkAccess('Authenticated')){
                        if ($numempresa === null){
                           echo $form->labelEx($model,'empresa');
                           echo $form->dropDownList($model,'empresa', CHtml::listData(Empresa::model()->findAll(),'id','nombre'),array('empty' => 'Seleccione una empresa'));
                            }
                        else{
                            echo $form->hiddenField($model,'empresa', array('value' => $numempresa));;
                        }
                }
                else {
                } ?>
                <?php echo $form->error($model,'empresa'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'puesto'); ?>
                <?php if (Yii::app()->user->checkAccess('Admin') || Yii::app()->user->checkAccess('Authenticated')){
                        if ($numempresa === null){
                           echo $form->dropDownList($model,'puesto', CHtml::listData(Puesto::model()->findAll(),'id','nombre'),array('empty' => 'Seleccione un puesto'));
                           }
                        else{
                           echo $form->dropDownList($model,'puesto', CHtml::listData(Puesto::model()->findAll(),'id','nombre'),array('empty' => 'Selecccione un puesto'));
                        }
                      }                   
                else {
                } ?>
		<?php echo $form->error($model,'puesto'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->