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
	{       //CLEAN CODE GUARDAR Y EVALUAR PROCESO DEBE ESTAR ACCESO PARA TODOS
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('CrearProcesoEC','AdminProcesoEC','EditarProcesoEC','EliminarProcesoEC','EvaluarProcesoEC','EnvioCorreoEC','GuardarEvaluacionEC','update','admin','AgregarPersonas','AgregarPersona','AutocompleteEvaluado',
                                                    'HabilidadesEspeciales','InfoPonderacion', 'delete', 'reporteevaluacioncompetencias', 'DataReporteEvaluacionCompetencias', 'vistaprueba','CrearReporteEC','ReporteEC','CargaMasiva','CargaDepartamento',
                                                    'ReporteAnalisisEC'),
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
        
        public function actionVistaPrueba(){
//             $idcolaborador =1;
//             $colaborador = Colaborador::model()->findByPk($idcolaborador);
//             $puesto = $colaborador->getidpuestoactual();//HACER FUNCION DEME PUESTO
//             if(!$puesto)
////                 $puesto = 'Es Nulo';
//            $puesto = Yii::app()->getBaseUrl(true);
//           $puesto = Yii::app()->getBaseUrl(true).'//index.php/procesoevaluacion/admin';
//         
            $idprocesoec = 1;
            $proceso = Procesoevaluacion::model()->findByPk($idprocesoec);
            
            $ec = $proceso->_evaluacionescompetencias;
            
           
             $this->render('vistaprueba',array(
			'proceso'=>$proceso, 'ec' =>$ec
		));
             
        }
        
        public function actionAgregarPersonas($id)
        {
            $evaluacionpersonas = Evaluacionpersonas::model()->findByPk($id);                         
            
            if(isset($evaluacionpersonas))
            {            
                $dataProvider =new CActiveDataProvider('Evaluacioncompetencias',array('criteria'=>array(
                    'condition'=>'evaluacionpersonas='.$id)));            

                $this->render('agregarpersonas',array(
                            'model'=>$evaluacionpersonas,'dataProvider'=>$dataProvider
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
                
                $evaluacion = Evaluacioncompetencias::model()->findByAttributes(array('tipo'=>$tipopersona,'evaluado'=>$idpersona,'evaluacionpersonas'=>$idevaluacion));                
                
                if(!$evaluacion)
                {

                    $evaluacionCompetencia = new Evaluacioncompetencias();
                    $evaluacionCompetencia->tipo = CommonFunctions::stringtonumber($tipopersona); 
                    $evaluacionCompetencia->evaluado = CommonFunctions::stringtonumber($idpersona);                                
                    $evaluacionCompetencia->evaluacionpersonas = CommonFunctions::stringtonumber($idevaluacion);
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
                
                //CLEAN CODE, DEBERIA ESTAR EN MODELS
                $dataReader = Yii::app()->db->createCommand(
                        'SELECT c.cedula,c.nombre,c.apellido1,c.apellido2, c.id, p.nombre as "puesto" '.
                        'FROM colaborador c INNER JOIN historicopuesto hp on c.id = hp.colaborador and hp.puestoactual = 1 INNER JOIN puesto p  ON hp.puesto = p.id '.                        
                        'WHERE CONCAT_WS(" ", c.nombre, c.apellido1, c.apellido2 ) like "%'.$keyword.'%" AND c.estado = 1;'
                        )->query();   
                
//                $dataReaderPos = Yii::app()->db->createCommand(
//                        'SELECT c.cedula,c.nombre,c.apellido1,c.apellido2, c.id '.
//                        'FROM postulante c '.                        
//                        'WHERE CONCAT_WS(" ", c.nombre, c.apellido1, c.apellido2 ) like "%'.$keyword.'%" AND c.estado = 1;'
//                        )->query(); 
                                

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
                        'label'=>'<div style="font-size:x-small">Puesto: '.$row['puesto'].'</div>'.'<div>'.$nombrecompleto.'</div>',
                        'value'=>$nombrecompleto, 
                        'id'=>$row['id'],
                         'cedula'=>$row['cedula'],   
                         'puesto'=>$row['puesto'],
                            'tipo'=>1,                        
                        );
                    }
//                    foreach($dataReaderPos as $row){ 
//                        $nombrecompleto = $row['nombre'].' '.$row['apellido1'].' '.$row['apellido2'];
//                        $return_array[] = array(
//                        'label'=>'<div style="font-size:x-small">Cédula: '.$row['cedula'].'</div>'.'<div>'.$nombrecompleto.'</div>',
//                        'value'=>$nombrecompleto, 
//                        'id'=>$row['id'],
//                         'cedula'=>$row['cedula'],                        
//                            'tipo'=>0,                        
//                        );
//                    }
                }
                echo CJSON::encode($return_array);
            }
        }
        
        public function actionCargaMasiva(){            
            $idevaluador = CommonFunctions::stringtonumber($_POST['idevaluador']);
            $dataReader = Yii::app()->db->createCommand(
                        'SELECT c.cedula,c.nombre,c.apellido1,c.apellido2, c.id, p.nombre as "puesto" '.
                        'FROM colaborador c INNER JOIN historicopuesto hp on c.id = hp.colaborador and hp.puestoactual = 1 INNER JOIN puesto p  ON hp.puesto = p.id '.                        
                        'WHERE c.id <> '.$idevaluador.' and c.estado = 1 ORDER BY c.apellido1;'
                        )->query();
            $return_array = array();            
            if($dataReader->count() == 0){
                    $return_array['value'] = 'error';
                    $return_array['mensaje'] = 'Ha ocurrido un inconveniente al intentar cargar masivamente los colaboradores. Intente nuevamente';                  
            }
            else{
                foreach($dataReader as $row){                         
                            $nombrecompleto = $row['nombre'].' '.$row['apellido1'].' '.$row['apellido2'];
                            $return_array[] = array(                       
                            'nombre'=>$nombrecompleto, 
                            'idcolaborador'=>$row['id'],
                            'cedula'=>$row['cedula'],   
                            'puesto'=>$row['puesto'],
                            'tipo'=>1,      //CLEAN CODE                  
                            );
                }
            }
            echo CJSON::encode($return_array);
        }
        
        public function actionCargaDepartamento(){
            $iddepartamento = CommonFunctions::stringtonumber($_POST['iddepartamento']);
            $idevaluador = CommonFunctions::stringtonumber($_POST['idevaluador']);
            
            $dataReader = Yii::app()->db->createCommand(
                        'SELECT c.cedula,c.nombre,c.apellido1,c.apellido2, c.id, p.nombre as "puesto" '.
                        'FROM colaborador c INNER JOIN historicopuesto hp on c.id = hp.colaborador and hp.puestoactual = 1 INNER JOIN puesto p  ON hp.puesto = p.id '.                        
                        'WHERE c.id <> '.$idevaluador.' and hp.unidadnegocio = '.$iddepartamento.' and c.estado = 1 ORDER BY c.apellido1;'
                        )->query();
            $return_array = array();            
            if($dataReader->count() == 0){
                    $return_array['value'] = 'error';
                    $return_array['mensaje'] = 'Ha ocurrido un inconveniente al intentar cargar los colaboradores de este departamento. 
                        No existen colaboradores para este departamento o el Evaluador es el único colaborador de este departamento';                  
            }
            else{
                foreach($dataReader as $row){                         
                            $nombrecompleto = $row['nombre'].' '.$row['apellido1'].' '.$row['apellido2'];
                            $return_array[] = array(                       
                            'nombre'=>$nombrecompleto, 
                            'idcolaborador'=>$row['id'],
                            'cedula'=>$row['cedula'],   
                            'puesto'=>$row['puesto'],
                            'tipo'=>1,      //CLEAN CODE                  
                            );
                }
            }
            echo CJSON::encode($return_array);
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
        
        public function actionCrearProcesoEC(){            
                        
            if(Yii::app()->request->isAjaxRequest)
            {               
                //VALORAR PONER UN VALIDADOR ISSET TANTO DE VARIABLES DEL PROCESO COMO DE COLABORADORES
                $nombreproceso = $_POST['nombreproceso'];
                $idevaluador = CommonFunctions::stringtonumber($_POST['idevaluador']);
                $periodo = CommonFunctions::stringtonumber($_POST['periodo']);         
                
                $procesoevaluacion = new Procesoevaluacion();                
                $procesoevaluacion->fecha = CommonFunctions::datenow(); 
                $procesoevaluacion->evaluador = $idevaluador;
                $procesoevaluacion->descripcion = $nombreproceso;
                $procesoevaluacion->tipo = 1; //MIGRAR VARIABLES GLOBALES CLEAN CODE
                $procesoevaluacion->periodo = $periodo;
                
                $transaction = Yii::app()->db->beginTransaction();
                
                $resultadoguardarbd = $procesoevaluacion->save();                
                               
                if($resultadoguardarbd){
                    foreach ($_POST['colaboradores'] as $index => $idcolaborador){
                            
                            $evaluacioncompetencias = new Evaluacioncompetencias();
                            $evaluacioncompetencias->procesoevaluacion = $procesoevaluacion->id;
                            $colaborador = Colaborador::model()->findByPk($idcolaborador);
                            $evaluacioncompetencias->puesto = $colaborador->getidpuestoactual(); //CLEAN CODE
                            $evaluacioncompetencias->colaborador = $colaborador->id;                            
                            $evaluacioncompetencias->save();

                            $link = new Links();
                            $link->url = $evaluacioncompetencias->id; //FALTA FUNCION HASH                          
                            $link->save();

                            $evaluacioncompetencias->links = $link->id;
                            $resultadoguardarbd =  $evaluacioncompetencias->save();
                            if(!$resultadoguardarbd){                    
                                    $transaction->rollback();
                                    $response = array('resultado' => false,'mensaje' => "Ha ocurrido un inconveniente al intentar guardar el proceso: ".$procesoevaluacion->descripcion);              
                                    echo CJSON::encode($response); 
                                    Yii::app()->end();
                            }
                    }                                    
                   $transaction->commit();
                   $response = array('resultado' => true,'mensaje' => "Se guardó con éxito el proceso: ".$procesoevaluacion->descripcion, 'url' => Yii::app()->getBaseUrl(true).'/index.php/procesoevaluacion/adminprocesoec/'.$procesoevaluacion->id);                  
                   echo CJSON::encode($response);   
                   Yii::app()->end();                                   
                }
                else{
                        $transaction->rollback();
                        $response = array('resultado' => false,'mensaje' => "Ha ocurrido un inconveniente al intentar guardar el proceso: ".$procesoevaluacion->descripcion);              
                        echo CJSON::encode($response);                        
                        Yii::app()->end();
                }           
            }
            
            $editar = false;
            $this->render('crearprocesoec',array(
			'indicadoreditar' => $editar,
            ));       
        }
        
        public function actionAdminProcesoEC($id){    
            
            $procesoec = Procesoevaluacion::model()->findByPk($id);
            $this->render('adminprocesoec',array(
			'procesoec'=>$procesoec,
            ));       
        }
        
        public function actionEditarProcesoEC($id){
            
            if(Yii::app()->request->isAjaxRequest)
            {                 
                $nombreproceso = $_POST['nombreproceso'];                
                $periodo = CommonFunctions::stringtonumber($_POST['periodo']); 
                $colaboradores = $_POST['colaboradores'];
                
                $procesoevaluacion = Procesoevaluacion::model()->findByPk($id);                
                $evaluacioncompetenciaactual = $procesoevaluacion->_evaluacionescompetencias;
                
                $transaction = Yii::app()->db->beginTransaction();                
                
                $procesoevaluacion->descripcion = $nombreproceso;
                $procesoevaluacion->periodo = $periodo;
                $resultadoguardarbd =  $procesoevaluacion->save();
                if(!$resultadoguardarbd){                    
                    $transaction->rollback();
                    $response = array('resultado' => false,'mensaje' => "Ha ocurrido un inconveniente al intentar guardar los cambios del proceso: ".$procesoevaluacion->descripcion);              
                    echo CJSON::encode($response); 
                    Yii::app()->end();
                }else{               
                
                    foreach ($colaboradores as $index => $idcolaborador) {                    
                        $indicadoragregarec = true;                                        
                        foreach ($evaluacioncompetenciaactual as $ec) {
                            if(CommonFunctions::stringtonumber($idcolaborador) == $ec->colaborador){                                                       
                               $indicadoragregarec = false; 
                               break 1;
                            }                        
                        }
                        if($indicadoragregarec){
                                $evaluacioncompetencias = new Evaluacioncompetencias();
                                $evaluacioncompetencias->procesoevaluacion = $procesoevaluacion->id;
                                $colaborador = Colaborador::model()->findByPk($idcolaborador);
                                $evaluacioncompetencias->puesto = $colaborador->getidpuestoactual(); //CLEAN CODE
                                $evaluacioncompetencias->colaborador = $colaborador->id;                            
                                $evaluacioncompetencias->save();

                                $link = new Links();
                                $link->url = $evaluacioncompetencias->id; //FALTA FUNCION HASH                          
                                $link->save();

                                $evaluacioncompetencias->links = $link->id;
                                $resultadoguardarbd =  $evaluacioncompetencias->save();
                                if(!$resultadoguardarbd){                    
                                        $transaction->rollback();
                                        $response = array('resultado' => false,'mensaje' => "Ha ocurrido un inconveniente al intentar guardar los cambios del proceso: ".$procesoevaluacion->descripcion);              
                                        echo CJSON::encode($response); 
                                        Yii::app()->end();
                                }
                        }
                    }
                    
                    foreach ($evaluacioncompetenciaactual as $ec){                    
                        $indicadorborrarec = true;                                        
                        foreach ($colaboradores as $index => $idcolaborador) {
                            if(CommonFunctions::stringtonumber($idcolaborador) == $ec->colaborador){                                                       
                               $indicadorborrarec = false; 
                               break 1;
                            }                        
                        }
                        if($indicadorborrarec){
                            $evaluacioncompetencias = Evaluacioncompetencias::model()->findByPk($ec->id);
                            $evaluacioncompetencias->estado = 0;//CLEAN CODE VARIABLES GLOBALES
                            $resultadoguardarbd =  $evaluacioncompetencias->save();
                            if(!$resultadoguardarbd){                    
                                    $transaction->rollback();
                                    $response = array('resultado' => false,'mensaje' => "Ha ocurrido un inconveniente al intentar guardar los cambios del proceso: ".$procesoevaluacion->descripcion);              
                                    echo CJSON::encode($response); 
                                    Yii::app()->end();
                            }
                        }
                    }
                }                
                
               $transaction->commit();
               $response = array('resultado' => true,'mensaje' => "Se guardó con éxito los cambios realizados al proceso: ".$procesoevaluacion->descripcion, 'url' => Yii::app()->getBaseUrl(true).'/index.php/procesoevaluacion/adminprocesoec/'.$procesoevaluacion->id);                  
               echo CJSON::encode($response);   
               Yii::app()->end();
            }
            
            $procesoec = Procesoevaluacion::model()->findByPk($id);
            $editar = true;
            $this->render('crearprocesoec',array(
			'procesoec'=>$procesoec,'indicadoreditar' => $editar,
            ));
            
        }
        
        public function actionEnvioCorreoEC(){
            
            if(Yii::app()->request->isAjaxRequest){
                 $id = CommonFunctions::stringtonumber($_POST['id']);                
                 $ec = Evaluacioncompetencias::model()->findByPk($id);
                 $idlink = $ec->links;
                 $link = Links::model()->findByPk($idlink);
                 $link->contadorenvios = $link->contadorenvios + 1;
                 $link->fechaultimoenvio = CommonFunctions::datenow();
                 $link->save();
                 
                 $response = array('url' => Yii::app()->getBaseUrl(true).'/index.php/procesoevaluacion/evaluarprocesoec/'.$id);               
                 echo CJSON::encode($response);                        
                 Yii::app()->end();
            }
        }
               
        public function actionEvaluarProcesoEC($id){
            
            $this->layout='column1';
            $ec = Evaluacioncompetencias::model()->findByPk($id);
            $puntaje = Puntaje::model()->obtenerpuntajesactivos();
            $this->render('evaluarprocesoec',array(
                            'ec'=>$ec,'puntaje'=>$puntaje));
        }
        
        public function actionGuardarEvaluacionEC() {

            if (Yii::app()->request->isAjaxRequest) {

                $idec = CommonFunctions::stringtonumber($_POST['idec']);
                $ec = Evaluacioncompetencias::model()->findByPk($idec);

                $assessmentcenter = ($_POST['ac']);

                $meritos = ($_POST['meritos']);
                $habilidades = ($_POST['habilidades']);

                //Determinar si hay necesidad de guardar habilidadesnoequivalentes
                if (isset($_POST['habilidadesnoequivalentes'])){
                    $habilidadesnoequivalentes = ($_POST['habilidadesnoequivalentes']);
                    $indicadorhabilidadesnoequivalentes = true;
                }
                else{
                    $indicadorhabilidadesnoequivalentes = false;
                }
                
                if ($assessmentcenter['indicadorac'] == "true") {
                    $calificacionac = CommonFunctions::stringtonumber($assessmentcenter['calificacionac']); 
                    $calificacionec = $ec->calificacionec($meritos, $habilidades, $calificacionac, true);
//                    $promedioecac = $ec->promedioecac($calificacionec);
//                    $promedioac = $ec->promedioac($calificacionac); 
//                    $promedioponderado = $ec->promedioponderadoacec($promedioecac, $promedioac);
                    $ec->eccalificacion = $calificacionec;
                    $ec->accalificacion = $calificacionac;
//                    $ec->promedioac = $promedioac;// Esto esta repetido con acalificacion
                    $ec->acdetalle = $assessmentcenter['detalleac'];
                    $ec->acindicador = 1; //CLEAN CODE - PONER EN VARIABLES GLOBALES
//                    $ec->promedioec = $promedioecac;    // Esto esta repetido con ecalificacion               
                    $ec->promedioponderado = $calificacionec;
                }
                else{
                    $calificacionec = $ec->calificacionec($meritos, $habilidades, 0, false);
                    $ec->eccalificacion = $calificacionec;
                    $ec->promedioec = $calificacionec;                    
                    $ec->promedioponderado = $calificacionec;
                }
                $ec->estado = 2; //CLEAN CODE - PONER EN VARIABLES GLOBALES
                $ec->fechaevaluacion = CommonFunctions::datenow();               
                
                $link = Links::model()->findByPk($ec->links);
                $link->estado = 0;                
                
                //FALTA VALIDAR SI SE DEBE PASAR EL PROCESO A TERMINADO, SI SOLO SI ES LA ULTIMA EVALUACION ACTIVA DEL PROCESO

                $transaction = Yii::app()->db->beginTransaction();
                
                $resultadoguardarbdlink = $link->save();
                $resultadoguardarbd = $ec->save();
                if ($resultadoguardarbd && $resultadoguardarbdlink) {
                    
                    foreach ($meritos as $merito) {
                        $meritoevaluacioncandidato = new Meritoevaluacioncandidato();
                        $meritoevaluacioncandidato->evaluacioncandidato = $ec->id;
                        $meritoevaluacioncandidato->merito = CommonFunctions::stringtonumber($merito["idmerito"]);
                        $meritoevaluacioncandidato->calificacion = CommonFunctions::stringtonumber($merito["calificacionmerito"]);
                        $meritoevaluacioncandidato->ponderacion = CommonFunctions::stringtonumber($merito["ponderacion"]);
                        $resultadoguardarbd = $meritoevaluacioncandidato->save();
                        if (!$resultadoguardarbd) {
                            $transaction->rollback();
                            $response = array('resultado' => false, 'mensaje' => "Ha ocurrido un inconveniente al intentar guardar la Evaluacion Competencias Id: " . $ec->id);
                            echo CJSON::encode($response);
                            Yii::app()->end();
                        }
                    }
                    
                    foreach ($habilidades as $habilidad) {
                        $habilidadevaluacioncandidato = new Habilidadevaluacioncandidato();
                        $habilidadevaluacioncandidato->evaluacioncandidato = $ec->id;
                        if ($habilidad["tipohabilidad"] == "core") { //CLEAN CODE COLOCAR EN VARIABLES GLOBALES
                            if($assessmentcenter['indicadorac'] == "true"){
                                $calificacioncore = $habilidadevaluacioncandidato->actualizarcalificacioncoreac(CommonFunctions::stringtonumber($habilidad["calificacionhabilidad"]), CommonFunctions::stringtonumber($assessmentcenter['calificacionac']));
                                $habilidadevaluacioncandidato->calificacion = $calificacioncore;
                            } 
                            else
                                $habilidadevaluacioncandidato->calificacion = CommonFunctions::stringtonumber($habilidad["calificacionhabilidad"]);                   
                            $habilidadevaluacioncandidato->tipocompetencia = 1; //CLEAN CODE COLOCAR EN VARIABLES GLOBALES
                        } else {                            
                            $habilidadevaluacioncandidato->tipocompetencia = 2; //CLEAN CODE COLOCAR EN VARIABLES GLOBALES
                            $habilidadevaluacioncandidato->calificacion = CommonFunctions::stringtonumber($habilidad["calificacionhabilidad"]);
                        }       
                        $habilidadevaluacioncandidato->competencia = CommonFunctions::stringtonumber($habilidad["idhabilidad"]);
                        $habilidadevaluacioncandidato->ponderacion = CommonFunctions::stringtonumber($habilidad["ponderacion"]);
                        $habilidadevaluacioncandidato->metodo = $habilidad["metodoseleccionado"];
                        $habilidadevaluacioncandidato->variablemetodo = $habilidad["variableequivalente"];
                        $habilidadevaluacioncandidato->calificacionvariablemetodo = $habilidad["calificacionequivalente"];
                        $resultadoguardarbd = $habilidadevaluacioncandidato->save();
                        if (!$resultadoguardarbd) {
                            $transaction->rollback();
                            $response = array('resultado' => false, 'mensaje' => "Ha ocurrido un inconveniente al intentar guardar la Evaluacion Competencias Id: " . $ec->id);
                            echo CJSON::encode($response);
                            Yii::app()->end();
                        }
                    }

                    if ($indicadorhabilidadesnoequivalentes) {
                        foreach ($habilidadesnoequivalentes as $habilidadnoequivalente) {
                            $hnoequivalente = new Habilidadnoequivalente();
                            $hnoequivalente->evaluacioncandidato = $ec->id;
                            $hnoequivalente->competencia = CommonFunctions::stringtonumber($habilidadnoequivalente["competencia"]);
                            $hnoequivalente->calificacion = CommonFunctions::stringtonumber($habilidadnoequivalente["calificacionvariablenoquivalente"]);
                            $hnoequivalente->metodo = $habilidadnoequivalente["metodovariablenoquivalente"];
                            $hnoequivalente->variablemetodo = $habilidadnoequivalente["variablenoquivalente"];
                            $hnoequivalente->puestopotencial1 = CommonFunctions::stringtonumber($habilidadnoequivalente["puesto1"]);
                            $hnoequivalente->puestopotencial2 = CommonFunctions::stringtonumber($habilidadnoequivalente["puesto2"]);
                            $resultadoguardarbd = $hnoequivalente->save();
                            if (!$resultadoguardarbd) {
                                $transaction->rollback();
                                $response = array('resultado' => false, 'mensaje' => "Ha ocurrido un inconveniente al intentar guardar la Evaluacion Competencias Id: " . $ec->id);
                                echo CJSON::encode($response);
                                Yii::app()->end();
                            }
                        }
                    }

                    $transaction->commit();
                    $response = array('resultado' => true, 'mensaje' => "Se guardó con éxito la evaluacion", 'url' => Yii::app()->getBaseUrl(true) . '/index.php/procesoevaluacion/adminprocesoec/' . $ec->procesoevaluacion);
                    echo CJSON::encode($response);
                    Yii::app()->end();
                } else {
                    $transaction->rollback();
                    $response = array('resultado' => false, 'mensaje' => "Ha ocurrido un inconveniente al intentar guardar la Evaluacion Competencias Id: " . $ec->id);
                    echo CJSON::encode($response);
                    Yii::app()->end();
                }
            }
    }
    
        public function actionEliminarProcesoEC($id){            
             if (Yii::app()->request->isAjaxRequest) {
            
                $id = CommonFunctions::stringtonumber($id);
                $procesoec = Procesoevaluacion::model()->findByPk($id);
                $procesoec->estado = 0;
                $resultadoguardarbd = $procesoec->save();
                if($resultadoguardarbd)
                 $response = array('resultado' => true, 'mensaje' => "Se elimino correctamente el proceso.");
                else
                 $response = array('resultado' => false, 'mensaje' => "Ha ocurrido un inconveniente al intentar eliminar el proceso");
                
                echo CJSON::encode($response);
                Yii::app()->end();          
             }
        }
        
        public function actionHabilidadesEspeciales(){
            
            if (Yii::app()->request->isAjaxRequest)
            {
                $hashabilidades = true;
                $evaluacionpersonas = Evaluacionpersonas::model()->findByPk($_GET['id']);
                $habilidadesespeciales = $evaluacionpersonas->_habilidadesespecial;
                if(empty($habilidadesespeciales)){$hashabilidades = false;}
                $this->renderPartial('verhabilidadesespeciales', array('evaluacionpersonanombre' => $evaluacionpersonas->descripcion, 'habilidadesespeciales'=> $habilidadesespeciales, 'hashabilidades' => $hashabilidades),false,true);                
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
	public function actionDelete()
	{
		$evaluacionpersonas = $this->loadModel($_GET["id"]);
                $evaluacionpersonas->estado = 0;
                $resultado = $evaluacionpersonas->save();
                
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
            $ec = Procesoevaluacion::model()->obtenerevaluacioncompetencias();                
            $filtersForm=new FiltersForm;

            if (isset($_GET['FiltersForm']))
                $filtersForm->filters=$_GET['FiltersForm'];                
            
            $this->layout='column1';
            $this->render('admin',array(
                'ec' => $filtersForm->filter($ec),
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
                $idevaluacionpersonas = $evaluacioncompetencias->evaluacionpersonas;
                $datarelativo = $evaluacioncompetencias->obtenerGraficoSpiderRelativo($idevaluacioncompetencias, $idevaluacionpersonas);            
                $datacalificado = $evaluacioncompetencias->obtenerGraficoSpiderCalificado($idevaluacioncompetencias, $idevaluacionpersonas);
            
                $this->render('reporteevaluacioncompetencias',array(
                        'evaluacioncompetencias'=>$evaluacioncompetencias,
                        'relativo'=>$datarelativo,
                        'calificado'=>$datacalificado
		)); 
        }
        
        public function actionDataReporteEvaluacionCompetencias(){ 
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
            
            /*Logica de grafico Radar - Cobertura de Requisitos*/
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
           
        }   
        
         public function actionCrearReporteEC(){
           if(Yii::app()->request->isAjaxRequest){
           $id = CommonFunctions::stringtonumber($_POST['id']);                
           $ec = Evaluacioncompetencias::model()->findByPk($id); 
           $response = array('url' => Yii::app()->getBaseUrl(true).'/index.php/procesoevaluacion/reporteec/'.$id);               
           echo CJSON::encode($response);                        
           Yii::app()->end();
            }
        }
        
        public function actionReporteEC($id) {
                          
                $ec = Evaluacioncompetencias::model()->findByPk($id);  
                $colaborador = Colaborador::model()->findByPk($ec->colaborador);
                $competencias = $ec->_habilidadesevaluacioncandidato;
                $meritos = $ec->_meritosevaluacioncandidato;
                
              
               $phpExcelPath = Yii::getPathOfAlias('application.modules.excel');

               // Turn off our amazing library autoload 
               spl_autoload_unregister(array('YiiBase','autoload'));        

               require_once( dirname(__FILE__) . '/../components/CommonFunctions.php');
               require_once( dirname(__FILE__) . '/../models/Merito.php');
               require_once( dirname(__FILE__) . '/../models/Puesto.php');
               require_once( dirname(__FILE__) . '/../models/Colaborador.php');
               require_once( dirname(__FILE__) . '/../models/Procesoevaluacion.php');
               require_once( dirname(__FILE__) . '/../models/Competencia.php');
               require_once( dirname(__FILE__) . '/../models/Tipomerito.php');
               include($phpExcelPath . DIRECTORY_SEPARATOR . 'Classes'. DIRECTORY_SEPARATOR .'PHPExcel.php');                      

               $objReader = PHPExcel_IOFactory::createReader('Excel2007');
               $objReader->setIncludeCharts(TRUE);
               
               $styleTableBorder = array(
                 'borders'=>array(
                     'allborders'=>array(
                         'style'=> PHPExcel_Style_Border::BORDER_THIN,
                     )
                 ),
             );
               if (count($competencias) == 7) //Las 4 competencias CORE más 3 normales.
                {
                   if ($ec->acindicador == 0) {
                    $objPHPExcel = $objReader->load($phpExcelPath. DIRECTORY_SEPARATOR ."templates". DIRECTORY_SEPARATOR ."EvaluacionPorCompetenciasTemplate.xlsx");

                    $objPHPExcel->setActiveSheetIndex(0);  //set first sheet as active

                    $objPHPExcel->getActiveSheet()->setCellValue('C4', $ec->_colaborador->nombrecompleto); 
                    $objPHPExcel->getActiveSheet()->setCellValue('C5', $ec->_puesto->nombre);
                    $objPHPExcel->getActiveSheet()->setCellValue('G4', $ec->_colaborador->cedula);
                    $objPHPExcel->getActiveSheet()->setCellValue('G5', $ec->_procesoevaluacion->_evaluador->nombrecompleto);
                    $objPHPExcel->getActiveSheet()->setCellValue('G6', $ec->_procesoevaluacion->fecha);

                     $i = '35';  

                     foreach($meritos as $merito)
                     {

                          $objPHPExcel->setActiveSheetIndex(0)
                                 //->mergeCells('E'.$i.':F'.$i)
                                 ->setCellValue('B'.$i, $merito->_merito->_tipomerito->nombre)
                                 ->setCellValue('F'.$i, $merito->ponderacion)
                                  ->setCellValue('G'.$i, CommonFunctions::ponderaciontoideal($merito->ponderacion))
                                 ->setCellValue('H'.$i, $merito->calificacion);

                          $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(15);
                          $objPHPExcel->setActiveSheetIndex()->getStyle('B'.$i.':H'.$i)->applyFromArray($styleTableBorder);
                          $i++;

                     }

                     $j=$i;

                     foreach($competencias as $competencia)
                     {
                         $objPHPExcel->setActiveSheetIndex(0)
                                 //->mergeCells('E'.$j.':F'.$j)
                                 ->setCellValue('B'.$j, $competencia->_competencia->competencia)
                                 ->setCellValue('C'.$j, $competencia->variablemetodo)
                                 ->setCellValue('D'.$j, $competencia->metodo)
                                 ->setCellValue('E'.$j, $competencia->calificacionvariablemetodo)
                                 ->setCellValue('F'.$j, $competencia->ponderacion)
                                 ->setCellValue('G'.$j, CommonFunctions::ponderaciontoideal($competencia->ponderacion))
                                 ->setCellValue('H'.$j, $competencia->calificacion);

                          $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(15);
                          $objPHPExcel->setActiveSheetIndex()->getStyle('B'.$j.':H'.$j)->applyFromArray($styleTableBorder);
                          $j++;
                     }

                     $objPHPExcel->setActiveSheetIndex(0)
                             ->setCellValue('E49', $ec->promedioponderado); 
                    }

                    else {
                     $objPHPExcel = $objReader->load($phpExcelPath. DIRECTORY_SEPARATOR ."templates". DIRECTORY_SEPARATOR ."EvaluacionPorCompetenciasTemplate_AC.xlsx");

                     $objPHPExcel->setActiveSheetIndex(0);  //set first sheet as active

                     $objPHPExcel->getActiveSheet()->setCellValue('C4', $ec->_colaborador->nombrecompleto); 
                     $objPHPExcel->getActiveSheet()->setCellValue('C5', $ec->_puesto->nombre);
                     $objPHPExcel->getActiveSheet()->setCellValue('G4', $ec->_colaborador->cedula);
                     $objPHPExcel->getActiveSheet()->setCellValue('G5', $ec->_procesoevaluacion->_evaluador->nombrecompleto);
                     $objPHPExcel->getActiveSheet()->setCellValue('G6', $ec->_procesoevaluacion->fecha);
                     $objPHPExcel->getActiveSheet()->setCellValue('D34', $ec->accalificacion);
                     $objPHPExcel->getActiveSheet()->setCellValue('D35', $ec->acdetalle);

                      $i = '39';  

                      foreach($meritos as $merito)
                      {

                           $objPHPExcel->setActiveSheetIndex(0)
                                  //->mergeCells('E'.$i.':F'.$i)
                                  ->setCellValue('B'.$i, $merito->_merito->_tipomerito->nombre)
                                  ->setCellValue('F'.$i, $merito->ponderacion)
                                   ->setCellValue('G'.$i, CommonFunctions::ponderaciontoideal($merito->ponderacion))
                                  ->setCellValue('H'.$i, $merito->calificacion);

                           $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(15);
                           $objPHPExcel->setActiveSheetIndex()->getStyle('B'.$i.':H'.$i)->applyFromArray($styleTableBorder);
                           $i++;

                      }

                      $j=$i;

                      foreach($competencias as $competencia)
                      {
                          $objPHPExcel->setActiveSheetIndex(0)
                                  //->mergeCells('E'.$j.':F'.$j)
                                  ->setCellValue('B'.$j, $competencia->_competencia->competencia)
                                  ->setCellValue('C'.$j, $competencia->variablemetodo)
                                  ->setCellValue('D'.$j, $competencia->metodo)
                                  ->setCellValue('E'.$j, $competencia->calificacionvariablemetodo)
                                  ->setCellValue('F'.$j, $competencia->ponderacion)
                                  ->setCellValue('G'.$j, CommonFunctions::ponderaciontoideal($competencia->ponderacion))
                                  ->setCellValue('H'.$j, $competencia->calificacion);

                           $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(15);
                           $objPHPExcel->setActiveSheetIndex()->getStyle('B'.$j.':H'.$j)->applyFromArray($styleTableBorder);
                           $j++;
                      }

                      $objPHPExcel->setActiveSheetIndex(0)
                              ->setCellValue('E53', $ec->promedioponderado); 
                     }
                }
                else 
                {
                    if ($ec->acindicador == 0) {
                    $objPHPExcel = $objReader->load($phpExcelPath. DIRECTORY_SEPARATOR ."templates". DIRECTORY_SEPARATOR ."EvaluacionPorCompetenciasTemplate2.xlsx");

                    $objPHPExcel->setActiveSheetIndex(0);  //set first sheet as active

                    $objPHPExcel->getActiveSheet()->setCellValue('C4', $ec->_colaborador->nombrecompleto); 
                    $objPHPExcel->getActiveSheet()->setCellValue('C5', $ec->_puesto->nombre);
                    $objPHPExcel->getActiveSheet()->setCellValue('G4', $ec->_colaborador->cedula);
                    $objPHPExcel->getActiveSheet()->setCellValue('G5', $ec->_procesoevaluacion->_evaluador->nombrecompleto);
                    $objPHPExcel->getActiveSheet()->setCellValue('G6', $ec->_procesoevaluacion->fecha);

                     $i = '35';  

                     foreach($meritos as $merito)
                     {

                          $objPHPExcel->setActiveSheetIndex(0)
                                 //->mergeCells('E'.$i.':F'.$i)
                                 ->setCellValue('B'.$i, $merito->_merito->_tipomerito->nombre)
                                 ->setCellValue('F'.$i, $merito->ponderacion)
                                  ->setCellValue('G'.$i, CommonFunctions::ponderaciontoideal($merito->ponderacion))
                                 ->setCellValue('H'.$i, $merito->calificacion);

                          $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(15);
                          $objPHPExcel->setActiveSheetIndex()->getStyle('B'.$i.':H'.$i)->applyFromArray($styleTableBorder);
                          $i++;

                     }

                     $j=$i;

                     foreach($competencias as $competencia)
                     {
                         $objPHPExcel->setActiveSheetIndex(0)
                                 //->mergeCells('E'.$j.':F'.$j)
                                 ->setCellValue('B'.$j, $competencia->_competencia->competencia)
                                 ->setCellValue('C'.$j, $competencia->variablemetodo)
                                 ->setCellValue('D'.$j, $competencia->metodo)
                                 ->setCellValue('E'.$j, $competencia->calificacionvariablemetodo)
                                 ->setCellValue('F'.$j, $competencia->ponderacion)
                                 ->setCellValue('G'.$j, CommonFunctions::ponderaciontoideal($competencia->ponderacion))
                                 ->setCellValue('H'.$j, $competencia->calificacion);

                          $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(15);
                          $objPHPExcel->setActiveSheetIndex()->getStyle('B'.$j.':H'.$j)->applyFromArray($styleTableBorder);
                          $j++;
                     }

                     $objPHPExcel->setActiveSheetIndex(0)
                             ->setCellValue('E49', $ec->promedioponderado); 
                    }

                    else {
                     $objPHPExcel = $objReader->load($phpExcelPath. DIRECTORY_SEPARATOR ."templates". DIRECTORY_SEPARATOR ."EvaluacionPorCompetenciasTemplate_AC2.xlsx");

                     $objPHPExcel->setActiveSheetIndex(0);  //set first sheet as active

                     $objPHPExcel->getActiveSheet()->setCellValue('C4', $ec->_colaborador->nombrecompleto); 
                     $objPHPExcel->getActiveSheet()->setCellValue('C5', $ec->_puesto->nombre);
                     $objPHPExcel->getActiveSheet()->setCellValue('G4', $ec->_colaborador->cedula);
                     $objPHPExcel->getActiveSheet()->setCellValue('G5', $ec->_procesoevaluacion->_evaluador->nombrecompleto);
                     $objPHPExcel->getActiveSheet()->setCellValue('G6', $ec->_procesoevaluacion->fecha);
                     $objPHPExcel->getActiveSheet()->setCellValue('D34', $ec->accalificacion);
                     $objPHPExcel->getActiveSheet()->setCellValue('D35', $ec->acdetalle);

                      $i = '39';  

                      foreach($meritos as $merito)
                      {

                           $objPHPExcel->setActiveSheetIndex(0)
                                  //->mergeCells('E'.$i.':F'.$i)
                                  ->setCellValue('B'.$i, $merito->_merito->_tipomerito->nombre)
                                  ->setCellValue('F'.$i, $merito->ponderacion)
                                   ->setCellValue('G'.$i, CommonFunctions::ponderaciontoideal($merito->ponderacion))
                                  ->setCellValue('H'.$i, $merito->calificacion);

                           $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(15);
                           $objPHPExcel->setActiveSheetIndex()->getStyle('B'.$i.':H'.$i)->applyFromArray($styleTableBorder);
                           $i++;

                      }

                      $j=$i;

                      foreach($competencias as $competencia)
                      {
                          $objPHPExcel->setActiveSheetIndex(0)
                                  //->mergeCells('E'.$j.':F'.$j)
                                  ->setCellValue('B'.$j, $competencia->_competencia->competencia)
                                  ->setCellValue('C'.$j, $competencia->variablemetodo)
                                  ->setCellValue('D'.$j, $competencia->metodo)
                                  ->setCellValue('E'.$j, $competencia->calificacionvariablemetodo)
                                  ->setCellValue('F'.$j, $competencia->ponderacion)
                                  ->setCellValue('G'.$j, CommonFunctions::ponderaciontoideal($competencia->ponderacion))
                                  ->setCellValue('H'.$j, $competencia->calificacion);

                           $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(15);
                           $objPHPExcel->setActiveSheetIndex()->getStyle('B'.$j.':H'.$j)->applyFromArray($styleTableBorder);
                           $j++;
                      }

                      $objPHPExcel->setActiveSheetIndex(0)
                              ->setCellValue('E53', $ec->promedioponderado); 
                     }
                }
                
                   
                
                header('Content-Type: application/excel');
                header('Content-Disposition: attachment;filename="ReporteEC_'.$colaborador->nombrecompleto.'.xlsx"');
                header('Cache-Control: max-age=0');
                
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');             
                $objWriter->setIncludeCharts(TRUE);                        
                $objWriter->save('php://output');
                exit();
              
                       
        }
        
        public function actionReporteAnalisisEC($tiporeporte, $fechainicio, $fechafin, $tipoanalisis, $departamentos = array()){
            
       $datosreporte = Evaluacioncompetencias::model()->AnalisisEvaluacion($tiporeporte, $fechainicio, $fechafin, $tipoanalisis, $departamentos);
            
       $phpExcelPath = Yii::getPathOfAlias('application.modules.excel');

        // Turn off our amazing library autoload 
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        
        require_once( dirname(__FILE__) . '/../components/CommonFunctions.php');

        include($phpExcelPath . DIRECTORY_SEPARATOR . 'Classes' . DIRECTORY_SEPARATOR . 'PHPExcel.php');

        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        //$objReader->setIncludeCharts(TRUE);
            
            if($tiporeporte == "R"){//Informe resumido
            $objPHPExcel = $objReader->load($phpExcelPath . DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR . "BrechasResumidoECTemplate.xlsx");
            }
            else if($tiporeporte == "A"){//Informe ampliado
            $objPHPExcel = $objReader->load($phpExcelPath . DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR . "BrechasAmpliadoECTemplate.xlsx");    
            }
            

            $objPHPExcel->setActiveSheetIndex(0);  //set first sheet as active

            $objPHPExcel->getActiveSheet()->setCellValue('B4', CommonFunctions::datemysqltophp($fechainicio));
            $objPHPExcel->getActiveSheet()->setCellValue('B5', CommonFunctions::datemysqltophp($fechafin));
            
      
            
     
      if(!$datosreporte){
                 $objPHPExcel->setActiveSheetIndex(0)               
                    ->setCellValue('A6',"No se encontraron evaluaciones para estos departamentos.");
                 
                header('Content-Type: application/excel');
                header('Content-Disposition: attachment;filename="BrechasEC.xlsx"');
                header('Cache-Control: max-age=0');
      }else{
        $i = '8';  
        
        if($tiporeporte == "R"){//Informe resumido
            foreach ($datosreporte as $fila) {

                       $objPHPExcel->setActiveSheetIndex(0)               
                          ->setCellValue('A'.$i, $fila["cedula"])
                          ->setCellValue('B'.$i, $fila["colaborador"])
                          ->setCellValue('C'.$i, $fila["puesto"])
                          ->setCellValue('D'.$i, $fila["departamento"])
                          ->setCellValue('E'.$i, $fila["evaluador"])
                          ->setCellValue('F'.$i, $fila["periodo"])
                          ->setCellValue('G'.$i, $fila["descripcion"])
                          ->setCellValue('H'.$i, $fila["fechaevaluacion"])
                          ->setCellValue('I'.$i, $fila["promedioponderado"])
                          ->setCellValue('J'.$i, $fila["eccalificacion"])
                          ->setCellValue('K'.$i, $fila["acindicador"])
                          ->setCellValue('L'.$i, $fila["accalificacion"]);

                          $i++;
             }
            header('Content-Type: application/excel');
            header('Content-Disposition: attachment;filename="BrechasResumidoEC.xlsx"');
            header('Cache-Control: max-age=0');
         }
         else if($tiporeporte == "A"){//Informe ampliado
         
            foreach ($datosreporte as $fila) {

                       $objPHPExcel->setActiveSheetIndex(0)               
                          ->setCellValue('A'.$i, $fila["cedula"])
                          ->setCellValue('B'.$i, $fila["colaborador"])
                          ->setCellValue('C'.$i, $fila["puesto"])
                          ->setCellValue('D'.$i, $fila["departamento"])
                          ->setCellValue('E'.$i, $fila["evaluador"])
                          ->setCellValue('F'.$i, $fila["periodo"])
                          ->setCellValue('G'.$i, $fila["descripcion"])
                          ->setCellValue('H'.$i, $fila["fechaevaluacion"])
                          ->setCellValue('I'.$i, $fila["promedioponderado"])
                          ->setCellValue('J'.$i, $fila["competencia"])
                          ->setCellValue('K'.$i, $fila["calificacioncompetencia"]);                        

                          $i++;
             } 
             
            header('Content-Type: application/excel');
            header('Content-Disposition: attachment;filename="BrechasAmpliadoEC.xlsx"');
            header('Cache-Control: max-age=0');
         }
         
       }

        

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //$objWriter->setIncludeCharts(TRUE);                        
        $objWriter->save('php://output');
        
        exit();
        }
}
