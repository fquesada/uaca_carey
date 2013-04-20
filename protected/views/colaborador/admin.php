<?php
/* @var $this ColaboradorController */
/* @var $model Colaborador */

$this->breadcrumbs=array(
	'Gestionar',
);

$this->menu=array(
	array('label'=>'Crear Colaborador', 'url'=>array('create')),
);

?>

<h1>Gestionar Colaborador</h1>

<p>
Puede ingresar opcionalmente un operador comparativo (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>,
 <b>=</b>) al inicio de cada valor de búsqueda para especificar cómo se debe realizar la comparación.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'colaborador-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'template'=>"{pager}{items}{pager}{summary}",
	'columns'=>array(
		'cedula',
		'nombre',
		'apellido1',
		'apellido2',
                 array(
			'class'=>'CButtonColumn',
                        'template'=>'{update}{delete}{puesto}',
                        'buttons'=>array(
                            'puesto'=>array(
                                'label'=>'Ver puesto',
                                'imageUrl'=>Yii::app()->request->baseUrl.'/images/icons/silk/table_gear.png',
                                'url'=> 'Yii::app()->createUrl("historicopuesto/view", array("id"=>$data->id))',
                                'options'=>array(
                                    'ajax'=> array (
                                        'type'=>'POST',
                                        'url'=>"js:$(this).attr('href')",
                                        'update'=>'#div_verpuesto',
                                    ),
                                ),
                            ),
		),
	),
))); ?>

    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'=>'dialogPuestodecolaborador',
        'options'=>array(
            'title'=>'Puesto Actual',
            'autoOpen'=>false,
            'modal'=>false,
            'width'=>500,
            'height'=>200,
        ),        
    ));
    ?>

    <div id="div_verpuesto"></div>
    
    <?php $this->endWidget();?>


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
