<?php
/* @var $this UsuarioController */
/* @var $model Usuario */
/* @var $form CActiveForm */

$fecha = CommonFunctions::datenow();

Yii::app()->clientScript->registerScript('autocomplete', '
$["ui"]["autocomplete"].prototype["_renderItem"] = function( ul, item) {
return $( "<li></li>" )
.data( "item.autocomplete", item )
.append( $( "<a></a>" ).html( item.label ) )
.appendTo( ul );
};
',
  CClientScript::POS_READY
);

?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'usuario-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'login'); ?>
		<?php echo $form->textField($model,'login',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'login'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
        
         <div class="row">
                <?php echo $form->labelEx($model,'confirmar contraseña'); ?>
                <?php echo $form->passwordField($model,'confirmarPassword',array('size'=>60,'maxlength'=>100,'value'=>'')); ?>
                <?php echo $form->error($model,'confirmarPassword'); ?>
        </div>


	<div class="row">
		<?php echo $form->hiddenField($model,'estado',array('value'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->hiddenField($model,'empresa',array('value'=>1)); ?>
	</div>
        
        <div class="row">                
                <?php echo $form->checkbox($model,'confirmacion',array('value'=>'S','uncheckValue'=>'N')); ?> <b>Asignar usuario del sistema a un colaborador.</b><?php echo CHtml::image(Yii::app()->request->baseUrl."/images/icons/silk/help.png", "Ayuda usuario colaborador", array("id"=>"imgcolaboradorhelp", "style" => "padding-left:5px; cursor:pointer")) ?>
	</div>
        
        <div class="row" id="divcolaborador">
                <?php echo $form->labelEx($model,'colaborador'); ?>
                <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                    //'attribute'=>'colaborador',
                    'name'=>'colaborador', 
                    'id'=>'colaborador',
                    'source'=>$this->createUrl('usuario/autocompletecolaborador'),
                    // additional javascript options for the autocomplete plugin
                    'options'=>array(
                         'showAnim'=>'fold',
                        'minLength'=>'2',
                        'select'=>"js: function(event, ui) {                     
                            $('#pk').val(ui.item['id']); 
                            var x = $('#pk').val();
//                            alert(x);
                        }",                
                         ),
                      'htmlOptions'=>array('size'=>'30'),
                    ));
                ?>
        </div>
        
         <div class="row">
            <?php echo $form->hiddenField($model,'colaborador',array('id'=>'pk')); ?>
         </div>
        
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', array('class'=>'sexybutton sexysimple sexylarge')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
