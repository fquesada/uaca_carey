<?php

class HistoricopuestoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
    
        public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('elegirpuesto'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
        
       public function actionobtenerpuestos(){
            $idun = $_POST['Historicopuesto']['unidadnegocio'];                                    
            $listaunidadnegocio = Unidadnegociopuesto::model()->findAllByAttributes(array('unidadnegocio'=>$idun));
            
            $listaunidadnegocio = CHtml::listData($listaunidadnegocio, 'puesto', 'nombrepuesto'); 
            
            foreach ($listaunidadnegocio as $id => $nombrepuesto){                
                echo CHtml::tag('option', array('value'=>$id), CHtml::encode($nombrepuesto), true);
            }
            
        }
    
}