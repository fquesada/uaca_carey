<?php

class PuestoController extends Controller
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
				'actions'=>array('admin','delete','Addcompetence','Addpuntualizacion', 'SaveCompetencia','SavePuntualizacion'),
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
		$model=new Puesto;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Puesto']))
		{
			$model->attributes=$_POST['Puesto'];
                        $criterio = new CDbCriteria();
                        $criterio->addColumnCondition(array('estado'=>'1'));
                        
                        $nombres = Puesto::model()->findAllByAttributes(array('nombre'=>$model->nombre), $criterio);
                        $codigos = Puesto::model()->findAllByAttributes(array('codigo'=>$model->codigo), $criterio);
                        
                        
			if($nombres != null){
                                $model->addError('nombre', 'El nombre utilizado para el puesto a crear ya se encuentra utilizado.');
                        }
                        elseif($codigos != null){
                                $model->addError('codigo', 'El código utilizado para el puesto a crear ya se encuentra utilizado.');
                        }
                        else{
                            if($model->save())
				$this->redirect(array('view','id'=>$model->id));
                        }
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

		if(isset($_POST['Puesto']))
		{
			$model->attributes=$_POST['Puesto'];
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
        //No se esta usando
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
                $model->estado = '0';

                if($model->save())
                    $this->redirect(array('admin'));
                
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
//		$dataProvider=new CActiveDataProvider('Puesto');
//		$this->render('index',array(
//			'dataProvider'=>$dataProvider, array('pagination'=>array('pageSize'=>10))
//		));
            $model=new Puesto('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Puesto']))
			$model->attributes=$_GET['Puesto'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Puesto('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Puesto']))
			$model->attributes=$_GET['Puesto'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
        
        public function actionAddcompetence($id)
        {
            $model=$this->loadModel($id);

            $this->render('addcompetence',array('model'=>$model));
        }
        
        public function actionAddpuntualizacion($id)
        {
            $model=$this->loadModel($id);

            $this->render('addpuntualizacion',array('model'=>$model));
        }
        
        public function actionSaveCompetencia(){
            
            if (isset($_POST['compselect']) && $_POST['peso'] != ''){
                //Verificar cuantas competencias a agregado
//                IF()
//                
//                else()
                
                //Lógica en caso de no violentar el limite máximo de competencias
                $puestocomp = new Puestocompetencia();
                                   
                $puestocomp->puesto = Yii::app()->session['puesto'];

                $competencias = $_POST['compselect'];

                foreach($competencias as $competencia){
                    $puestocomp->competencia = $competencia;
                }
                
                $ponderacion = $_POST['peso'];
                
                foreach($ponderacion as $peso){
                    $puestocomp->ponderacion = $peso;
                }

                if($puestocomp->save()){
                    Yii::app()->user->setFlash('success','Se agrego correctamente la competencia al puesto.');
                    $this->redirect(array('addcompetence','id'=>Yii::app()->session['puesto']));
                }
            }                
            else{
                
                if(!isset($_POST['compselect'])){
                    Yii::app()->user->setFlash('error','Se debe seleccionar una competencia para asociar al puesto.');
                    $this->redirect(array('addcompetence','id'=>Yii::app()->session['puesto']));
                }
                //else(!isset($_POST['peso'])){
                  elseif($_POST['peso'] == ''){
                    Yii::app()->user->setFlash('error','Se debe seleccionar el peso de la competencia sobre el puesto.');
                    $this->redirect(array('addcompetence','id'=>Yii::app()->session['puesto']));
                }
            }
        }
        
                	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Puesto::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='puesto-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
