<?php

class EvaluacionpersonasController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('crear','update','admin'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Evaluacionpersonas;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Evaluacionpersonas']))
		{
			$model->attributes=$_POST['Evaluacionpersonas'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
        
        public function actionCrear(){            
                        
            if(Yii::app()->request->isAjaxRequest)
            {                
                $nombreproceso = $_POST['proceso'];
                $puesto = CommonFunctions::stringtonumber($_POST['puesto']);
                
                $evaluacionpersona = new Evaluacionpersonas();
                
                $evaluacionpersona->descripcion = $nombreproceso;
                $evaluacionpersona->puesto = $puesto; 
                $evaluacionpersona->fecha = CommonFunctions::datenow();
                
                $usuario = Usuario::model()->findByPk(Yii::app()->user->id);              
                $colaborador = $usuario->getcolaborador();
                $evaluacionpersona->creador = $colaborador->id;
                
                $transaction = Yii::app()->db->beginTransaction();
                
                $saveresult = $evaluacionpersona->save();
                
                               
                if($saveresult){
                    if(isset($_POST['habilidades'])){
                        foreach ($_POST['habilidades'] as $nombre => $descripcion) {
                            $habilidadesespecial = new Habilidadespecial();
                            $habilidadesespecial->nombre = $nombre;
                            $habilidadesespecial->descripcion = $descripcion;
                            $habilidadesespecial->evaluacionpersonas = $evaluacionpersona->id;
                            $saveresult = $habilidadesespecial->save();                      
                        }
                    }
                    if($saveresult){                    
                       $transaction->commit();
                       $response = array('r' => true,'v' => "Se guardó con éxito el proceso: ".$evaluacionpersona->descripcion);
                       echo CJSON::encode($response);                        
                    }else{
                        $transaction->rollback();
                        $response = array('r' => false,'v' => "Ha ocurrido un inconveniente al intentar guardar el proceso: ".$evaluacionpersona->descripcion); 
                        echo CJSON::encode($response);                        
                    }                    
                }else{
                        $transaction->rollback();
                        $response = array('r' => false,'v' => "Ha ocurrido un inconveniente al intentar guardar el proceso: ".$evaluacionpersona->descripcion); 
                        echo CJSON::encode($response);                        
                }           
            }
            $this->render('crear');
        }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Evaluacionpersonas']))
		{
			$model->attributes=$_POST['Evaluacionpersonas'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Evaluacionpersonas');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Evaluacionpersonas('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Evaluacionpersonas']))
			$model->attributes=$_GET['Evaluacionpersonas'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Evaluacionpersonas::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='evaluacionpersonas-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        public static function gridmysqltophpdate($date){
            return CommonFunctions::datemysqltophp($date);
        }
        
        public static function gridestado($estado){
            switch ($estado){
                case 1:
                    return "En proceso";
                    break;
                case 2:
                    return "Finalizado";
                    break;
            }
        }
}
