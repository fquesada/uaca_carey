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

    <p></br> </br> </br> </p>
    <?php
    echo CHtml::button('Volver atrás', array('id'=>'btnvolveratras','submit' => array('puesto/admin/'), 'class'=>'sexybutton sexysimple sexylarge'));
    ?>
        
    <p></br> </br> </br> </p>
    
    <h1>Puesto</h1>
    
    <?php $this->widget('zii.widgets.CDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                    'codigo',
                    'nombre'		
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
                ),
                array(
                    'name'=>'tipocompetencia',
                    'header'=>'Tipo de competencia'
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
        
    <?php echo CHtml::submitButton('Asociar',array('submit'=>'../puesto/savecompetencia', 'class'=>'sexybutton sexysimple sexylarge'));?>

     <?php echo CHtml::endForm()?>
    
         <p></br> </br> </br> </p>
     <h1>Paso 3: Competencias asociadas</h1>
     <h5>Verifique que la competencia haya sido asociada correctamente. </h5>
     <span class="required">Por favor asegúrese que tenga 7 ó 8 competencias (4 CORE y 3 ó 4 específicas).</span>
     
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
     
     <p></br> </br> </br> </p>
     <h1>Paso 4: Repita el proceso</h1>
     <h5>Repita el proceso cuantas veces sean necesarias para asociar la totalidad de las competencias.</h5>
     <span class="required">Por favor asegúrese que tenga 7 ó 8 competencias (4 CORE y 3 ó 4 específicas).</span>
     
    <p></br> </br> </br> </p>
    <?php
    echo CHtml::button('Volver atrás', array('id'=>'btnvolveratras','submit' => array('puesto/admin/'), 'class'=>'sexybutton sexysimple sexylarge'));
    ?>
    <p></br> </br> </br> </p>

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