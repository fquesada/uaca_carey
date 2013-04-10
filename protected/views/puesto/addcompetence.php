<?php
/* @var $this PuestoController */
/* @var $model Puesto */
/* @var $form CActiveForm */
?>

<?php
    //CSS
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/messi.min.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/sexybuttons.css');
    
    //JS
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/messi.min.js');
?>

    <?php
    $this->breadcrumbs=array(
	'Gestionar'=>array('admin'),
        'Agregar competencias'
    );
    ?>
    <h1>Puesto</h1>
    
    <?php $this->widget('zii.widgets.CDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                    'codigo',
                    'nombre',
                    'descripcion'		
            ),
    )); ?>
    
    <?php Yii::app()->session['puesto']=$model->id;?>
    
    <?php 
    $competencia = new Competencia();
    $ponderacion = new Ponderacion();
    
    $filterForm = new FiltersForm();
    ?>
    
    <p></br> </br> </br> </p>
   
 <h1>Paso 1: Competencias disponibles</h1>
 <h5>Seleccione una de las competencias, enumeradas a continuación, que desea agregarle al puesto.</h5>
 
 <?php echo CHtml::beginForm('','POST',array('id'=>'formpeso', 'onkeypress'=>'return event.keyCode != 13;'))?> 
 
 <?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'competenciaexistente-grid',
        'dataProvider'=>$competencia->addcompetencia($model->id),
        'template'=>"{pager}\n{items}\n{pager}\n{summary}",
        'filter'=>$filterForm,
	'columns'=>array(
                array(
                    'id' => 'compselect',
                    'class' => 'CCheckBoxColumn',
                ),
                array(
                    'name'=>'competencia',
                    'header'=>'Competencia'
                ),
                array(
                    'name'=>'descripcion',
                    'header'=>'Descripción'
                )
	),
    )); ?>
 
    <h1>Paso 2: Peso de la competencia</h1>
    <h5>Elija el peso que desea agregarle a la competencia anteriormente seleccionado y presione el botón "Asociar".</h5>

     <?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'peso-grid',
        'dataProvider'=>$ponderacion->search(),
        'template'=>"{pager}\n{items}\n{pager}\n{summary}",
	'columns'=>array(
                array(
                    'id' => 'peso',
                    'class' => 'CCheckBoxColumn',
                ),
		'valor',
		'descripcion',
	),
    )); ?> 
    
    <br></br>
        
    <?php echo CHtml::submitButton('Asociar',array('submit'=>'../savecompetencia', 'class'=>'sexybutton sexysimple sexylarge'));?>

     <?php echo CHtml::endForm()?>
    
         <p></br> </br> </br> </p>
     <h1>Paso 3: Competencias asociadas</h1>
     <h5>Verifique que la competencia haya sido asociada correctamente</h5>
     
     
    <?php 
    $puestocomp = new Puestocompetencia();
    ?>
    
    <?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'competenciaasociado-grid',
        'dataProvider'=>$puestocomp->search($model->id),
	'template'=>"{pager}\n{items}\n{pager}\n{summary}",
        'columns'=>array(
                    'NombreCompetencia',
                    'ponderacion',
                    array(
                            'class'=>'CButtonColumn',
                            'htmlOptions'=>array('width'=>'20'),
                            'template'=>'{delete}',
                            'buttons'=>array(
                                'delete'=>array(
                                    'url'=>'Yii::app()->createUrl("puestocompetencia/delete", array("competencia"=>$data->competencia, "puesto"=>$data->puesto))',
                                )
                            )
                    ),
	),
        'afterAjaxUpdate'=>'js:function(id,data){$.fn.yiiGridView.update("competenciaexistente-grid");}'
    )); ?>

     <?php if(Yii::app()->user->hasFlash('success')):?>
     <script type="text/javascript">
          new Messi('<?php echo Yii::app()->user->getFlash('success'); ?>',
            { title: 'Éxito.',
                titleClass: 'success',
                autoclose: '4000',
                modal:true
            });
     </script>
     <?php endif;?>

          <?php if(Yii::app()->user->hasFlash('error')):?>
     <script type="text/javascript">
          new Messi('<?php echo Yii::app()->user->getFlash('error'); ?>',
            { title: 'Error',
                titleClass: 'error',
                autoclose: '4000',
                modal:true
            });
     </script>
     <?php endif;?>