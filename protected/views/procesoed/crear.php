<?php
/* @var $this ProcesoedController */
/* @var $model evaluaciondesempeno */

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
    'ED' => array('admin'),
    'Nuevo proceso ED',
);
$this->menu = array(
    array('label' => 'Lista de Procesos ED', 'url' => array('admin')),
);
?>

<h3 style="text-align: center"><?php echo "Nuevo proceso de evaluación de desempeño (ED)"; ?></h3>
</br>

<?php
echo CHtml::button('Volver atrás', array('id' => 'btnvolveratras', 'submit' => array('procesoed/admin'), 'class' => 'sexybutton sexysimple sexylarge'));
?>

<?php echo CHtml::beginForm() ?>

<?php
echo $this->renderPartial('_formprocesocrear');
?>



<div class="row buttons" style="text-align: center">  
    <?php
    echo CHtml::submitButton('Crear proceso ED', array('id' => 'btncrearprocesoed', 'class' => 'sexybutton sexysimple sexylarge'));
    echo '</br>';
    echo '</br>';
    echo CHtml::button('Volver atrás', array('id' => 'btnvolveratras', 'submit' => array('procesoed/admin'), 'class' => 'sexybutton sexysimple sexylarge'));
    ?>
</div>
<?php
echo CHtml::endForm()?>