<?php
/* @var $this EvaluacionpersonasController */
/* @var $model Evaluacionpersonas */
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/evaluacionpersonas.js');


$this->breadcrumbs=array(	
	'Gestión de evaluación de competencias',
);
?>



<h3 style="text-align: center">Gestión de evaluación de competencias</h3>

<?php echo CHtml::beginForm($this->createUrl('evaluacionpersonas/crear'),'post', array('id'=>'formcrearevaluacionpersona'))?>                      
<button  id="btnformcrearevaluacionpersona" type="submit" class="sexybutton sexysimple"><span class="add">Crear proceso evaluación</span></button>
<?php echo CHtml::endForm()?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'evaluacionpersonas-grid',
	'dataProvider'=>$model,
        'template' => '{summary}{pager}<br/>{items}{pager}',
	'filter'=>$filtersForm,    
	'columns'=>array(
                 array(
                     'header'=>'Nombre proceso',
                     'name'=>'id',
                     'visible'=>false,
                 ),
                 array(     
                    'header'=>'Nombre proceso',
                    'name'=>'descripcion',                    
                ),
                array(
                    'header'=>'Puesto',
                    'name'=>'puesto',                     
                ),
                array(
                    'header'=>'Creador',
                    'name'=>'creador',                     
                ),
                array(
                    'header'=>'Fecha creación',
                    'name'=>'fecha',                     
                ),
//                array(
//                    'header'=>'Estado',
//                    'name'=>'estado',                     
//                ),
                array(
			'class'=>'CButtonColumn',
                        'htmlOptions'=>array('width'=>'90'),
                        'template'=>'{agregarpersonas}{habilidades}',
                        'deleteButtonUrl'=>'Yii::app()->controller->createUrl("evaluacionpersonas/borrar", array("id"=>$data["id"]))',
                        'deleteButtonLabel' => 'Eliminar este proceso.', 
                        'deleteButtonImageUrl'=>Yii::app()->request->baseUrl.'/images/icons/silk/delete.png',                          
                        'deleteConfirmation'=>'js:alert("hola")',
                        'afterDelete'=>'function(link,success,data){ 
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
                            }',
                        'buttons'=>array(
                            'agregarpersonas'=>array(
                                'label'=>'Gestión de personas en el proceso',
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/icons/silk/group_add.png',
                                'url'=>'Yii::app()->createUrl("evaluacionpersonas/agregarpersonas", array("id"=>$data["id"]))'
                                
                            ),
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