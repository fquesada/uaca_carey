<?php
/* @var $this UsuarioController */
/* @var $model Usuario */

$this->breadcrumbs=array(
	'Usuarios'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
        array('label'=>'Cambiar Password', 'url'=>array('CambiarPass', 'id'=>$model->id)),
	array('label'=>'Gestionar Usuarios', 'url'=>array('admin')),
);
?>

<h1>Modificar Usuario <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form2', array('model'=>$model)); ?>