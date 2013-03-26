<?php
/* @var $this UsuarioController */
/* @var $model Usuario */


Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/messi.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/usuario.js');

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Gestionar Usuarios', 'url'=>array('admin')),
);
?>

<h1>Crear Usuario</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>