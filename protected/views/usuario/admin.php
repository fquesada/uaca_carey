<?php
/* @var $this UsuarioController */
/* @var $model Usuario */

$this->breadcrumbs=array(
	'Gestionar',
);

$this->menu=array(
	array('label'=>'Crear Usuario', 'url'=>array('create')),
);

?>

<h1>Gestionar Usuario</h1>

<p>
Puede ingresar opcionalmente un operador comparativo (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>,
 <b>=</b>) al inicio de cada valor de búsqueda para especificar cómo se debe realizar la comparación.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'usuarios-grid',
	'dataProvider'=>$model,
	'template'=>"{pager}\n{items}\n{pager}\n{summary}",
        'filter'=>$filtersForm, 
	'columns'=>array(
                array(
                         'header'=>'id',
                         'name'=>'usuario',
                         'visible'=>false,
                     ),
                array(
                    'header'=>'Colaborador',
                    'name'=>'colaborador',                     
                ),            
		array(
			'class'=>'CButtonColumn',
                        ),
            ),
)); ?>
