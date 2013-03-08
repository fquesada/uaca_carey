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

<button  id="btnnuevocompromiso" type="submit" class="sexybutton sexysimple sexylarge"><span class="add">Nuevo proceso evaluacion</span></button>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'evaluacionpersonas-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'fecha',
		'creador',
		'estado',
		'puesto',
		'descripcion',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
