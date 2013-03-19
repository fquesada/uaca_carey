<?php
/* @var $this EvaluacionpersonasController */
/* @var $model Evaluacionpersonas */

$this->breadcrumbs=array(
	'Evaluacionpersonases'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Evaluacionpersonas', 'url'=>array('index')),
	array('label'=>'Create Evaluacionpersonas', 'url'=>array('create')),
);

?>



<h3>Procesos de evaluacion</h3>

<?php echo CHtml::beginForm($this->createUrl('evaluacionpersonas/crear'),'post', array('id'=>'formcrearevaluacionpersona'))?>                      
<button  id="btncrearevaluacionpersona" type="submit" class="sexybutton sexysimple sexylarge"><span class="add">Crear proceso evaluación</span></button>
<?php echo CHtml::endForm()?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'evaluacionpersonas-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
                 array(     
                    'header'=>'Nombre proceso',
                    'name'=>'descripcion',                    
                ),
                array(
                    'header'=>'Puesto',
                    'name'=>'puesto', 
                    'value'=>'$data->_puesto->nombre',
                ),
                array(
                    'header'=>'Creador',
                    'name'=>'creador', 
                    'value'=>'$data->_creador->nombre',
                ),
                array(
                    'header'=>'Fecha',
                    'name'=>'fecha', 
                    'value'=>'$this->grid->owner->gridmysqltophpdate($data->fecha)',
                ),
                array(
                    'header'=>'Estado',
                    'name'=>'estado', 
                    'value'=>'$this->grid->owner->gridestado($data->estado)',
                ),
	),
)); ?>
