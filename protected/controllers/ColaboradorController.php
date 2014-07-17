<?php

class ColaboradorController extends Controller
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
				'actions'=>array('index','view','GetPuestos'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','Gestionpuesto','elegirpuesto','actualizarpuesto','asignarpuesto'),
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
		$model=new Colaborador;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Colaborador']))
		{
			$model->attributes=$_POST['Colaborador'];
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

		if(isset($_POST['Colaborador']))
		{
			$model->attributes=$_POST['Colaborador'];
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
		$colaborador = $this->loadModel($id);
                
                $colaborador->estado = '0';
                
                if($colaborador->save())
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
		$model=new Colaborador('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Colaborador']))
			$model->attributes=$_GET['Colaborador'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Colaborador('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Colaborador']))
			$model->attributes=$_GET['Colaborador'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
        
        public function actionGetPuestos()
        {
            echo CHtml::tag('option',
                            array('value'=>'empty'),CHtml::encode('Selecione un puesto'),true);//Para que siempre aparezca al inicio
            
            if(isset($_POST['Colaborador']['unidadnegocio']))
            {
                $unidadnegocio = $_POST['Colaborador']['unidadnegocio'];
                
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
        
        public function actionGestionpuesto($id)
        {
            $model=$this->loadModel($id);
            
            //relacion siempre esta dando TRUE, hay que corregirlo
            //$relacion = $model->getActiveRelation('_colaboradoreshistoricopuesto');
            
            $historicopuesto = Historicopuesto::model()->findByAttributes(array('colaborador' => $model->id), 'puestoactual=1'); 
            
            $historico = Historicopuesto::model();
            
            if($historicopuesto == NULL){
                $this->render('gestionpuesto',array('model'=>$model,'historico'=>$historico,'indicador'=>FALSE, 'ingresos'=>1));
                
            }
            else{
                $this->render('gestionpuesto',array('model'=>$model,'historico'=>$historico, 'indicador'=>TRUE, 'ingresos'=>1));
                
            }
        }
        
        public function actionActualizarpuesto($idcolaborador){
            
           $colaborador = $this->loadModel($idcolaborador);
           $historicopuestonuevo = new Historicopuesto;
                  
           if(empty($_POST['Historicopuesto']['unidadnegocio']) && empty($_POST['Historicopuesto']['puesto'])){
               
                    Yii::app()->user->setFlash('error','Se debe completar los datos solicitados para realizar la actualización del puesto.');
                    $this->render('gestionpuesto',array('model'=>$colaborador,'historico'=>$historicopuestonuevo,'indicador'=>TRUE, 'ingresos'=>2));

           }
           else{

                       $historicopuestonuevo->fechadesignacion = date("Y-m-d");
                       $historicopuestonuevo->colaborador = $colaborador->id;
                       $historicopuestonuevo->puestoactual = "1";
                       $historicopuestonuevo->unidadnegocio = $_POST['Historicopuesto']['unidadnegocio'];
                       $historicopuestonuevo->puesto = $_POST['Historicopuesto']['puesto'];
                       
                       $historicopuesto = Historicopuesto::model()->findByAttributes(array('colaborador' => $colaborador->id), 'puestoactual=1');    
                   
                       $historicopuesto->puestoactual = "0";

                       //Modifica el puesto anterior para que deje de ser el actual y guarda en base el nuevo registro 
                       //de historicopuesto, que a partir de ahora sera el puesto del colaborador en cuestion
                        if($historicopuestonuevo->save()&& $historicopuesto->save()){
                          
                            Yii::app()->user->setFlash('success','El puesto ' .$historicopuestonuevo->nombrepuesto. ' de la unidad de negocio '.$historicopuestonuevo->nombreunidad.' fue asignado correctamente a '. $colaborador->nombrecompleto);
                            $this->redirect(array('admin'));
                        }
                      else{
                          
                            $historicopuestonuevo = new Historicopuesto;
                            Yii::app()->user->setFlash('error','Ocurrio un error al actualizar el puesto de '. $colaborador->nombrecompleto);
                            $this->render('gestionpuesto',array('model'=>$colaborador,'historico'=>$historicopuestonuevo,'indicador'=>TRUE, 'ingresos'=>2));
                   }
           }
        }
        
        public function actionAsignarpuesto($idcolaborador){
            
            $colaborador = $this->loadModel($idcolaborador);
            $historicopuestonuevo = new Historicopuesto;
            
            if(empty($_POST['Historicopuesto']['unidadnegocio']) && empty($_POST['Historicopuesto']['puesto'])){

                Yii::app()->user->setFlash('error','Se debe completar los datos solicitados para realizar la actualización del puesto.');
                $this->render('gestionpuesto',array('model'=>$colaborador,'historico'=>$historicopuestonuevo,'indicador'=>FALSE, 'ingresos'=>2));
           }
           else{
            
                $historicopuestonuevo->fechadesignacion = date("Y-m-d");
                $historicopuestonuevo->colaborador = $colaborador->id;
                $historicopuestonuevo->puestoactual = "1";
                $historicopuestonuevo->unidadnegocio = $_POST['Historicopuesto']['unidadnegocio'];
                $historicopuestonuevo->puesto = $_POST['Historicopuesto']['puesto'];

                if($historicopuestonuevo->save()){
                    Yii::app()->user->setFlash('success','El puesto ' .$historicopuestonuevo->nombrepuesto. ' de la unidad de negocio '.$historicopuestonuevo->nombreunidad.' fue asignado correctamente a '. $colaborador->nombrecompleto);
                    $this->redirect(array('admin'));
                }
                else{
                    $historicopuestonuevo = new Historicopuesto;
                    Yii::app()->user->setFlash('error','Ocurrio un error al ingresar el puesto de '. $colaborador->nombrecompleto);
                    $this->render('gestionpuesto',array('model'=>$colaborador,'historico'=>$historicopuestonuevo,'indicador'=>FALSE, 'ingresos'=>2));
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
		$model=Colaborador::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='colaborador-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
