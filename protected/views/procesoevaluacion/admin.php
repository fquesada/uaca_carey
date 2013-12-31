<?php
/* @var $this EvaluacionpersonasController */
/* @var $ec ProcesoEvaluacion */
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/evaluacionpersonas.js');//CLEAN CODE

$this->breadcrumbs=array(	
	'Evaluación de Competencias (EC)',
);
?>

<h3 style="text-align: center">Evaluación de Competencias (EC)</h3>

<?php echo CHtml::beginForm($this->createUrl('procesoevaluacion/crearprocesoec'),'post', array('id'=>'formcrearprocesoec'))?>                      
<button  id="btnformcrearprocesoec" type="submit" class="sexybutton sexysimple"><span class="add">Nuevo proceso EC</span></button>
<?php echo CHtml::endForm()?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'procesoevaluacion-grid',
	'dataProvider'=>$ec,
        'template' => '{summary}{pager}<br/>{items}{pager}',
	'filter'=>$filtersForm,    
	'columns'=>array(
                 array(
                     'header'=>'id',
                     'name'=>'id',
                     'visible'=>false,
                 ),
                 array(     
                    'header'=>'Proceso',
                    'name'=>'descripcion',                    
                ),
                array(
                    'header'=>'Periodo',
                    'name'=>'periodo',                     
                ),
                array(
                    'header'=>'Fecha creación',
                    'name'=>'fecha',                     
                ),                
                array(
                    'header'=>'Evaluador',
                    'name'=>'evaluador',                     
                ),
                array(
                    'header'=>'Estado',
                    'name'=>'estado',                     
                ),
                array(
			'class'=>'CButtonColumn',
                        'htmlOptions'=>array('width'=>'90'),
                        'template'=>'{adminprocesoec}{update}{copiar}{delete}',
                        'updateButtonUrl'=>'Yii::app()->controller->createUrl("#", array("id"=>$data["id"]))',
                        'updateButtonLabel' => 'Editar Proceso', 
                        'updateButtonImageUrl'=>Yii::app()->request->baseUrl.'/images/icons/silk/page_edit.png',                         
                        'deleteButtonUrl'=>'Yii::app()->controller->createUrl("#", array("id"=>$data["id"]))',
                        'deleteButtonLabel' => 'Eliminar Proceso', 
                        'deleteButtonImageUrl'=>Yii::app()->request->baseUrl.'/images/icons/silk/decline.png',                          
                        //'deleteConfirmation'=>'js:alert("")',
                        /*'afterDelete'=>'function(link,success,data){ 
                            if(success) {
                                new Messi(data,
                                { title: "Exito.",
                                    titleClass: "success",
                                    autoclose: "4000",
                                    modal:true
                                });
                            }else{
                                new Messi("",
                                { title: "Error",
                                    titleClass: "anim error",
                                    autoclose: "4000",
                                    modal:true
                                });
                            }
                            }',*/
                        'buttons'=>array(                            
                            'adminprocesoec'=> array(
                                'label'=>'Gestionar Proceso EC',
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/icons/silk/door_in.png',
                                'url'=>'Yii::app()->createUrl("procesoevaluacion/adminprocesoec", array("id"=>$data["id"]))'
                            ),
                            'copiar'=> array(
                                'label'=>'Copiar proceso',
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/icons/silk/page_copy.png',                                
                            ),//CLEAN CODE
                            'habilidades'=>array(
                                'label'=>'Ver Evaluaciones Especiales',
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/icons/silk/award_star_gold_3.png',
                                'url'=>'Yii::app()->createUrl("evaluacionpersonas/habilidadesespeciales", array("id"=>$data["id"]))',                               
                                'options'=>array(  
                                    'ajax'=>array(
                                            'type'=>'POST',
                                                // se utiliza el atributo 'url' definido arriba
                                            'url'=>"js:$(this).attr('href')", 
                                            'update'=>'#divhabilidades',
                                           ),
                                 ), //options                               
                            ),//habilidades
//                            'borrar'=>array(
//                                'label'=>'Borrar este proceso.',
//                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/icons/silk/delete.png',
//                                'url'=>'Yii::app()->createUrl("evaluacionpersonas/delete", array("id"=>$data["id"]))',                               
//                                'click'=>'function(){messageconfirmacion();}',                                                               
//                            ),//borrar
                        )//buttons                       
		),
	),//columns
        'htmlOptions' => array("style" => "padding:0"),
)); ?>

<?php
//CLEAN CODE
//the dialog
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
'id'=>'dlghabilidadesespeciales',
'options'=>array(
    'title'=>'Evaluaciones especiales',
    'autoOpen'=>false, //important!
    'modal'=>true,
    'width'=>'auto',
    'height'=>'auto',
    'position' => 'center',
    'draggable' => false,
    'resizable' => false,
),
));
?>
<div id="divhabilidades"></div>
<?php $this->endWidget();?>

 <?php if(Yii::app()->user->hasFlash('success')):?>
     <script type="text/javascript">
          new Messi("",
            { title: "Exito.",
                titleClass: "success",
                autoclose: "4000",
                modal:true
            });
     </script>
     <?php endif;?>

          <?php if(Yii::app()->user->hasFlash('error')):?>
     <script type="text/javascript">
          new Messi("",
            { title: "Error",
                titleClass: "error anim",
                autoclose: "4000",
                modal:true
            });
     </script>
<?php endif;?>