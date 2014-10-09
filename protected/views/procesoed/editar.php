<?php
/* @var $this ProcesoedController */
/* @var $proceso ProcesoEvaluacion tipo ED */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/messi.min.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/messi.min.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/procesoed.js');

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/procesoed.css');
Yii::app()->clientScript->registerScript('autocomplete', '
  $["ui"]["autocomplete"].prototype["_renderItem"] = function( ul, item) {
                return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( $( "<a></a>" ).html( item.label ) )
                .appendTo( ul );
            };
  
', CClientScript::POS_READY
);
$this->breadcrumbs = array(
    'EC' => array('admin'),
    'Editar proceso ED',
);
$this->menu = array(
    array('label' => 'Lista de Procesos ED', 'url' => array('admin')),
    array('label' => 'Crear Proceso ED', 'url' => array('crear')),
);
?>

<h3 style="text-align: center"><?php echo "Editar proceso ED #" . $proceso->id; ?></h3>
</br>

<?php
echo CHtml::button('Volver atrás', array('id' => 'btnvolveratras', 'submit' => array('procesoed/adminprocesoed/' . $proceso->id), 'class' => 'sexybutton sexysimple sexylarge'));
?>

<?php echo CHtml::beginForm() ?>

<?php
echo $this->renderPartial('_formprocesoeditar', array('proceso' => $proceso));
echo CHtml::hiddenField('idproceso', $proceso->id, array('id' => 'idprocesoed', 'name' => 'idprocesoed'));
echo CHtml::hiddenField('indicadoreditar', "true", array('id' => 'indicadoreditar', 'name' => 'indicadoreditar')); //Es lo utiliza el JS procesoed para cargar la imagen de delete.png en la tabla de colaboradores en el click de #btnagregarcolaborador
?>



<div class="row buttons" style="text-align: center">  
<?php
echo CHtml::submitButton('Guardar proceso ED', array('id' => 'btnguardarprocesoed', 'class' => 'sexybutton sexysimple sexylarge'));
echo '</br>';
echo '</br>';
echo CHtml::button('Volver atrás', array('id' => 'btnvolveratras', 'submit' => array('procesoed/adminprocesoed/' . $proceso->id), 'class' => 'sexybutton sexysimple sexylarge'));
?>
</div>
    <?php
    echo CHtml::endForm()?>