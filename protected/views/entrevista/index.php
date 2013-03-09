<?php
/* @var $this EntrevistaController */

$this->breadcrumbs=array(
	'Entrevista',
);
?>

<?php
 Yii::app()->clientScript->registerCoreScript('jquery');
 Yii::app()->clientScript->registerCoreScript('jquery.ui');

?>
<h1>Entrevista</h1>

<div class="form">
<?php echo CHtml::beginForm(); ?>
     
 
    <div class="row">
        <?php echo CHtml::label('Puesto', 'puesto') ?>
        <?php echo CHtml::dropDownList('puesto','puesto', CHtml::listData(Puesto::model()->findAll(array('order'=>'nombre','condition'=>'estado=:estado', 'params'=>array(':estado'=>1))),'id', 'nombre'),array('empty' => 'Selecione un periodo')); ?>
    </div>          
 
    <div class="row submit">
        <?php echo CHtml::Button('Generar',  array(        
        'onclick'=>"cargarEntrevista();",
            'class'=>'sexybutton sexysimple')); ?>
    </div>
    
 
<?php echo CHtml::endForm(); ?>
        
</div>

<script type="text/javascript">
// here is the magic
 
      
            function cargarEntrevista() {                
                var puesto = $('#puesto').val();  
                var url = $(location).attr('href');
                
                if(url.charAt( url.length-1 ) != "/") {
                    url = url + "/";
                }
                
                var page = url+"pdf/"+puesto; 
                var wWidth = $(window).width();
                var dWidth = wWidth * 0.9;
                var wHeight = $(window).height();
                var dHeight = wHeight * 0.9;
                var pagetitle = 'Entrevista Conductual Estructurada'
                var $dialog = $('<div></div>')
                .html('<iframe style="border: 0px; " src="' + page + '" width="100%" height="100%"></iframe>')
                .dialog({
                    autoOpen: false,
                    modal: true,
                    height: dHeight,
                    width: dWidth,
                    title: pagetitle
                });
                $dialog.dialog('open');
            }        
                         
 
</script>