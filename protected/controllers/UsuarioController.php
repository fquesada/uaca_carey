<?php

class UsuarioController extends Controller
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
				'actions'=>array('create','update','CambiarPass','AutoCompleteColaborador','ObtenerEstadoPassword'),
				'users'=>array('*'),
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
		$model=new Usuario('create');
                $transaction = Yii::app()->db->beginTransaction();

                //$model2 = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Usuario']))
		{
			$model->attributes=$_POST['Usuario'];
                        //$model->confirmacion= $_POST['Usuario']['confirmacion'];
                        $model->password = crypt($model->password, $model->getsalt());
                        $model->confirmarPassword = crypt($model->confirmarPassword, $model->getsalt());
                        $model->fechacreacion = CommonFunctions::datenow();
                        $model->estadopassword = 0;

                        $resultado = $model->save();
                        $idusuario = $model->id;
                        $idcolaborador = $_POST['Usuario']['colaborador'];
                       
                       /*if($model->confirmacion == 'S')
                       {
                            if($resultado)
                                {
                                $tablaintermedia = new ColaboradorUsuario();

                                $tablaintermedia->colaborador = $idcolaborador;
                                $tablaintermedia->usuario = $idusuario;

                                $result = $tablaintermedia->save();

                                if($result)
                                    {
                                        $transaction->commit();
                                        $this->redirect(array('view','id'=>$model->id));
                                    }
                                else{
                                $transaction->rollBack();
                                }
                            }
                       }*/
                
                       /*else*/ if($resultado){
                         $transaction->commit();
                         $this->redirect(array('view','id'=>$model->id));
                       }
                       
                       else{
                           $transaction->rollBack();
                       }
                }
                 $this->render('create',array(
                    'model'=>$model,));
                
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

		if(isset($_POST['Usuario']))
		{
			$model->attributes=$_POST['Usuario'];
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
		$usuario = $this->loadModel($id);
                
                $usuario->estado = '0';
                
                if($usuario->save())
                    $this->redirect(array('admin'));

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        
        public function actionCambiarPass($id)
        {
                 $model=$this->loadModel($id);
                 $model->scenario = 'CambiarPass';
                 
                 if(isset($_POST['Usuario']))
                    {
                       $model->attributes=$_POST['Usuario'];
                       $password_actual = ($model->password_actual);

                       $password_nueva = ($model->password_nueva);

                        if (crypt($password_actual, $model->getsalt()) === $model->password)
                            {
                               $model->password = (crypt($password_nueva, $model->getsalt()));
                               $model->estadopassword = 1;
                            }

                       if ($model->save())
                       $this->redirect(array('view','id'=>$model->id));
                    }
                $this->render('CambiarPass',array(
                       'model'=>$model,
               ));
              }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new Usuario('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Usuario']))
			$model->attributes=$_GET['Usuario'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Usuario('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Usuario']))
			$model->attributes=$_GET['Usuario'];
                        $model->estado = '1';

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
		$model=Usuario::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        
        public function actionAutoCompleteColaborador()
        {
            if (isset($_GET['term'])) {

                $keyword=$_GET['term'];
                // escape % and _ characters
                $keyword=strtr($keyword, array('%'=>'\%', '_'=>'\_'));
                               
                $dataReader = Yii::app()->db->createCommand(
                        'SELECT c.cedula,c.nombre,c.apellido1,c.apellido2, c.id '.
                        'FROM colaborador c '.
                        'WHERE CONCAT_WS(" ", c.nombre, c.apellido1, c.apellido2 ) like "%'.$keyword.'%" AND c.estado = 1;'
                        )->query();                               

                $return_array = array();
                if($dataReader->count() == 0)
                {
                    $return_array[] = array(
                    'label'=>'No hay resultados.',
                    'value'=>'',
                    );
                }
                else{
                    foreach($dataReader as $row){
                        $nombrecompleto = $row['nombre'].' '.$row['apellido1'].' '.$row['apellido2'];
                        $return_array[] = array(
                        'label'=>'<div style="font-size:x-small">'.$row['cedula'].'</div>'.'<div>'.$nombrecompleto.'</div>',
                        'value'=>$nombrecompleto,
                        'id'=>$row['id'],
                         'cedula'=>$row['cedula'],
                        );
                    }
                }
                
                echo CJSON::encode($return_array);
            }
        }
        
        public function ObtenerEstadoPassword(){
            $usuario = (Yii::app()->user->name);
            $modelo = Usuario::model()->findBySql('SELECT * FROM usuario u WHERE u.login = "'.$usuario.'" AND u.estado = 1;');
            
            if($modelo->estadopassword == 1)
                {
                    return true;
                }
                else
                {
                    return false;
                }
        }

        /**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='usuario-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
