<?php

class ProcesoevaluacionController extends Controller
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
				'actions'=>array('crear','update','admin','AgregarPersonas','AgregarPersona','AutocompleteEvaluado',
                                                    'HabilidadesEspeciales','InfoPonderacion', 'delete', 'reporteevaluacioncompetencias', 'DataReporteEvaluacionCompetencias'),
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
        
        public function actionAgregarPersonas($id)
        {
            $procesoevaluacion = Procesoevaluacion::model()->findByPk($id);                         
            
            if(isset($procesoevaluacion))
            {            
                $dataProvider =new CActiveDataProvider('Evaluacioncompetencias',array('criteria'=>array(
                    'condition'=>'procesoevaluacion='.$id)));            

                $this->render('agregarpersonas',array(
                            'model'=>$procesoevaluacion,'dataProvider'=>$dataProvider
                    ));
            }
            else
                $this->redirect(array('admin'));
            
        }
        
        public function actionAgregarPersona()
        {
            if(Yii::app()->request->isAjaxRequest)
            {
                
                $idpersona = $_POST['id'];
                $tipopersona = $_POST['tipo'];                                
                $idevaluacion = $_POST['idevaluacion'];
                
                //ver validar
                
                $evaluacion = Evaluacioncompetencias::model()->findByAttributes(array('tipo'=>$tipopersona,'evaluado'=>$idpersona,'procesoevaluacion'=>$idevaluacion));                
                
                if(!$evaluacion)
                {

                    $evaluacionCompetencia = new Evaluacioncompetencias();
                    $evaluacionCompetencia->tipo = CommonFunctions::stringtonumber($tipopersona); 
                    $evaluacionCompetencia->evaluado = CommonFunctions::stringtonumber($idpersona);                                
                    $evaluacionCompetencia->procesoevaluacion = CommonFunctions::stringtonumber($idevaluacion);
                    $evaluacionCompetencia->fechaevaluacion = CommonFunctions::datenow();
                                                            
                    if($evaluacionCompetencia->save())
                        $response = array('result' => true,'value' => "La persona fue agregada correctamente.");
                    else                    
                        $response = array('result' => false,'value' => 'Ha ocurrido un inconveniente, intente nuevamente.');                    
                        

                    echo CJSON::encode($response);               
                    
                }
                else
                {
                    $response = array('result' => false,'value' => 'La persona seleccionada ya ha sido registrada en esta evaluación.');                    
                    echo CJSON::encode($response);               
                }
                
                Yii::app()->end();
            }
            
        }
        
        public function actionAutocompleteEvaluado()
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
                
                $dataReaderPos = Yii::app()->db->createCommand(
                        'SELECT c.cedula,c.nombre,c.apellido1,c.apellido2, c.id '.
                        'FROM postulante c '.                        
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
                        'label'=>'<div style="font-size:x-small">Cédula: '.$row['cedula'].'</div>'.'<div>'.$nombrecompleto.'</div>',
                        'value'=>$nombrecompleto, 
                        'id'=>$row['id'],
                         'cedula'=>$row['cedula'],                        
                            'tipo'=>1,                        
                        );
                    }
                    foreach($dataReaderPos as $row){ 
                        $nombrecompleto = $row['nombre'].' '.$row['apellido1'].' '.$row['apellido2'];
                        $return_array[] = array(
                        'label'=>'<div style="font-size:x-small">Cédula: '.$row['cedula'].'</div>'.'<div>'.$nombrecompleto.'</div>',
                        'value'=>$nombrecompleto, 
                        'id'=>$row['id'],
                         'cedula'=>$row['cedula'],                        
                            'tipo'=>0,                        
                        );
                    }
                }
                echo CJSON::encode($return_array);
            }
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
		$model=new Procesoevaluacion;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['procesoevaluacion']))
		{
			$model->attributes=$_POST['procesoevaluacion'];
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
                
                $evaluacionpersona = new Procesoevaluacion();
                
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
                        foreach ($_POST['habilidades'] as $nombre => $informacion) {
                            $habilidadesespecial = new Habilidadespecial();
                            $habilidadesespecial->nombre = $nombre;
                            $habilidadesespecial->descripcion = $informacion['descripcion'];
                            $habilidadesespecial->ponderacion = $informacion['ponderacion'];
                            $habilidadesespecial->proceoevaluacion = $procesoevaluacion->id;
                            $saveresult = $habilidadesespecial->save();                      
                        }
                    }
                    if($saveresult){                    
                       $transaction->commit();
                       $response = array('result' => true,'value' => "Se guardó con éxito el proceso: ".$evaluacionpersona->descripcion, 'idproceso' => $evaluacionpersona->id);
                       echo CJSON::encode($response);   
                       Yii::app()->end();
                    }else{
                        $transaction->rollback();
                        $response = array('result' => false,'value' => "Ha ocurrido un inconveniente al intentar guardar el proceso: ".$evaluacionpersona->descripcion); 
                        echo CJSON::encode($response); 
                        Yii::app()->end();
                    }                    
                }else{
                        $transaction->rollback();
                        $response = array('result' => false,'value' => "Ha ocurrido un inconveniente al intentar guardar el proceso: ".$evaluacionpersona->descripcion); 
                        echo CJSON::encode($response);                        
                        Yii::app()->end();
                }           
            }
            
            
            $this->render('crear');
        }
        
        public function actionHabilidadesEspeciales(){
            
            if (Yii::app()->request->isAjaxRequest)
            {
                $hashabilidades = true;
                $procesoevaluacion = Procesoevaluacion::model()->findByPk($_GET['id']);
                $habilidadesespeciales = $procesoevaluacion->_habilidadesespecial;
                if(empty($habilidadesespeciales)){$hashabilidades = false;}
                $this->renderPartial('verhabilidadesespeciales', array('procesoevaluacionnombre' => $procesoevaluacion->descripcion, 'habilidadesespeciales'=> $habilidadesespeciales, 'hashabilidades' => $hashabilidades),false,true);                
                echo CHtml::script('$("#dlghabilidadesespeciales").dialog("open")');
                Yii::app()->end();
            }
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

		if(isset($_POST['procesoevaluacion']))
		{
			$model->attributes=$_POST['procesoevaluacion'];
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
	public function actionDelete()
	{
		$procesoevaluacion = $this->loadModel($_GET["id"]);
                $procesoevaluacion->estado = 0;
                $resultado = $procesoevaluacion->save();
                
                if($resultado){
                    echo 'Exito';
                }
                else{
                    echo 'Fallo';
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
		$dataProvider=new CActiveDataProvider('Procesoevaluacion');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
            $model = Procesoevaluacion::model()->search();                
            $filtersForm=new FiltersForm;

            if (isset($_GET['FiltersForm']))
                $filtersForm->filters=$_GET['FiltersForm'];                
            
            $this->layout='column1';
            $this->render('admin',array(
                'model' => $filtersForm->filter($model),
                'filtersForm' => $filtersForm,
            ));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=  Procesoevaluacion::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='procesoevaluacion-form')
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
        
        public function actionInfoPonderacion(){
            $criterio = new CDbCriteria();
            $criterio->addColumnCondition(array('estado'=>'1'));
            $ponderaciones = Ponderacion::model()->findAll($criterio);
            $html = '';
            $html .= '<div>';
            $html .= '<h4 style="text-align:center">Interpretación de la escala de ponderación.</h4>';
            $html .= '<ul>';
            foreach ($ponderaciones as $ponderacion) {                
                $html .= '<li>Ponderación: '.$ponderacion->valor.' = '.$ponderacion->descripcion.'</li>';                              
            }
            $html .= '</ul>'; 
            $html .= '</div>';
            $response = array('html' => $html);                    
            echo CJSON::encode($response);                                           
            Yii::app()->end();
        }
        
        public function actionReporteEvaluacionCompetencias(){    
                
                $this->layout = 'main';
                $idevaluacioncompetencias = $_GET['idevaluacioncompetencias'];               
                $evaluacioncompetencias = Evaluacioncompetencias::model()->findByPk($idevaluacioncompetencias);   
                $idprocesoevaluacion = $evaluacioncompetencias->procesoevaluacion;
                $datarelativo = $evaluacioncompetencias->obtenerGraficoSpiderRelativo($idevaluacioncompetencias, $idproceosevaluacion);            
                $datacalificado = $evaluacioncompetencias->obtenerGraficoSpiderCalificado($idevaluacioncompetencias, $idprocesoevaluacion);
            
                $this->render('reporteevaluacioncompetencias',array(
                        'evaluacioncompetencias'=>$evaluacioncompetencias,
                        'relativo'=>$datarelativo,
                        'calificado'=>$datacalificado
		)); 
        }
        
        /*
        public function actionDataReporteEvaluacionCompetencias()
        { 
            $idevaluacionpersonas = $_POST['idevaluacionpersonas'];           
            $idevaluacioncompetencias = $_POST['idevaluacioncompetencias'];
           
            $evaluacioncompetencias = Evaluacioncompetencias::model()->findByPk($idevaluacioncompetencias);                           
            $datarelativo = $evaluacioncompetencias->obtenerGraficoSpiderRelativo($idevaluacioncompetencias, $idevaluacionpersonas);            
            $datacalificado = $evaluacioncompetencias->obtenerGraficoSpiderCalificado($idevaluacioncompetencias, $idevaluacionpersonas);
            
            //Relativo e Ideal                        
            $barlabelsrelativo = array();
            $barserierelativo = array();
            $barlabelscomparacioncompetencias= array();
            $barserieideal = array(); 
             for ($index = 0; $index < count($datarelativo); $index++) {                 
                 //Grafico Barras -> Valoracion Relativa -> Relativo
                 array_push($barlabelsrelativo,  [$index, $datarelativo[$index]["eje"]]);    
                 array_push($barserierelativo,  [CommonFunctions::stringtonumber($datarelativo[$index]["calificacion"]), $index]);
                 //Grafico Barras -> Comparacion Competencias -> Ideal
                 array_push($barlabelscomparacioncompetencias,  [$index, $datarelativo[$index]["eje"]]);
                 array_push($barlabelscomparacioncompetencias,  [$index+0.5, $datarelativo[$index]["eje"]]);  
                 array_push($barserieideal,  [CommonFunctions::stringtonumber(CommonFunctions::ponderaciontoideal($datarelativo[$index]["calificacion"])), $index]);
             }
          
            //Calificado          
            $barseriecalificado = array();
            for ($index = 0; $index < count($datacalificado); $index++) {      
                 //Grafico Barras -> Comparacion Competencias -> Calificado                   
                 array_push($barseriecalificado,  [CommonFunctions::stringtonumber($datacalificado[$index]["calificacion"]), $index+0.5]);
            }
            
            //Logica de grafico Radar - Cobertura de Requisitos
            //Logica para obtener los labels
            $labels = array();
            for ($index = 0; $index < count($datacalificado); $index++) {
                    $labels["labels"][$index] = $datacalificado[$index]["eje"];
            }            
           //Logica para Ideal          
           $serieideal = array();
           $serieideal["ideal"]["label"] = "Candidato Ideal";
           for ($index = 0; $index < count($datarelativo); $index++) {
                    $serieideal["ideal"]["data"][$index] =  [CommonFunctions::stringtonumber($index),CommonFunctions::stringtonumber(CommonFunctions::ponderaciontoideal($datarelativo[$index]["calificacion"]))];   
           }            
           //Logica para evaluacion obtenida
           $serievaluacion = array();
           $serievaluacion["evaluacion"]["label"] = "Resultado Evaluación";
           for ($index = 0; $index < count($datacalificado); $index++) {
                   $serievaluacion["evaluacion"]["data"][$index] =  [CommonFunctions::stringtonumber($index),CommonFunctions::stringtonumber($datacalificado[$index]["calificacion"])];                 
           }            
        
           $data = array($labels,$serieideal,$serievaluacion,$barlabelsrelativo, $barserierelativo, $barlabelscomparacioncompetencias, $barserieideal, $barseriecalificado);          
         
           echo CJSON::encode($data);                        
           Yii::app()->end();                
           
        }       */
}
