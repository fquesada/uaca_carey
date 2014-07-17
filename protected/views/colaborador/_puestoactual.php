<?php
/* @var $model Colaborador*/
?>

<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/sexybuttons.css');
?>

<div class="form">
    
        <?php 
          $this->widget('zii.widgets.CDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                    'nombreunidadnegocioactual',
                    'nombrepuestoactual',		
            ),
          )); 
          
       ?>

</div><!-- form -->