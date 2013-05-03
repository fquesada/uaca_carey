<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/sexybuttons.css');
?>
<?php
$this->breadcrumbs=array(
	'Gestionar'=>array('//colaborador/admin'),
	'Actualizar'=>array('//colaborador/update'),
        'Cambiar puesto'
);
?>

<h1>Puesto actual</h1>

<?php
 $this->widget('zii.widgets.CDetailView', array(
	'data'=>$actual,
	'attributes'=>array(
		'fechadesignacion',
		'nombreunidadnegocio',
		'nombrepuesto',
	),
));
?>
<br></br>
<br></br>

<h1>Puesto nuevo</h1>

<?php echo $this->renderPartial('_cambiarpuesto', array('model'=>$model)); ?>

