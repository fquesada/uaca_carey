<?php

class UnidadnegocioController extends Controller
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
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','addpuesto','save'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionSave()
        {
             if (isset($_POST['puestoselect'])){

                foreach ($_POST['puestoselect'] as $puesto){
                    $puestounidad = new UnidadNegocioPuesto();
                    $puestounidad->puesto = $puesto;
                    $puestounidad->unidadnegocio = Yii::app()->session['unidadnegocio'];
                    $puestounidad->save();
                }

                Yii::app()->user->setFlash('success','Se agrego correctamente los puestos a la unidad de negocio.');         
                $this->redirect(array('addpuesto','id'=>Yii::app()->session['unidadnegocio']));
             }
             else
                 Yii::app()->user->setFlash('error','Se debe seleccionar al menos un puesto para asociar a la unidad de negocio.');
                 $this->redirect(array('addpuesto','id'=>Yii::app()->session['unidadnegocio']));
             
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
		$model=new Unidadnegocio;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Unidadnegocio']))
		{
			$model->attributes=$_POST['Unidadnegocio'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
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
		$this->performAjaxValidation($model);

		if(isset($_POST['Unidadnegocio']))
		{
			$model->attributes=$_POST['Unidadnegocio'];
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
                $sqlpuestos='SELECT puesto.nombre '.
                 'FROM puesto INNER JOIN unidadnegociopuesto '.
                 'ON puesto.id=unidadnegociopuesto.puesto '.
                 'WHERE puesto.estado=1 AND unidadnegociopuesto.unidadnegocio='. $id;
                
                $puestos= Yii::app()->db->createCommand($sqlpuestos)->queryAll();
                
                if ($puestos == NULL){
                
                $model=$this->loadModel($id);
                $model->estado = '0';
                
                Yii::app()->user->setFlash('success',"La unidad de negocio ". $model->nombre. " fue eliminada.");

                
                if($model->save())
                    $this->redirect(array('admin'));
                }
                else{
                    $mensaje = "La unidad de negocio no puede ser eliminada porque tiene asociados los siguientes puestos: <br>";
                    $nom = "";
                        foreach ($puestos as $puestosasociados){

                        $nom = $nom. implode($puestosasociados). "<br> ";
                                                     
                        }
                        $mensaje = $mensaje. "<br>" .$nom;
                        Yii::app()->user->setFlash('error',$mensaje);
                }
                
                
                
                
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
//		$dataProvider=new CActiveDataProvider('Unidadnegocio');
//		$this->render('index',array(
//			'dataProvider'=>$dataProvider,
//		));
            
                $model=new Unidadnegocio('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Unidadnegocio']))
			$model->attributes=$_GET['Unidadnegocio'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Unidadnegocio('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Unidadnegocio']))
			$model->attributes=$_GET['Unidadnegocio'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
        
        public function actionAddpuesto($id)
        {
            $model=$this->loadModel($id);
            
            $this->render('addpuesto',array(
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
		$model=Unidadnegocio::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='unidadnegocio-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
