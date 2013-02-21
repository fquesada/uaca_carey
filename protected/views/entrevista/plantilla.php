<?php
/* @var $this EntrevistaController */
/* @var $model Entrevista */

$this->breadcrumbs=array(
	'Entrevistas'=>array('index'),
	$model->id,
);

?>

<h1>Entrevista #<?php echo $model->id; ?></h1>

<h5>Puesto:</h5>
<?php $puesto = Puesto::model()->findByPk($model->_vacante->periodo);
    echo $puesto->nombre;
?>
<h5>Entrevistado:</h5>
<?php $entrevistado = $model->obtenerNombreEntrevistado();
    echo $entrevistado;
?>
