<?php

class ProcesoEDController extends Controller {


    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
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
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('crear', 'report', 'update', 'admin', 'Admined', 'EliminarProcesoED','AdminEva', 'AgregarPersona', 'AutocompleteEvaluado', 'AgregarCompromisos',
                    'HabilidadesEspeciales', 'InfoPonderacion', 'delete', 'reporteevaluacioncompetencias', 'DataReporteEvaluacionCompetencias', 'CargaMasiva', 'CargaDepartamento',
                    'adminprocesoed', 'GuardarCompromisos', 'RegistrarEvaluacion', 'GuardarEvaluacionED', 'ActualizarCalificacionED', 'CrearReporteED', 'ReporteED'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    
    public function actionAdminProcesoED($id) {

        $procesoed = Procesoevaluacion::model()->findByPk($id);
        $this->render('adminprocesoed', array(
            'procesoed' => $procesoed,
        ));
    }
    
    public function actionEliminarProcesoED($id){            
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

    public function actionAdminED($id) {

        $procesoed = Procesoevaluacion::model()->findByAttributes(array('id' => $id, 'tipo' => 2));

        if (isset($procesoed)) {
            $this->render('admined', array(
                'evaluacion' => $procesoed,
            ));
        }
        else
            $this->redirect(array('admin'));
    }

    public function actionAdminEva($id) {
        $procesoevaluacion = Procesoevaluacion::model()->find('id=' . $id . ' AND tipo=2');

        if (isset($procesoevaluacion)) {
            $evaluaciones = new CActiveDataProvider('evaluaciondesempeno', array('criteria' => array(
                            'condition' => 'procesoevaluacion=' . $id)));

            $this->render('admineva', array(
                'model' => $procesoevaluacion, 'evaluaciones' => $evaluaciones
            ));
        }
        else
            $this->redirect(array('admineva'));
    }

    public function actionAgregarCompromisos($id) {
        $ed = Evaluaciondesempeno::model()->findByPk($id);

        if (isset($ed)) {
            $this->layout = 'column1';
            $this->render('agregarcompromisos', array(
                'ed' => $ed
            ));
        }
    }

    public function actionGuardarCompromisos() {

        if (Yii::app()->request->isAjaxRequest) {

            if (isset($_POST['ided']) && isset($_POST['fecha']) && isset($_POST['compromisos'])) {

                $ided = $_POST['ided'];
                $evaluacion = Evaluaciondesempeno::model()->findByPk($ided);


                $evaluacion->fecharegistrocompromiso = CommonFunctions::datephptomysql(date('d-m-Y'));
                $evaluacion->fechaevaluacion = CommonFunctions::datephptomysql($_POST['fecha']);

                if (isset($_POST['comentario']))
                    $evaluacion->comentariocompromisos = trim($_POST['comentario']);

                $transaction = Yii::app()->db->beginTransaction();

                $result = $evaluacion->save();

                if ($result) {
                    $idevaluacion = $evaluacion->id;
                     foreach ($_POST['compromisos'] as $compromiso) { 
                        $nuevocompromiso = new Compromiso;
                        $nuevocompromiso->evaluacion = $idevaluacion;
                        $nuevocompromiso->puntualizacion = $compromiso['idPuntualizacion'];
                        $nuevocompromiso->compromiso = $compromiso['compromiso'];
                        $result = $nuevocompromiso->save();
                    }
                    if ($result) {
                        $transaction->commit();
                        $response = array('resultado' => true, 'mensaje' => "Se ha ingresado correctamente los compromisos del colaborador", 'url' => Yii::app()->getBaseUrl(true) . '/index.php/procesoed/adminprocesoed/' . $evaluacion->procesoevaluacion);
                        echo CJSON::encode($response);
                        Yii::app()->end();
                    } else {
                        $transaction->rollBack();
                        $response = array('resultado' => false, 'mensaje' => "Lo sentimos, ha ocurrido un problema al intentar guardar los compromisos del colaborador");
                        echo CJSON::encode($response);
                        Yii::app()->end();
                    }
                } else {
                    $transaction->rollBack();
                    $response = array('resultado' => false, 'mensaje' => "Lo sentimos, ha ocurrido un problema al intentar guardar los compromisos del colaborador");
                    echo CJSON::encode($response);
                    Yii::app()->end();
                }
            }
        }
    }

    public function actionRegistrarEvaluacion($id) {

        $ed = Evaluaciondesempeno::model()->findByPk($id);

        if (isset($ed)) {
            $this->layout = 'column1';
            $this->render('registrarevaluacion', array(
                'ed' => $ed
            ));
        }
    }

    //Logica para guarda la Evaluacion de ED
    public function actionGuardarEvaluacionED() {
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['ided']) && isset($_POST['puntualizaciones']) && isset($_POST['competencias'])) {

                $ided = $_POST['ided'];
                $ed = Evaluaciondesempeno::model()->findByPk($ided);

                $ed->fecharegistroevaluacion = CommonFunctions::datephptomysql(date('d-m-Y'));
                if (isset($_POST['comentario']))
                    $ed->comentarioevaluacion = trim($_POST['comentario']);

                $calificacionPuntualizaciones = $ed->calificacionPuntualizaciones($_POST['puntualizaciones']);
                $calificacionCompetencias = $ed->calificacionCompetencias($_POST['competencias']);
                $calificacionED = $ed->califacionED($calificacionPuntualizaciones, $calificacionCompetencias);

                $ed->promediocompromisos = $calificacionPuntualizaciones;
                $ed->promediocompetencias = $calificacionCompetencias;
                $ed->promedioevaluacion = $calificacionED;

                $ed->cambiarEDFinalizada();

                $transaction = Yii::app()->db->beginTransaction();

                $result = $ed->save();

                if ($result) {

                    //Logica para almacenar puntaje de los Compromisos                       
                    foreach ($_POST['puntualizaciones'] as $compromiso) {
                        $editarCompromiso = Compromiso::model()->findByPk($compromiso['idcompromiso']);
                        $editarCompromiso->puntaje = CommonFunctions::stringtonumber($compromiso['calificacion']);
                        $result = $editarCompromiso->save();
                    }

                    if ($result) {

                        $ided = $ed->id;

                        //Logica para almacenar puntaje de los Competencias 
                        foreach ($_POST['competencias'] as $competencia) {
                            $nuevacompetencia = new Calificacioncompetencia;
                            $nuevacompetencia->evaluacion = $ided;
                            $nuevacompetencia->competencia = $competencia['idcompetencia'];
                            $nuevacompetencia->puntaje = $competencia['calificacion'];
                            if($competencia['tipocompetencia'] == "core")
                                $nuevacompetencia->tipocompetencia = 1;
                            else
                                $nuevacompetencia->tipocompetencia = 2;
                            $nuevacompetencia->ponderacion = $competencia['ponderacion'];
                            $result = $nuevacompetencia->save();
                        }
                        if ($result) {
                            $transaction->commit();
                            $response = array('resultado' => true, 'mensaje' => "Se ha registrado correctamente la evaluacion", 'url' => Yii::app()->getBaseUrl(true) . '/index.php/procesoed/adminprocesoed/' . $ed->procesoevaluacion);
                            echo CJSON::encode($response);
                            Yii::app()->end();
                        } else {
                            $transaction->rollBack();
                            $response = array('resultado' => false, 'mensaje' => "Lo sentimos, ha ocurrido un problema al intentar guardar la evaluacion");
                            echo CJSON::encode($response);
                        }
                    } else {
                        $transaction->rollBack();
                        $response = array('resultado' => false, 'mensaje' => "Lo sentimos, ha ocurrido un problema al intentar guardar la evaluacion");
                        echo CJSON::encode($response);
                    }
                } else {
                    $transaction->rollBack();
                    $response = array('resultado' => false, 'mensaje' => "Lo sentimos, ha ocurrido un problema al intentar guardar la evaluacion");
                    echo CJSON::encode($response);
                }
            }
        }
    }

    //Realiza lo logica para devolver las calificaciones cada vez que el usuario califica una
    //puntualizacion o competencia
    public function actionActualizarCalificacionED() {
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['puntualizaciones']) && isset($_POST['competencias'])) {

                $ed = new Evaluaciondesempeno;
                $calificacionPuntualizaciones = $ed->calificacionPuntualizaciones($_POST['puntualizaciones']);
                $calificacionCompetencias = $ed->calificacionCompetencias($_POST['competencias']);
                $calificacionED = $ed->califacionED($calificacionPuntualizaciones, $calificacionCompetencias);

                $response = array('puntualizaciones' => $calificacionPuntualizaciones,
                    'competencias' => $calificacionCompetencias,
                    'ed' => $calificacionED
                );
                echo CJSON::encode($response);
                Yii::app()->end();
            }
        }
    }

    public function actionAutocompleteEvaluado() {
        if (isset($_GET['term'])) {

            $keyword = $_GET['term'];
            // escape % and _ characters
            $keyword = strtr($keyword, array('%' => '\%', '_' => '\_'));

            $dataReader = Yii::app()->db->createCommand(
                            'SELECT c.cedula,c.nombre,c.apellido1,c.apellido2, c.id, p.nombre as "puesto" ' .
                            'FROM colaborador c INNER JOIN historicopuesto hp on c.id = hp.colaborador and hp.puestoactual = 1 INNER JOIN puesto p  ON hp.puesto = p.id ' .
                            'WHERE CONCAT_WS(" ", c.nombre, c.apellido1, c.apellido2 ) like "%' . $keyword . '%" AND c.estado = 1;'
                    )->query();

            $return_array = array();
            if ($dataReader->count() == 0) {
                $return_array[] = array(
                    'label' => 'No hay resultados.',
                    'value' => '',
                );
            } else {
                foreach ($dataReader as $row) {

                    $nombrecompleto = $row['nombre'] . ' ' . $row['apellido1'] . ' ' . $row['apellido2'];
                    $return_array[] = array(
                        'label' => '<div style="font-size:x-small">Puesto: ' . $row['puesto'] . '</div>' . '<div>' . $nombrecompleto . '</div>',
                        'value' => $nombrecompleto,
                        'id' => $row['id'],
                        'cedula' => $row['cedula'],
                        'puesto' => $row['puesto'],
                        'tipo' => 1,
                    );
                }
            }
            echo CJSON::encode($return_array);
        }
    }

    public function actionCrear() {

        if (Yii::app()->request->isAjaxRequest) {
            //VALORAR PONER UN VALIDADOR ISSET TANTO DE VARIABLES DEL PROCESO COMO DE COLABORADORES
            $nombreproceso = $_POST['nombreproceso'];
            $idevaluador = CommonFunctions::stringtonumber($_POST['idevaluador']);
            $periodo = $_POST['periodo'];
            $evaluados = $_POST['colaboradores'];

            $procesoevaluacion = new Procesoevaluacion();

            $procesoevaluacion->fecha = CommonFunctions::datenow();
            $procesoevaluacion->evaluador = $idevaluador;
            $procesoevaluacion->descripcion = $nombreproceso;
            $procesoevaluacion->estado = 1;
            $procesoevaluacion->tipo = 2; //MIGRAR VARIABLES GLOBALES CLEAN CODE
            $procesoevaluacion->periodo = $periodo;

            $transaction = Yii::app()->db->beginTransaction();

            $resultadoguardarbd = $procesoevaluacion->save();


            if ($resultadoguardarbd) {
                foreach ($evaluados as $index => $idcolaborador) {

                    //ERROR
                    $evaluaciondesempeno = new Evaluaciondesempeno();
                    $evaluaciondesempeno->procesoevaluacion = $procesoevaluacion->id;
                    $colaborador = Colaborador::model()->findByPk($idcolaborador);
                    $evaluaciondesempeno->puesto = $colaborador->getidpuestoactual(); //CLEAN CODE
                    $evaluaciondesempeno->colaborador = $colaborador->id;
                    $evaluaciondesempeno->save();

                    $link = new Links();
                    $link->url = $evaluaciondesempeno->id; //FALTA FUNCION HASH                          
                    $link->save();

                    $evaluaciondesempeno->links = $link->id;
                    $resultadoguardarbd = $evaluaciondesempeno->save();
                    if (!$resultadoguardarbd) {
                        $transaction->rollback();
                        $response = array('resultado' => false, 'mensaje' => "Ha ocurrido un inconveniente al intentar guardar el proceso: " . $procesoevaluacion->descripcion);
                        echo CJSON::encode($response);
                        Yii::app()->end();
                    }
                }
                $transaction->commit();
                $response = array('resultado' => true, 'mensaje' => "Se guardó con éxito el proceso: " . $procesoevaluacion->descripcion, 'url' => Yii::app()->getBaseUrl(true) . '/index.php/procesoed/adminprocesoed/' . $procesoevaluacion->id);
                echo CJSON::encode($response);
                Yii::app()->end();
            } else {
                $transaction->rollback();
                $response = array('resultado' => false, 'mensaje' => "Ha ocurrido un inconveniente al intentar guardar el proceso: " . $procesoevaluacion->descripcion);
                echo CJSON::encode($response);
                Yii::app()->end();
            }
        }


        $this->render('crear', array(
            'indicadoreditar' => false,
        ));
    }

    public function actionHabilidadesEspeciales() {

        if (Yii::app()->request->isAjaxRequest) {
            $hashabilidades = true;
            $procesoevaluacion = Procesoevaluacion::model()->findByPk($_GET['id']);
            $habilidadesespeciales = $procesoevaluacion->_habilidadesespecial;
            if (empty($habilidadesespeciales)) {
                $hashabilidades = false;
            }
            $this->renderPartial('verhabilidadesespeciales', array('procesoevaluacionnombre' => $procesoevaluacion->descripcion, 'habilidadesespeciales' => $habilidadesespeciales, 'hashabilidades' => $hashabilidades), false, true);
            echo CHtml::script('$("#dlghabilidadesespeciales").dialog("open")');
            Yii::app()->end();
        }
    }
    
    //Logica para Generar el Reporte de ED
     public function actionCrearReporteED(){
           if(Yii::app()->request->isAjaxRequest){
           $id = CommonFunctions::stringtonumber($_POST['id']);                           
           $response = array('url' => Yii::app()->getBaseUrl(true).'/index.php/procesoed/reporteed/'.$id);               
           echo CJSON::encode($response);                        
           Yii::app()->end();
            }
        }
        
     public function actionReporteED($id) {
                          
                $id = 4; //Para Pruebas, Debe Adapartarse para ED
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

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['procesoevaluacion'])) {
            $model->attributes = $_POST['procesoevaluacion'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete() {
        $procesoevaluacion = $this->loadModel($_GET["id"]);
        $procesoevaluacion->estado = 0;
        $resultado = $procesoevaluacion->save();

        if ($resultado) {
            echo 'Exito';
        } else {
            echo 'Fallo';
        }

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $this->redirect('admin');
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $ec = Procesoevaluacion::model()->obtenerevaluaciondesempeno();
        $filtersForm = new FiltersForm;

        if (isset($_GET['FiltersForm']))
            $filtersForm->filters = $_GET['FiltersForm'];

        $this->layout = 'column1';
        $this->render('admin', array(
            'ec' => $filtersForm->filter($ec),
            'filtersForm' => $filtersForm,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Procesoevaluacion::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'procesoevaluacion-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public static function gridmysqltophpdate($date) {
        return CommonFunctions::datemysqltophp($date);
    }

    public static function gridestado($estado) {
        switch ($estado) {
            case 1:
                return "En proceso";
                break;
            case 2:
                return "Finalizado";
                break;
        }
    }

    public function actionInfoPonderacion() {
        $criterio = new CDbCriteria();
        $criterio->addColumnCondition(array('estado' => '1'));
        $ponderaciones = Ponderacion::model()->findAll($criterio);
        $html = '';
        $html .= '<div>';
        $html .= '<h4 style="text-align:center">Interpretación de la escala de ponderación.</h4>';
        $html .= '<ul>';
        foreach ($ponderaciones as $ponderacion) {
            $html .= '<li>Ponderación: ' . $ponderacion->valor . ' = ' . $ponderacion->descripcion . '</li>';
        }
        $html .= '</ul>';
        $html .= '</div>';
        $response = array('html' => $html);
        echo CJSON::encode($response);
        Yii::app()->end();
    }

    public function actionReporteEvaluacionCompetencias() {

        $this->layout = 'main';
        $idevaluacioncompetencias = $_GET['idevaluacioncompetencias'];
        $evaluacioncompetencias = Evaluacioncompetencias::model()->findByPk($idevaluacioncompetencias);
        $idprocesoevaluacion = $evaluacioncompetencias->procesoevaluacion;
        $datarelativo = $evaluacioncompetencias->obtenerGraficoSpiderRelativo($idevaluacioncompetencias, $idproceosevaluacion);
        $datacalificado = $evaluacioncompetencias->obtenerGraficoSpiderCalificado($idevaluacioncompetencias, $idprocesoevaluacion);

        $this->render('reporteevaluacioncompetencias', array(
            'evaluacioncompetencias' => $evaluacioncompetencias,
            'relativo' => $datarelativo,
            'calificado' => $datacalificado
        ));
    }

    public function actionReport() {
        $phpExcelPath = Yii::getPathOfAlias('application.modules.excel');

        // Turn off our amazing library autoload 
        spl_autoload_unregister(array('YiiBase', 'autoload'));

        include($phpExcelPath . DIRECTORY_SEPARATOR . 'Classes' . DIRECTORY_SEPARATOR . 'PHPExcel.php');

        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objReader->setIncludeCharts(TRUE);
        $objPHPExcel = $objReader->load($phpExcelPath . DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR . "EvaluacionPorCompetenciasTemplate.xlsx");




        $objPHPExcel->setActiveSheetIndex(0);  //set first sheet as active

        $objPHPExcel->getActiveSheet()->setCellValue('E4', 'prueba');
        $objPHPExcel->getActiveSheet()->setCellValue('I34', '4');
        $objPHPExcel->getActiveSheet()->setCellValue('I35', '3');






        header('Content-Type: application/excel');
        header('Content-Disposition: attachment;filename="test.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');

        //spl_autoload_register(array('YiiBase','autoload'));
    }

    ///Replicado

    public function actionCargaMasiva() {
        $idevaluador = CommonFunctions::stringtonumber($_POST['idevaluador']);
        $dataReader = Yii::app()->db->createCommand(
                        'SELECT c.cedula,c.nombre,c.apellido1,c.apellido2, c.id, p.nombre as "puesto" ' .
                        'FROM colaborador c INNER JOIN historicopuesto hp on c.id = hp.colaborador and hp.puestoactual = 1 INNER JOIN puesto p  ON hp.puesto = p.id ' .
                        'WHERE c.id <> ' . $idevaluador . ' and c.estado = 1 ORDER BY c.apellido1;'
                )->query();
        $return_array = array();
        if ($dataReader->count() == 0) {
            $return_array['value'] = 'error';
            $return_array['mensaje'] = 'Ha ocurrido un inconveniente al intentar cargar masivamente los colaboradores. Intente nuevamente';
        } else {
            foreach ($dataReader as $row) {
                $nombrecompleto = $row['nombre'] . ' ' . $row['apellido1'] . ' ' . $row['apellido2'];
                $return_array[] = array(
                    'nombre' => $nombrecompleto,
                    'idcolaborador' => $row['id'],
                    'cedula' => $row['cedula'],
                    'puesto' => $row['puesto'],
                    'tipo' => 1, //CLEAN CODE                  
                );
            }
        }
        echo CJSON::encode($return_array);
    }

    public function actionCargaDepartamento() {
        $iddepartamento = CommonFunctions::stringtonumber($_POST['iddepartamento']);
        $idevaluador = CommonFunctions::stringtonumber($_POST['idevaluador']);

        $dataReader = Yii::app()->db->createCommand(
                        'SELECT c.cedula,c.nombre,c.apellido1,c.apellido2, c.id, p.nombre as "puesto" ' .
                        'FROM colaborador c INNER JOIN historicopuesto hp on c.id = hp.colaborador and hp.puestoactual = 1 INNER JOIN puesto p  ON hp.puesto = p.id ' .
                        'WHERE c.id <> ' . $idevaluador . ' and hp.unidadnegocio = ' . $iddepartamento . ' and c.estado = 1 ORDER BY c.apellido1;'
                )->query();
        $return_array = array();
        if ($dataReader->count() == 0) {
            $return_array['value'] = 'error';
            $return_array['mensaje'] = 'Ha ocurrido un inconveniente al intentar cargar los colaboradores de este departamento. 
                        No existen colaboradores para este departamento o el Evaluador es el único colaborador de este departamento';
        } else {
            foreach ($dataReader as $row) {
                $nombrecompleto = $row['nombre'] . ' ' . $row['apellido1'] . ' ' . $row['apellido2'];
                $return_array[] = array(
                    'nombre' => $nombrecompleto,
                    'idcolaborador' => $row['id'],
                    'cedula' => $row['cedula'],
                    'puesto' => $row['puesto'],
                    'tipo' => 1, //CLEAN CODE                  
                );
            }
        }
        echo CJSON::encode($return_array);
    }

///FIN REPLICADO


    public function actionRegistrarCompromisosED() {

        if (Yii::app()->request->isAjaxRequest) {
            $id = CommonFunctions::stringtonumber($_POST['id']);
            $ed = Evaluaciondesempeno::model()->findByPk($id);
            $idlink = $ed->links;
            $link = Links::model()->findByPk($idlink);
            $link->contadorenvios = $link->contadorenvios + 1;
            $link->fechaultimoenvio = CommonFunctions::datenow();
            $link->save();

            $response = array('url' => Yii::app()->getBaseUrl(true) . '/index.php/procesoevaluacion/AgregarCompromisos/' . $id);
            echo CJSON::encode($response);
            Yii::app()->end();
        }
    }

}
