<?php
/* @var $model Colaborador 
 * @var $historico Historicopuesto
 * @var $indicador Boolean
 * @var $ingresos Int
 */

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

     
    <br></br>
    
    <?php
    echo CHtml::button('Volver atrás', array('id'=>'btnvolveratras','submit' => array('colaborador/admin/'), 'class'=>'sexybutton sexysimple sexylarge'));
    ?>
    
    <br></br>
    <br></br>
    
    <h1>Colaborador</h1>
    <?php
        $this->widget('zii.widgets.CDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                    'nombrecompleto',		
            ),
          )); 
    ?>
    
    <br></br>
    
    <h1>Puesto Actual</h1>
    
    <?php
    
    //Verifica si el colaborador cuenta un puesto ya asignado.
    if($indicador){
        echo $this->renderPartial('_puestoactual', array('model'=>$model)); 
    }
    else
        echo 'El colaborador no cuenta con un puesto asignado. Complete el siguiente formulario para asignarle un puesto al colaborador en cuestión';
        
    ?>
       

    <br></br>
    <br></br>
    
    <h2>Seleccione el nuevo puesto</h2>
    <?php echo $this->renderPartial('_formpuestonuevo', array('model'=>$historico, 'colaborador'=>$model, 'indicador'=>$indicador, 'ingresos'=>$ingresos)); ?>
    
    
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
    