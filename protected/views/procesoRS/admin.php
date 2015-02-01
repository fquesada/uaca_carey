<?php
/* @var $this EvaluacionpersonasController */
/* @var $ec ProcesoEvaluacion */
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/evaluacionpersonas.js');//CLEAN CODE

$this->breadcrumbs=array(	
	'Evaluación de Competencias de Vacantes(ECV)',
);
?>

<?php
function estadoProceso($data) {                               
if ($data["estado"] == "Finalizado") {
return false;
} else {
return true;
}
}
                                
?>

<h3 style="text-align: center">Evaluación de Competencias de Vacantes(ECV)</h3>

<?php echo CHtml::beginForm($this->createUrl('procesors/crearprocesoecv'),'post', array('id'=>'formcrearprocesoec'))?>                      
<button  id="btnformcrearprocesoec" type="submit" class="sexybutton sexysimple"><span class="add">Nuevo proceso ECV</span></button>
<?php echo CHtml::endForm()?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'procesoevaluacion-grid',
	'dataProvider'=>$ecv,
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
                        'template'=>'{adminprocesoec}{editar}{eliminar}',                                                
                       
                        'buttons'=>array(                            
                            'adminprocesoec'=> array(
                                'label'=>'Gestionar Proceso ECV',
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/icons/silk/door_in.png',
                                'url'=>'Yii::app()->createUrl("procesors/adminprocesoecv", array("id"=>$data["id"]))'
                            ),
                            'editar'=> array(
                                'label'=>'Editar Proceso ECV',
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/icons/silk/page_edit.png',
                                'url'=>'Yii::app()->createUrl("procesors/editarprocesoecv", array("id"=>$data["id"]))',
                                'visible'=>'estadoProceso($data)'
                            ),
                            'eliminar'=> array(
                                'label'=>'Eliminar Proceso ECV',
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/icons/silk/decline.png',                                
                                'url'=>'Yii::app()->createUrl("procesors/eliminarprocesoecv", array("id"=>$data["id"]))',
                                'visible'=>'estadoProceso($data)',
                                'click'=>"function(){
                                        event.preventDefault();
                                        var url = $(this).attr('href');
                                        new Messi('¿Desea eliminar este proceso: '+ $(this).parent().parent().children(':nth-child(1)').text() +'?', 
                                        {title: 'Aviso:', buttons: [{id: 0, label: 'Si', val: 'Y'}, {id: 1, label: 'No', val: 'N'}], 
                                        callback: function(val) {                                        
                                        if(val == 'Y'){                                           
                                            $.ajax({
                                                type: 'POST',
                                                url: url,      
                                                dataType: 'json', 
                                                success:function(datos) {                                                
                                                     if(datos.resultado){
                                                        new Messi(datos.mensaje,
                                                            { title: 'Exito',
                                                                titleClass: 'success',
                                                                autoclose: '4000',
                                                                modal:true
                                                            });
                                                        $.fn.yiiGridView.update('procesoevaluacion-grid'); //change my-grid to your grid's name
                                                    }else{
                                                        new Messi(datos.mensaje,
                                                            { title: 'Lo sentimos',
                                                                titleClass: 'error',
                                                                autoclose: '4000',
                                                                modal:true
                                                         });  
                                                         $.fn.yiiGridView.update('procesoevaluacion-grid'); //change my-grid to your grid's name
                                                    }                                                    
                                                }
                                            })                                           
                                         }
                                         
                                        }});                                                                                                      
                                      }",
                                
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