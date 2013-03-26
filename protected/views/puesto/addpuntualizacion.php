<?php
/* @var $this PuestoController */
/* @var $model Puesto */
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
//    Yii::app()->clientScript->registerScript('actualizar', "
//    $('.competenciaasociado-grid').update(function(){
//            $.fn.yiiGridView.update('competenciaasociado-grid');
//            return false;
//    });
//    ");
//?>

    <?php
    $this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
        'Agregar puntualización'
    );
    ?>
    <h1>Puesto</h1>
    
    <?php $this->widget('zii.widgets.CDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                    'codigo',
                    'nombre',
                    'descripcion'		
            ),
    )); ?>
    
    <?php Yii::app()->session['puesto']=$model->id;?>
    
    <?php 
    $puntualizacion = new Puntualizacion();
    $filterForm = new FiltersForm();
    ?>
    
    <p></br> </br> </br> </p>
   
 <h1>Paso 1: Crear la puntualización</h1>
 <h5>Presione la opción "Crear puntualización" para crear y asignarle una puntualización al puesto. Posteriormente verifique que la puntualización haya quedado asociada al puesto en la tabla de abajo</h5>
 
    <?php echo CHtml::link('Crear puntualización', "",
            array(
                'style'=>'cursor: pointer; text-decoration: underline;',
                'onclick'=>"{addPuntualizacion(); $('#dialogPuntualizacion').dialog('open');}"
                )
            );
    ?>
 
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'=>'dialogPuntualizacion',
        'options'=>array(
            'title'=>'Crear puntualizacion',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>700,
            'height'=>400,
            'close'=>'js: function(event, ui){$.fn.yiiGridView.update("puntualizacionasociado-grid");}'
        ),
        
    ));
    ?>
    
 <div class="divForForm"></div>
 
 <?php $this->endWidget();?>
 
 <script type="text/javascript">
     
 function addPuntualizacion()
 {
     <?php echo CHtml::ajax(array(
         'url'=>array('puntualizacion/create'),
         'data'=>"js:$(this).serialize()",
         'type'=>'post',
         'dataType'=>'json',
         'success'=>"function(data)
             {
                if(data.status == 'failure')
                {
                    $('#dialogPuntualizacion div.divForForm').html(data.div);
                    $('#dialogPuntualizacion div.divForForm form').submit(addPuntualizacion);
                }
                else
                {
                    $('#dialogPuntualizacion div.divForForm').html(data.div);
                    setTimeout(\"$('#dialogPuntualizacion').dialog('close') \",3000);
                }
             }"
     ))
    ?>;
            
    return false;
        
 }
 </script>
    <?php
    $puestopun = new PuestoPuntualizacion();
    ?>
    
    <?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'puntualizacionasociado-grid',
        'dataProvider'=>$puestopun->search($model->id),
        'template'=>"{pager}\n{items}\n{pager}\n{summary}",
	'columns'=>array(
                    'NombrePunt',
                    'IndicadorPunt',
                    array(
                            'class'=>'CButtonColumn',
                            'htmlOptions'=>array('width'=>'20'),
                            'template'=>'{delete}',
                            'buttons'=>array(
                                'delete'=>array(
                                    'url'=>'Yii::app()->createUrl("puestopuntualizacion/delete", array("puntualizacion"=>$data->puntualizacion, "puesto"=>$data->puesto))',
                                )
                            )
                    ),
	),
    )); ?>

     <?php if(Yii::app()->user->hasFlash('success')):?>
     <script type="text/javascript">
          new Messi('<?php echo Yii::app()->user->getFlash('success'); ?>',
            { title: 'Éxito.',
                titleClass: 'success',
                autoclose: '4000',
                modal:true
            });
     </script>
     <?php endif;?>

          <?php if(Yii::app()->user->hasFlash('error')):?>
     <script type="text/javascript">
          new Messi('<?php echo Yii::app()->user->getFlash('error'); ?>',
            { title: 'Error',
                titleClass: 'error',
                autoclose: '4000',
                modal:true
            });
     </script>
     <?php endif;?>