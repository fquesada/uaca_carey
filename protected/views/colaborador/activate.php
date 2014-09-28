<?php
/* @var $this ColaboradorController */
/* @var $model Colaborador */

$this->breadcrumbs=array(
	'Gestionar'=>array('index'), 
        'Reactivar',
);

$this->menu=array(
        array('label'=>'Gestionar Colaborador', 'url'=>array('admin'))
);

?>

<h1>Reactivar Colaborador</h1>

<p>
Puede ingresar opcionalmente un operador comparativo (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>,
 <b>=</b>) al inicio de cada valor de búsqueda para especificar cómo se debe realizar la comparación.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'colaboradorreintegro-grid',
	'dataProvider'=>$model->search(FALSE),
	'filter'=>$model,
        'template'=>"{pager}{items}{pager}{summary}",
	'columns'=>array(
		'cedula',
		'nombre',
		'apellido1',
		'apellido2',
                'nombreunidadnegocioactual',
                'nombrepuestoactual',
		array(
			'class'=>'CButtonColumn',
                        'htmlOptions'=>array('width'=>'90'),
                        'template'=>'{activar}',
                        'buttons'=>array(
                            'activar'=>array(
                                'label'=>'Reingresar colaborador',
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/icons/silk/page_white_refresh.png',
                                'url'=>'Yii::app()->createUrl("colaborador/reintegrar", array("id"=>$data->id))'
                                
                            )                          
                        )
		),
	),
)); ?>

<br></br>
<br></br>

<?php
echo CHtml::button('Volver atrás', array('id'=>'btnvolveratras','submit' => array('colaborador/admin/'), 'class'=>'sexybutton sexysimple sexylarge'));
?>
