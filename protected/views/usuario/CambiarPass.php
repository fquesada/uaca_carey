<?php
/* @var $this UsuarioController */
/* @var $model Usuario */

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	'Cambiar Contraseña',
);

$this->menu=array(
	array('label'=>'Gestionar Usuarios', 'url'=>array('admin')),
);
?>

<h1>Cambiar Contraseña</h1>

<?php echo $this->renderPartial('_form3', array('model'=>$model)); ?>