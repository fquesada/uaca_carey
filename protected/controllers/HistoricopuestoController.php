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
				'actions'=>array('index','view', 'GetPuestos'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','cambiarpuesto'),
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
		 if (Yii::app()->request->isAjaxRequest) 
                  {
                    $this->renderPartial('view', array(
                                                   'model'=>$this->loadModel($id),
                                                 ),
                                          false,true);
                    echo CHtml::script('$("#dialogPuestodecolaborador").dialog("open")');
                     Yii::app()->end();
                   }
                 else
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
		$model=new Historicopuesto;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Historicopuesto']))
		{
			$model->attributes=$_POST['Historicopuesto'];
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
		// $this->performAjaxValidation($model);

		if(isset($_POST['Historicopuesto']))
		{
			$model->attributes=$_POST['Historicopuesto'];
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
		$dataProvider=new CActiveDataProvider('Historicopuesto');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Historicopuesto('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Historicopuesto']))
			$model->attributes=$_GET['Historicopuesto'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
        
        public function actionCambiarpuesto ($id)
        {
            $actual=$this->loadModel($id);
            $model = new Historicopuesto;
            
            $this->performAjaxValidation($model);
            
            if (isset ($_POST['Historicopuesto'])){
                
                $transaction = Yii::app()->db->beginTransaction();
		
                $actual->puestoactual = '0';
                $resultado = $actual->save();
                        
                if ($resultado){
                    $model->fechadesignacion = CommonFunctions::datenow();
                    $model->colaborador = $actual->id;
                    $model->puestoactual = '1';
                    $model->unidadnegocio = $_POST['Historicopuesto']['unidadnegocio'];
                    $model->puesto = $_POST['Historicopuesto']['puesto'];

                    $resultado = $model->save();

                    if($resultado){
                        $transaction->commit();
                        Yii::app()->user->setflash('success','El colaborador fue cambiado de puesto exitosamente');
                        $this->redirect(array('admin'));
                    }
                    else{
                        $transaction->rollback();                                                               
                    }                                
                }
                else{
                    $transaction->rollBack();                                                                         
                }                  
            }
            
            $this->render('cambiarpuesto',array(
			'actual'=>$actual,
                        'model'=> $model,
                        
		));
            
            
        }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Historicopuesto::model()->findByAttributes(array('colaborador'=>$id, 'puestoactual'=>'1'));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        
                public function actionGetPuestos()
        {
            echo CHtml::tag('option',
                            array('value'=>'empty'),CHtml::encode('Selecione un puesto'),true);//Para que siempre aparezca al inicio
            
            if(isset($_POST['Historicopuesto']['unidadnegocio']))
            {
                $unidadnegocio = $_POST['Historicopuesto']['unidadnegocio'];
                
                $dataReader = Yii::app()->db->createCommand(
                        'SELECT p.id, p.nombre '.
                        'FROM puesto p '.
                        'JOIN unidadnegociopuesto up ON up.puesto = p.id '.
                        'JOIN unidadnegocio u ON up.unidadnegocio = u.id '.
                        'WHERE unidadnegocio = '.$unidadnegocio.' AND p.estado = 1;'
                        )->query();
                
                $data=CHtml::listData($dataReader,'id','nombre');
                
                foreach($data as $value=>$nombre) {
                            echo CHtml::tag('option',
                            array('value'=>$value),CHtml::encode($nombre),true);
                    }
            }
            else
            {
                echo CHtml::tag('option',
                            array('value'=>'0'),CHtml::encode('No existen puestos en esa unidad.'),true);
            }
        }

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='historicopuesto-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
