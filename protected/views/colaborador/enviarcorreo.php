<?php
/* @var $this ColaboradorController */
/* @var $model Colaborador */
/* @var $form CActiveForm */
?>

<?php
    //CSS
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/messi.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/sexybuttons.css');
    
    //JS
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/messi.min.js');
?>


    <?php
    $this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
        'Enviar notificación'
    );
    ?>
    <h1>Persona a notificar</h1>
    
    <?php $this->widget('zii.widgets.CDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                    'nombre',
                    'apellido1',
                    'apellido2',
                    'correo',
                    
            ),
    )); ?>
    
    <?php Yii::app()->session['destinatario']=$model->correo;?>
    
    <?php $correo = new correo(); ?>
    
<div class="form">
    
    <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'correo-form',
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                    'validateOnSubmit'=>true,
            ),
    )); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($correo); ?>

	<div class="row">
		<?php echo $form->labelEx($correo,'asunto'); ?>
		<?php echo $form->textField($correo,'asunto',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($correo,'asunto'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($correo,'mensaje'); ?>
		<?php echo $form->textArea($correo,'mensaje',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($correo,'mensaje'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Enviar',array('submit'=>'../enviar', 'class'=>'sexybutton sexysimple sexylarge'));?>
	</div>
        

            <?php $this->endWidget(); ?>

</div><!-- form -->