<?php

class PuestocompetenciaController extends Controller
{
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
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
        
    
        public function actionDelete($competencia, $puesto)
	{
		$this->loadModel($competencia, $puesto)->delete();
                //$this->redirect(array('puesto/addcompetence','id'=>Yii::app()->session['puesto']));
                //$this->redirect(array('../puesto/addcompetence'));

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			//$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                        //$this->redirect($_POST['returnUrl']);
                        $this->redirect(array('puesto/addcompetence','id'=>Yii::app()->session['puesto']));
                    
                        
	}

        	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
        public function loadModel($competencia, $puesto)
	{
		$models=  Puestocompetencia::model()->findAllByAttributes(array('competencia'=>$competencia, 'puesto'=>$puesto));
		foreach ($models as $actual){
                    $model = $actual;
                }
                
                if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        
        
}