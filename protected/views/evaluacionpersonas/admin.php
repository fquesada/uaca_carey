<?php
/* @var $this EvaluacionpersonasController */
/* @var $model Evaluacionpersonas */

$this->breadcrumbs=array(	
	'Gestión de evaluación de competencias',
);
?>



<h3 style="text-align: center">Gestión de evaluación de competencias</h3>

<?php echo CHtml::beginForm($this->createUrl('evaluacionpersonas/crear'),'post', array('id'=>'formcrearevaluacionpersona'))?>                      
<button  id="btncrearevaluacionpersona" type="submit" class="sexybutton sexysimple"><span class="add">Crear proceso evaluación</span></button>
<?php echo CHtml::endForm()?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'evaluacionpersonas-grid',
	'dataProvider'=>$model,
	'filter'=>$filtersForm,    
	'columns'=>array(
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
                    'header'=>'Fecha',
                    'name'=>'fecha',                     
                ),
                array(
                    'header'=>'Estado',
                    'name'=>'estado',                     
                ),
                array(
			'class'=>'CButtonColumn',
                        'htmlOptions'=>array('width'=>'90'),
                        'template'=>'{agregarpersonas}{habilidades}',
                        'buttons'=>array(
                            'agregarpersonas'=>array(
                                'label'=>'Agregar personas al proceso',
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/icons/silk/group_add.png',
                                'url'=>'Yii::app()->createUrl("evaluacionpersonas/agregarpersonas", array("id"=>$data["id"]))'
                                
                            ),
                            'habilidades'=>array(
                                'label'=>'Ver/Editar Habilidades Especiales',
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/icons/silk/award_star_gold_3.png',
                                'url'=>'Yii::app()->createUrl("evaluacionpersonas/habilidadesespeciales", array("id"=>$data["id"], "dialog"=>true))',
                                'options'=>array(  
                                    'ajax'=>array(
                                            'type'=>'POST',
                                                // ajax post will use 'url' specified above 
                                            'url'=>"js:$(this).attr('href')", 
                                            'update'=>'#id_view',
                                           ),
                                 ), //options                               
                            ),//habilidades
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
    'title'=>'Habilidades especiales',
    'autoOpen'=>false, //important!
    'modal'=>false,
    'width'=>550,
    'height'=>470,
),
));
?>
<div id="id_view"></div>
<?php $this->endWidget();?>