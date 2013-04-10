<?php
/* @var $this CompetenciaController */
/* @var $model Competencia */

$this->breadcrumbs=array(
	'Gestionar',
);

$this->menu=array(
	array('label'=>'Crear Competencia', 'url'=>array('create')),
);

?>

<h1>Gestionar Competencia</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'competencia-grid',
	'dataProvider'=>$model->search(),
        'filter'=>$model,
        'template' => "{summary}{pager}<br/>{items}{pager}",
	'columns'=>array(
		'competencia',
		'descripcion',
		'pregunta',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
