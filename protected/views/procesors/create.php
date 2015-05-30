<?php
/* @var $this EvaluacionpersonasController */
/* @var $model Evaluacionpersonas */

$this->breadcrumbs=array(
	'Evaluacionpersonases'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Evaluacionpersonas', 'url'=>array('index')),
	array('label'=>'Manage Evaluacionpersonas', 'url'=>array('admin')),
);
?>

<h1>Create Evaluacionpersonas</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>