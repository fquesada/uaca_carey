<?php
/* @var $this EvaluacionpersonasController */
/* @var $model Evaluacionpersonas */

$this->breadcrumbs=array(
	'Evaluacion'=>array('admin'),
	'Crear',
);
?>

<h3>Crear proceso evaluacion</h3>

<?php echo $this->renderPartial('_formevaluacionpersona', array('model'=>$model)); ?>
