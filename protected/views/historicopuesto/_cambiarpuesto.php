<?php
/* @var $this HistoricopuestoController */
/* @var $model Historicopuesto */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'historicopuesto-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>


       <div class="row">
		<?php echo $form->labelEx($model,'unidadnegocio'); ?>
		<?php echo $form->dropDownList($model,'unidadnegocio', CHtml::listData(UnidadNegocio::model()->findAllByAttributes(array('estado' => '1')),'id','nombre'),array('empty' => 'Seleccione una unidad de negocio',
                            'ajax'=> array('type'=>'POST',
                                                            'url'=>CController::createUrl('getpuestos'),
                                                            'update'=> '#'.CHtml::activeId($model,'puesto'),
                                                            
                                                            )
                                                      )
                            ); ?>
                <?php echo $form->error($model,'unidadnegocio'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'puesto'); ?>
		<?php echo $form->dropDownList($model,'puesto',CHtml::listData(Puesto::model()->findAllByAttributes(array('estado' => '1')),'id','nombre'),array('empty'=>'Seleccione un puesto')) ?>
                <?php echo $form->error($model,'puesto'); ?>
        </div>

        <div class="row buttons">
                <?php echo CHtml::submitButton('Ejecutar',array('class'=>'sexybutton sexysimple sexylarge'));?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->