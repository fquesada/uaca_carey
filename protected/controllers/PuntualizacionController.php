<?php

class PuntualizacionController extends Controller
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
		$model=new Puntualizacion;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Puntualizacion'])){
                        $sqlpuntualizacion='SELECT puestopuntualizacion.puntualizacion '.
                             'FROM puestopuntualizacion '.
                             'WHERE puestopuntualizacion.puesto='. Yii::app()->session['puesto'];

                        $puntualizacion= Yii::app()->db->createCommand($sqlpuntualizacion)->queryAll();

                        if(count($puntualizacion)== 5){
                            echo CJSON::encode(array(
                            'status'=>'failure',
                            'div'=>  "No es posible asociar la puntualización al puesto porque el mismo ya tiene asociado 5 puntualiazciones (Máximo de puntualizaciones permitido por puesto)."
                            )
                            );
                            exit;
                        }
                        else{
                            $model->attributes=$_POST['Puntualizacion'];
                            if($model->save())
                            {

                                $puestopun = new PuestoPuntualizacion();
                                $puestopun->puesto = Yii::app()->session['puesto'];
                                $puestopun->puntualizacion = $model->id;

                                $puestopun->save();

                                if(Yii::app()->request->isAjaxRequest)
                                {
                                    echo CJSON::encode(array(
                                        'status'=>'success',
                                        'div'=>"Puntualización creada con éxito"
                                    ));
                                    exit;

                                }
                                else
                                    $this->redirect(array('view','id'=>$model->id));                                
                            }
                        }
                }
                if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                         'status'=>'failure',
                         'div'=>  $this->renderPartial('_form', array('model'=>$model), true)
                          )
                    );
                    exit;
                }
                else
                    $this->render ('create', array('model'=>$model));
                
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

		if(isset($_POST['Puntualizacion']))
		{
			$model->attributes=$_POST['Puntualizacion'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
                $model=new Puntualizacion('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Puntualizacion']))
			$model->attributes=$_GET['Puntualizacion'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Puntualizacion('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Puntualizacion']))
			$model->attributes=$_GET['Puntualizacion'];

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
		$model=Puntualizacion::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='puntualizacion-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
