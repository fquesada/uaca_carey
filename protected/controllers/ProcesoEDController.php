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
                'actions' => array('crear', 'editar', 'report', 'update', 'admin', 'Admined', 'EliminarProcesoED', 'AdminEva', 'AgregarPersona', 'AutocompleteEvaluado', 'AgregarCompromisos',
                    'HabilidadesEspeciales', 'InfoPonderacion', 'delete', 'reporteevaluacioncompetencias', 'DataReporteEvaluacionCompetencias', 'CargaMasiva', 'CargaDepartamento',
                    'adminprocesoed', 'GuardarCompromisos', 'RegistrarEvaluacion', 'GuardarEvaluacionED', 'ActualizarCalificacionED', 'CrearReporteED', 'ReporteED', 'CrearReporteCompromisos', 'ReporteCompromisos',
                    'DescargaCompromisos', 'ReporteAnalisisED'),
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

    public function actionEliminarProcesoED($id) {
        if (Yii::app()->request->isAjaxRequest) {

            $id = CommonFunctions::stringtonumber($id);
            $procesoec = Procesoevaluacion::model()->findByPk($id);
            $procesoec->estado = 0;
            $resultadoguardarbd = $procesoec->save();
            if ($resultadoguardarbd)
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
                        //$response = array('resultado' => true, 'mensaje' => "Se ha ingresado correctamente los compromisos del colaborador", 'url' => Yii::app()->getBaseUrl(true) . '/index.php/procesoed/descargacompromisos/' . $evaluacion->id);
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
                            if ($competencia['tipocompetencia'] == "core")
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

        $this->render('crear');
    }

    public function actionEditar($id) {
        if (Yii::app()->request->isAjaxRequest) {
            
            $nombreproceso = $_POST['nombreproceso'];
            $periodo = CommonFunctions::stringtonumber($_POST['periodo']);
            $colaboradores = $_POST['colaboradores'];

            $procesoevaluacion = Procesoevaluacion::model()->findByPk($id);
            
            $evaluaciondesempenoactual = $procesoevaluacion->_evaluaciondesempenos;

            $transaction = Yii::app()->db->beginTransaction();

            $procesoevaluacion->descripcion = $nombreproceso;
            $procesoevaluacion->periodo = $periodo;
            $resultadoguardarbd = $procesoevaluacion->save();
            
            if (!$resultadoguardarbd) {
                $transaction->rollback();
                $response = array('resultado' => false, 'mensaje' => "Ha ocurrido un inconveniente al intentar guardar los cambios del proceso: " . $procesoevaluacion->descripcion);
                echo CJSON::encode($response);
                Yii::app()->end();
            } else {

                foreach ($colaboradores as $index => $idcolaborador) {
                    $indicadoragregared = true;
                    foreach ($evaluaciondesempenoactual as $ed) {
                        if (CommonFunctions::stringtonumber($idcolaborador) == $ed->colaborador) {
                            $indicadoragregared = false;
                            break 1;
                        }
                    }
                    if ($indicadoragregared) {
                        $evaluaciondesempeno = new Evaluaciondesempeno();
                        $evaluaciondesempeno->procesoevaluacion = $procesoevaluacion->id;
                        $colaborador = Colaborador::model()->findByPk($idcolaborador);
                        $evaluaciondesempeno->puesto = $colaborador->getidpuestoactual();//CLEAN CODE
                        $evaluaciondesempeno->colaborador = $colaborador->id;
                        $evaluaciondesempeno->save();

                        $link = new Links();
                        $link->url = $evaluaciondesempeno->id; //FALTA FUNCION HASH                          
                        $link->save();

                        $evaluaciondesempeno->links = $link->id;
                        $resultadoguardarbd = $evaluaciondesempeno->save();
                        if (!$resultadoguardarbd) {
                            $transaction->rollback();
                            $response = array('resultado' => false, 'mensaje' => "Ha ocurrido un inconveniente al intentar guardar los cambios del proceso: " . $procesoevaluacion->descripcion);
                            echo CJSON::encode($response);
                            Yii::app()->end();
                        }
                    }
                }

                foreach ($evaluaciondesempenoactual as $ed) {
                    $indicadorborrared = true;
                    foreach ($colaboradores as $index => $idcolaborador) {
                        if (CommonFunctions::stringtonumber($idcolaborador) == $ed->colaborador) {
                            $indicadorborrared = false;
                            break 1;
                        }
                    }
                    if ($indicadorborrared) {
                        $evaluaciondesempenoborrar = Evaluaciondesempeno::model()->findByPk($ed->id);
                        $evaluaciondesempenoborrar->estado = 0; //CLEAN CODE VARIABLES GLOBALES
                        $resultadoguardarbd = $evaluaciondesempenoborrar->save();
                        if (!$resultadoguardarbd) {
                            $transaction->rollback();
                            $response = array('resultado' => false, 'mensaje' => "Ha ocurrido un inconveniente al intentar guardar los cambios del proceso: " . $procesoevaluacion->descripcion);
                            echo CJSON::encode($response);
                            Yii::app()->end();
                        }
                    }
                }
            }

            $transaction->commit();
            $response = array('resultado' => true, 'mensaje' => "Se guardó con éxito los cambios realizados al proceso: " . $procesoevaluacion->descripcion, 'url' => Yii::app()->getBaseUrl(true) . '/index.php/procesoed/adminprocesoed/' . $procesoevaluacion->id);
            echo CJSON::encode($response);
            Yii::app()->end();
        }

        $proceso = Procesoevaluacion::model()->findByPk($id);
        $this->render('editar', array(
            'proceso' => $proceso,
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

    public function actionDescargaCompromisos($id) {

        $this->render('DescargaCompromisos', array(
            'id' => $id,
        ));

        //$this->redirect($this->createUrl('ReporteCompromisos', array('id'=>$id)));
    }

    //Logica para Generar el Reporte de Compromisos
    public function actionCrearReporteCompromisos() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = CommonFunctions::stringtonumber($_POST['id']);
            $response = array('url' => Yii::app()->getBaseUrl(true) . '/index.php/procesoed/reportecompromisos/' . $id);
            echo CJSON::encode($response);
            Yii::app()->end();
        }
    }

    public function actionReporteCompromisos($id) {
        $ed = Evaluaciondesempeno::model()->findByPk($id);
        $colaborador = Colaborador::model()->findByPk($ed->colaborador);
        $compromisos = $ed->_compromisos;

        $phpExcelPath = Yii::getPathOfAlias('application.modules.excel');

        // Turn off our amazing library autoload 
        spl_autoload_unregister(array('YiiBase', 'autoload'));

        require_once( dirname(__FILE__) . '/../components/CommonFunctions.php');
        require_once( dirname(__FILE__) . '/../models/Merito.php');
        require_once( dirname(__FILE__) . '/../models/Puesto.php');
        require_once( dirname(__FILE__) . '/../models/Colaborador.php');
        require_once( dirname(__FILE__) . '/../models/Procesoevaluacion.php');
        require_once( dirname(__FILE__) . '/../models/Competencia.php');
        require_once( dirname(__FILE__) . '/../models/Tipomerito.php');
        require_once( dirname(__FILE__) . '/../models/Calificacioncompetencia.php');
        require_once( dirname(__FILE__) . '/../models/Compromiso.php');
        require_once( dirname(__FILE__) . '/../models/Evaluaciondesempeno.php');
        require_once( dirname(__FILE__) . '/../models/Puntualizacion.php');

        include($phpExcelPath . DIRECTORY_SEPARATOR . 'Classes' . DIRECTORY_SEPARATOR . 'PHPExcel.php');

        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        //$objReader->setIncludeCharts(TRUE);

        $styleTableBorder = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                )
            ),
        );
        if (count($compromisos) == 4) {
            $objPHPExcel = $objReader->load($phpExcelPath . DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR . "EvaluaciondeDesempenoCompTemplate.xlsx");

            $objPHPExcel->setActiveSheetIndex(0);  //set first sheet as active

            $objPHPExcel->getActiveSheet()->setCellValue('D4', $ed->_colaborador->nombrecompleto);
            $objPHPExcel->getActiveSheet()->setCellValue('D5', $ed->_puesto->nombre);
            $objPHPExcel->getActiveSheet()->setCellValue('D6', CommonFunctions::datemysqltophp($ed->fecharegistrocompromiso));
            $objPHPExcel->getActiveSheet()->setCellValue('I4', $ed->_colaborador->cedula);
            $objPHPExcel->getActiveSheet()->setCellValue('I5', $ed->_procesoevaluacion->_evaluador->nombrecompleto);
            $objPHPExcel->getActiveSheet()->setCellValue('I6', CommonFunctions::datemysqltophp($ed->fechaevaluacion));
            $objPHPExcel->getActiveSheet()->setCellValue('B27', $ed->comentariocompromisos);

            $i = '9';

            foreach ($compromisos as $compromiso) {

                $objPHPExcel->setActiveSheetIndex(0)
                        //->setCellValue('B'.$i, $merito->_merito->_tipomerito->nombre)
                        ->setCellValue('A' . $i, $compromiso->_puntualizacion->indicadorpuntualizacion)
                        ->setCellValue('F' . $i, $compromiso->compromiso);

                $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(15);
                $objPHPExcel->setActiveSheetIndex()->getStyle('A' . $i . ':J' . $i)->applyFromArray($styleTableBorder);
                $i = $i + 4;
            }
        } else {
            $objPHPExcel = $objReader->load($phpExcelPath . DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR . "EvaluaciondeDesempenoCompTemplate2.xlsx");

            $objPHPExcel->setActiveSheetIndex(0);  //set first sheet as active

            $objPHPExcel->getActiveSheet()->setCellValue('D4', $ed->_colaborador->nombrecompleto);
            $objPHPExcel->getActiveSheet()->setCellValue('D5', $ed->_puesto->nombre);
            $objPHPExcel->getActiveSheet()->setCellValue('D6', CommonFunctions::datemysqltophp($ed->fecharegistrocompromiso));
            $objPHPExcel->getActiveSheet()->setCellValue('I4', $ed->_colaborador->cedula);
            $objPHPExcel->getActiveSheet()->setCellValue('I5', $ed->_procesoevaluacion->_evaluador->nombrecompleto);
            $objPHPExcel->getActiveSheet()->setCellValue('I6', CommonFunctions::datemysqltophp($ed->fechaevaluacion));
            $objPHPExcel->getActiveSheet()->setCellValue('B27', $ed->comentariocompromisos);

            $i = '9';

            foreach ($compromisos as $compromiso) {

                $objPHPExcel->setActiveSheetIndex(0)
                        //->setCellValue('B'.$i, $merito->_merito->_tipomerito->nombre)
                        ->setCellValue('A' . $i, $compromiso->_puntualizacion->indicadorpuntualizacion)
                        ->setCellValue('F' . $i, $compromiso->compromiso);

                $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(15);
                $objPHPExcel->setActiveSheetIndex()->getStyle('A' . $i . ':J' . $i)->applyFromArray($styleTableBorder);
                $i = $i + 4;
            }
        }

        header('Content-Type: application/excel');
        header('Content-Disposition: attachment;filename="ReporteCompromisosED_' . $colaborador->nombrecompleto . '.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //$objWriter->setIncludeCharts(TRUE);                        
        $objWriter->save('php://output');

        exit();
    }

    //Logica para Generar el Reporte de ED
    public function actionCrearReporteED() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = CommonFunctions::stringtonumber($_POST['id']);
            $response = array('url' => Yii::app()->getBaseUrl(true) . '/index.php/procesoed/reporteed/' . $id);
            echo CJSON::encode($response);
            Yii::app()->end();
        }
    }

    public function actionReporteED($id) {

        $ed = Evaluaciondesempeno::model()->findByPk($id);
        $colaborador = Colaborador::model()->findByPk($ed->colaborador);
        $compromisos = $ed->_compromisos;
        $competencias = $ed->_calificacioncompetencias;


        $phpExcelPath = Yii::getPathOfAlias('application.modules.excel');

        // Turn off our amazing library autoload 
        spl_autoload_unregister(array('YiiBase', 'autoload'));

        require_once( dirname(__FILE__) . '/../components/CommonFunctions.php');
        require_once( dirname(__FILE__) . '/../models/Merito.php');
        require_once( dirname(__FILE__) . '/../models/Puesto.php');
        require_once( dirname(__FILE__) . '/../models/Colaborador.php');
        require_once( dirname(__FILE__) . '/../models/Procesoevaluacion.php');
        require_once( dirname(__FILE__) . '/../models/Competencia.php');
        require_once( dirname(__FILE__) . '/../models/Tipomerito.php');
        require_once( dirname(__FILE__) . '/../models/Calificacioncompetencia.php');
        require_once( dirname(__FILE__) . '/../models/Compromiso.php');
        require_once( dirname(__FILE__) . '/../models/Evaluaciondesempeno.php');
        require_once( dirname(__FILE__) . '/../models/Puntualizacion.php');

        include($phpExcelPath . DIRECTORY_SEPARATOR . 'Classes' . DIRECTORY_SEPARATOR . 'PHPExcel.php');


        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objReader->setIncludeCharts(TRUE);

        $styleTableBorder = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                )
            ),
        );
        if (count($compromisos) == 4) {
            $objPHPExcel = $objReader->load($phpExcelPath . DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR . "EvaluaciondeDesempenoTemplate.xlsx");

            $objPHPExcel->setActiveSheetIndex(0);  //set first sheet as active

            $objPHPExcel->getActiveSheet()->setCellValue('D4', $ed->_colaborador->nombrecompleto);
            $objPHPExcel->getActiveSheet()->setCellValue('D5', $ed->_puesto->nombre);
            $objPHPExcel->getActiveSheet()->setCellValue('D6', $ed->fecharegistrocompromiso);
            $objPHPExcel->getActiveSheet()->setCellValue('I4', $ed->_colaborador->cedula);
            $objPHPExcel->getActiveSheet()->setCellValue('I5', $ed->_procesoevaluacion->_evaluador->nombrecompleto);
            $objPHPExcel->getActiveSheet()->setCellValue('I6', $ed->fecharegistroevaluacion);

            $i = '35';

            foreach ($compromisos as $compromiso) {

                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $i, $compromiso->_puntualizacion->indicadorpuntualizacion)
                        ->setCellValue('F' . $i, $compromiso->compromiso)
                        ->setCellValue('K' . $i, $compromiso->puntaje);

                $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(15);
                $objPHPExcel->setActiveSheetIndex()->getStyle('A' . $i . ':K' . $i)->applyFromArray($styleTableBorder);
                $i = $i + 4;
            }

            $j = $i + 2;

            foreach ($competencias as $competencia) {
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('E' . $j, $competencia->_competencia->competencia)
                        ->setCellValue('F' . $j, $competencia->puntaje);

                $objPHPExcel->setActiveSheetIndex()->getStyle('E' . $j . ':F' . $j)->applyFromArray($styleTableBorder);
                $j++;
            }
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('D83', $ed->promediocompromisos)
                    ->setCellValue('D84', $ed->promediocompetencias)
                    ->setCellValue('D85', $ed->promedioevaluacion)
                    ->setCellValue('O70', $ed->promediocompromisos)
                    ->setCellValue('P71', $ed->promediocompetencias)
                    ->SetCellValue('B78', $ed->comentarioevaluacion);

            if (0 <= $ed->promedioevaluacion && $ed->promedioevaluacion <= 2) {
                $objPHPExcel->getActiveSheet()
                        ->setCellValue('D86', 'Desempeño Insuficiente')
                        ->getStyle('D86')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('f07d30');
            } else if (2 < $ed->promedioevaluacion && $ed->promedioevaluacion < 3) {
                $objPHPExcel->getActiveSheet()
                        ->setCellValue('D86', 'Oportunidad de mejora')
                        ->getStyle('D86')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('fefe04');
            } else if (3 <= $ed->promedioevaluacion && $ed->promedioevaluacion < 4) {
                $objPHPExcel->getActiveSheet()
                        ->setCellValue('D86', 'Desempeño Esperado')
                        ->getStyle('D86')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('90d152');
            } else if (4 <= $ed->promedioevaluacion && $ed->promedioevaluacion < 5) {
                $objPHPExcel->getActiveSheet()
                        ->setCellValue('D86', 'Desempeño Sobresaliente')
                        ->getStyle('D86')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('c2d6ec');
            } else {
                $objPHPExcel->getActiveSheet()
                        ->setCellValue('D86', 'Desempeño Superior')
                        ->getStyle('D86')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('2d76b5');
            }
        } else {
            $objPHPExcel = $objReader->load($phpExcelPath . DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR . "EvaluaciondeDesempenoTemplate2.xlsx");

            $objPHPExcel->setActiveSheetIndex(0);  //set first sheet as active

            $objPHPExcel->getActiveSheet()->setCellValue('D4', $ed->_colaborador->nombrecompleto);
            $objPHPExcel->getActiveSheet()->setCellValue('D5', $ed->_puesto->nombre);
            $objPHPExcel->getActiveSheet()->setCellValue('D6', $ed->fecharegistrocompromiso);
            $objPHPExcel->getActiveSheet()->setCellValue('I4', $ed->_colaborador->cedula);
            $objPHPExcel->getActiveSheet()->setCellValue('I5', $ed->_procesoevaluacion->_evaluador->nombrecompleto);
            $objPHPExcel->getActiveSheet()->setCellValue('I6', $ed->fecharegistroevaluacion);

            $i = '35';

            foreach ($compromisos as $compromiso) {

                $objPHPExcel->setActiveSheetIndex(0)
                        //->setCellValue('B'.$i, $merito->_merito->_tipomerito->nombre)
                        ->setCellValue('A' . $i, $compromiso->_puntualizacion->indicadorpuntualizacion)
                        ->setCellValue('F' . $i, $compromiso->compromiso)
                        ->setCellValue('K' . $i, $compromiso->puntaje);

                $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(15);
                $objPHPExcel->setActiveSheetIndex()->getStyle('A' . $i . ':K' . $i)->applyFromArray($styleTableBorder);
                $i = $i + 4;
            }

            $j = $i + 2;

            foreach ($competencias as $competencia) {
                $objPHPExcel->setActiveSheetIndex(0)
                        //->mergeCells('E'.$j.':F'.$j)
                        ->setCellValue('E' . $j, $competencia->_competencia->competencia)
                        ->setCellValue('F' . $j, $competencia->puntaje);

                $objPHPExcel->setActiveSheetIndex()->getStyle('E' . $j . ':F' . $j)->applyFromArray($styleTableBorder);
                $j++;
            }


            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('D83', $ed->promediocompromisos)
                    ->setCellValue('D84', $ed->promediocompetencias)
                    ->setCellValue('D85', $ed->promedioevaluacion)
                    ->setCellValue('O70', $ed->promediocompromisos)
                    ->setCellValue('P71', $ed->promediocompetencias)
                    ->SetCellValue('B78', $ed->comentarioevaluacion);

            if (0 <= $ed->promedioevaluacion && $ed->promedioevaluacion <= 2) {
                $objPHPExcel->getActiveSheet()
                        ->setCellValue('D86', 'Desempeño Insuficiente')
                        ->getStyle('D86')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('f07d30');
            } else if (2 < $ed->promedioevaluacion && $ed->promedioevaluacion < 3) {
                $objPHPExcel->getActiveSheet()
                        ->setCellValue('D86', 'Oportunidad de mejora')
                        ->getStyle('D86')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('fefe04');
            } else if (3 <= $ed->promedioevaluacion && $ed->promedioevaluacion < 4) {
                $objPHPExcel->getActiveSheet()
                        ->setCellValue('D86', 'Desempeño Esperado')
                        ->getStyle('D86')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('90d152');
            } else if (4 <= $ed->promedioevaluacion && $ed->promedioevaluacion < 5) {
                $objPHPExcel->getActiveSheet()
                        ->setCellValue('D86', 'Desempeño Sobresaliente')
                        ->getStyle('D86')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('c2d6ec');
            } else {
                $objPHPExcel->getActiveSheet()
                        ->setCellValue('D86', 'Desempeño Superior')
                        ->getStyle('D86')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('2d76b5');
            }
        }


        header('Content-Type: application/excel');
        header('Content-Disposition: attachment;filename="ReporteED_' . $colaborador->nombrecompleto . '.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
        exit();
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

    public function actionReporteAnalisisED($tiporeporte, $fechainicio, $fechafin, $tipoanalisis, $departamentos = array()) {

        $datosreporte = Evaluaciondesempeno::model()->AnalisisEvaluacion($tiporeporte, $fechainicio, $fechafin, $tipoanalisis, $departamentos);

        $phpExcelPath = Yii::getPathOfAlias('application.modules.excel');

        // Turn off our amazing library autoload 
        spl_autoload_unregister(array('YiiBase', 'autoload'));

        require_once( dirname(__FILE__) . '/../components/CommonFunctions.php');

        include($phpExcelPath . DIRECTORY_SEPARATOR . 'Classes' . DIRECTORY_SEPARATOR . 'PHPExcel.php');

        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        //$objReader->setIncludeCharts(TRUE);

        if ($tiporeporte == "R") {//Informe resumido
            $objPHPExcel = $objReader->load($phpExcelPath . DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR . "BrechasResumidoEDTemplate.xlsx");
        } else if ($tiporeporte == "A") {//Informe ampliado
            $objPHPExcel = $objReader->load($phpExcelPath . DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR . "BrechasAmpliadoEDTemplate.xlsx");
        }


        $objPHPExcel->setActiveSheetIndex(0);  //set first sheet as active

        $objPHPExcel->getActiveSheet()->setCellValue('B4', CommonFunctions::datemysqltophp($fechainicio));
        $objPHPExcel->getActiveSheet()->setCellValue('B5', CommonFunctions::datemysqltophp($fechafin));




        if (!$datosreporte) {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A6', "No se encontraron evaluaciones para estos departamentos.");

            header('Content-Type: application/excel');
            header('Content-Disposition: attachment;filename="BrechasED.xlsx"');
            header('Cache-Control: max-age=0');
        } else {
            $i = '8';

            if ($tiporeporte == "R") {//Informe resumido
                foreach ($datosreporte as $fila) {

                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $i, $fila["cedula"])
                            ->setCellValue('B' . $i, $fila["colaborador"])
                            ->setCellValue('C' . $i, $fila["puesto"])
                            ->setCellValue('D' . $i, $fila["departamento"])
                            ->setCellValue('E' . $i, $fila["evaluador"])
                            ->setCellValue('F' . $i, $fila["periodo"])
                            ->setCellValue('G' . $i, $fila["descripcion"])
                            ->setCellValue('H' . $i, $fila["fecharegistrocompromiso"])
                            ->setCellValue('I' . $i, $fila["fechaevaluacion"])
                            ->setCellValue('J' . $i, $fila["promedioevaluacion"])
                            ->setCellValue('K' . $i, $fila["promediocompromisos"])
                            ->setCellValue('L' . $i, $fila["promediocompetencias"]);

                    $i++;
                }
                header('Content-Type: application/excel');
                header('Content-Disposition: attachment;filename="BrechasResumidoED.xlsx"');
                header('Cache-Control: max-age=0');
            } else if ($tiporeporte == "A") {//Informe ampliado
                foreach ($datosreporte as $fila) {

                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $i, $fila["cedula"])
                            ->setCellValue('B' . $i, $fila["colaborador"])
                            ->setCellValue('C' . $i, $fila["puesto"])
                            ->setCellValue('D' . $i, $fila["departamento"])
                            ->setCellValue('E' . $i, $fila["evaluador"])
                            ->setCellValue('F' . $i, $fila["periodo"])
                            ->setCellValue('G' . $i, $fila["descripcion"])
                            ->setCellValue('H' . $i, $fila["fecharegistrocompromiso"])
                            ->setCellValue('I' . $i, $fila["fechaevaluacion"])
                            ->setCellValue('J' . $i, $fila["promedioevaluacion"])
                            ->setCellValue('K' . $i, $fila["promediocompromisos"])
                            ->setCellValue('L' . $i, $fila["competencia"])
                            ->setCellValue('M' . $i, $fila["calificacioncompetencia"]);

                    $i++;
                }

                header('Content-Type: application/excel');
                header('Content-Disposition: attachment;filename="BrechasAmpliadoED.xlsx"');
                header('Cache-Control: max-age=0');
            }
        }



        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //$objWriter->setIncludeCharts(TRUE);                        
        $objWriter->save('php://output');

        exit();
    }

}
