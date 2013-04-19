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
                         'header'=>'usuario',
                         'name'=>'usuario',
                         'visible'=>false,
                     ),
                array(
                    'header'=>'Colaborador',
                    'name'=>'colaborador',                     
                ),
                array(
                    'header'=>'Login',
                    'name'=>'login',                     
                ),
            array(
			'class'=>'CButtonColumn',
                        'htmlOptions'=>array('width'=>'90'),
                        'template'=>'{actualizar}{contraseña}{borrar}',
                        'buttons'=>array(
                            'actualizar'=>array(
                                'label'=>'Actualizar',
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/icons/silk/user_edit.png',
                                'url'=>'Yii::app()->createUrl("usuario/update", array("id"=>$data["usuario"]))'
                                
                            ),
                            'contraseña'=>array(
                                'label'=>'Reestablecer constraseña',
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/icons/silk/vcard_key.png',
                                'url'=>'Yii::app()->createUrl("usuario/RestablecerPass", array("id"=>$data["usuario"]))',                                                              
                            ),//habilidades
                            'borrar'=>array(
                                'label'=>'Eliminar este usuario',
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/icons/silk/delete.png',
                                'url'=>'Yii::app()->createUrl("usuario/delete", array("id"=>$data["usuario"]))',                               
                                'confirm'=>'Seguro que desea borrar este elemento?',                                                               
                            ),//borrar
                        )//buttons                       
		),
	),//columns
        'htmlOptions' => array("style" => "padding:0"),
)); ?>

