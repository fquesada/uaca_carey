<?php
/* @var $this EvaluacionpersonasController */
/* @var $model Evaluacionpersonas */

$this->breadcrumbs=array(
	'Evaluacionpersonases'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Evaluacionpersonas', 'url'=>array('index')),
	array('label'=>'Create Evaluacionpersonas', 'url'=>array('create')),
);

?>



<h3>Procesos de evaluacion</h3>

<?php echo CHtml::beginForm($this->createUrl('evaluacionpersonas/crear'),'post', array('id'=>'formcrearevaluacionpersona'))?>                      
<button  id="btncrearevaluacionpersona" type="submit" class="sexybutton sexysimple sexylarge"><span class="add">Crear proceso evaluación</span></button>
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
                                'url'=>'Yii::app()->createUrl("evaluacionpersonas/habilidadesespeciales", array("id"=>$data["id"]))'
                                
                            ),                                                        
                        )
                       
		),
	),
)); ?>
