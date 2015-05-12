<?php
/* @var $this EvaluacionpersonasController */
/* @var $ec ProcesoEvaluacion */
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/evaluacionpersonas.js');//CLEAN CODE

$this->breadcrumbs=array(	
	'Evaluación de Competencias (EC)',
);
?>

<h3 style="text-align: center">Procesos de evaluación de competencias (EC)</h3>

<?php
function estadoProceso($data) {                               
if ($data["estado"] == "Finalizado") {
return false;
} else {
return true;
}
}
                                
?>

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
                        'template'=>'{adminprocesoec}{editar}{eliminar}',   
                        'buttons'=>array(                            
                            'adminprocesoec'=> array(
                                'label'=>'Gestionar Proceso EC',
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/icons/silk/door_in.png',
                                'url'=>'Yii::app()->createUrl("procesoevaluacion/adminprocesoec", array("id"=>$data["id"]))'
                            ),
                            'editar'=> array(
                                'label'=>'Editar Proceso EC',
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/icons/silk/page_edit.png',
                                'url'=>'Yii::app()->createUrl("procesoevaluacion/editarprocesoec", array("id"=>$data["id"]))',
                                'visible'=>'estadoProceso($data)'
                            ),
                            'eliminar'=> array(
                                'label'=>'Eliminar Proceso EC',
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/icons/silk/decline.png',                                
                                'url'=>'Yii::app()->createUrl("procesoevaluacion/eliminarprocesoec", array("id"=>$data["id"]))',
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
                        )//buttons                       
		),
	),//columns
        'htmlOptions' => array("style" => "padding:0"),
)); ?>
