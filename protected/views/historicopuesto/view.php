<?php
/* @var $this HistoricopuestoController */
/* @var $model Historicopuesto */

?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'fechadesignacion',
		'nombreunidadnegocio',
		'nombrepuesto',
	),
)); ?>
