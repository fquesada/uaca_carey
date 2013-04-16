<?php
/* @var $this ColaboradorController */
/* @var $model Colaborador */

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/sexybuttons.css');

$this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
	'Ver',
);



$this->menu=array(
	array('label'=>'Crear Colaborador', 'url'=>array('create')),
	array('label'=>'Actualizar Colaborador', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Colaborador', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Seguro que desea borrar este elemento?')),
	array('label'=>'Gestionar Colaborador', 'url'=>array('admin')),
);
?>

<h1>Ver Colaborador</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'cedula',
		'nombre',
		'apellido1',
		'apellido2',
	),
)); ?>

<?php if(Yii::app()->user->hasFlash('success')):?>
     <script type="text/javascript">
          new Messi('<?php echo Yii::app()->user->getFlash('success'); ?>',
            { title: 'Éxito.',
                titleClass: 'success',
                autoclose: '3000',
                modal:true
            });
     </script>
     <?php endif;?>

          <?php if(Yii::app()->user->hasFlash('error')):?>
     <script type="text/javascript">
          new Messi('<?php echo Yii::app()->user->getFlash('error'); ?>',
            { title: 'Error',
                titleClass: 'error',
                autoclose: '3000',
                modal:true
            });
     </script>
     <?php endif;?>
