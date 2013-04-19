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

<h1>Restablecer Contraseña</h1>

<?php echo $this->renderPartial('_form4', array('model'=>$model)); ?>