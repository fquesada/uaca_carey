<?php
/* @var $this ColaboradorController */
/* @var $model Colaborador */
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
        'Gestionar puesto'
    );
    ?>
    <h1>Puesto Actual</h1>
    
    <?php $this->widget('zii.widgets.CDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                    'nombreunidadnegocioactual',
                    'nombrepuestoactual',		
            ),
    )); ?>

    <h1>Nuevo Puesto</h1>
    
    <?php
    $unidadnegocio = new Unidadnegocio();
    $puesto = new Puesto();
    ?>

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

    

    