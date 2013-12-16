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
    
    <?php
    
        echo CHtml::beginForm('','POST',array('id'=>'formcorreo'))
    
    ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo CHtml::errorSummary($correo); ?>

	<div class="row">
		<?php echo CHtml::activelabelEx($correo,'asunto'); ?>
		<?php echo CHtml::activetextField($correo,'asunto',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo CHtml::error($correo,'asunto'); ?>
	</div>

	<div class="row">
		<?php echo CHtml::activelabelEx($correo,'mensaje'); ?>
		<?php echo CHtml::activetextArea($correo,'mensaje',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo CHtml::error($correo,'mensaje'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Enviar',array('submit'=>'../enviar', 'class'=>'sexybutton sexysimple sexylarge'));?>
	</div>
        

            <?php // 
                echo CHtml::endForm()
            ?>

</div><!-- form -->