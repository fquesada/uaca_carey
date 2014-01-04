<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/home.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/administracion.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/sexybuttons.css" />
         <?php
        Yii::app()->clientScript->registerCoreScript('jquery');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/messi.min.js');
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/messi.min.css');
        ?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
                <div id="opciones">
                    <div class="acciones">
                        <a href='http://localhost/uaca_carey/index.php/site/administracion'><img title="Administración" src=<?php echo Yii::app()->baseUrl."/images/tools.png" ?>></a>
                    </div>
                    <div class="acciones">
                        <a href='http://localhost/uaca_carey/index.php'><img title="Inicio" src=<?php echo Yii::app()->baseUrl."/images/home.png" ?>></a>
                    </div>
                    <div class="acciones">
                        <a href='http://localhost/uaca_carey/index.php/site/logout'><img title="Salir" src=<?php echo Yii::app()->baseUrl."/images/logout.png" ?>></a>
                    </div>
                    <div id="bienvenida"><?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
                                array('label'=>Yii::app()->user->name.'', 'visible'=>!Yii::app()->user->isGuest),
			),
		)); ?>
                </div>
                </div>
	</div><!-- header -->

	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?><br/>
		All Rights Reserved.<br/>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
