<?php

class BrechasController extends Controller {

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
                'actions' => array(),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('HistoricoEvaluaciones', 'competencias', 'brechas', 'AutocompleteColaborador',
                    'CargarHistoricoEvaluaciones', 'GenerarReporteHistorico', 'AnalisisCompetencias', 'GenerarReporteAnalisis'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array(),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /*Metodos de Historico*/
    
    public function actionHistoricoEvaluaciones() {

        $this->render('historico', array());
    }    

    public function actionCargarHistoricoEvaluaciones() {
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['id'])) {

                $idcolaborador = CommonFunctions::stringtonumber($_POST['id']);
                $colaborador = Colaborador::model()->findByPk($idcolaborador);

                $datoscolaborador = array();
                $datoscolaborador["cedula"] = $colaborador->cedula;
                $datoscolaborador["nombrecompleto"] = $colaborador->nombrecompleto;
                $datoscolaborador["unidadnegocioactual"] = $colaborador->nombreunidadnegocioactual;
                $datoscolaborador["puestoactual"] = $colaborador->nombrepuestoactual;
                $datoscolaborador["estadocolaborador"] = $colaborador->estadocolaborador;

                $evaluacionesHistoricas = Colaborador::model()->HistoricoEvaluacion($idcolaborador);
                if (!($evaluacionesHistoricas == false)) {
                    $response = array('resultado' => true, 'colaborador' => $datoscolaborador, 'evaluaciones' => $evaluacionesHistoricas);
                    echo CJSON::encode($response);
                    Yii::app()->end();
                } else {
                    $response = array('resultado' => false, 'colaborador' => $datoscolaborador, 'evaluaciones' => 'El colaborador no posee evaluaciones.');
                    echo CJSON::encode($response);
                    Yii::app()->end();
                }
            } else {
                $response = array('resultado' => false, 'mensaje' => "Lo sentimos, ha ocurrido un problema al intentar cargar las evaluaciones.");
                echo CJSON::encode($response);
                Yii::app()->end();
            }
        }
    }

    public function actionGenerarReporteHistorico() {
        if (Yii::app()->request->isAjaxRequest) {
            $idEvalacion = CommonFunctions::stringtonumber($_POST['id']);
            $tipoProceso = $_POST['tipo'];
            if ($tipoProceso == "ED") {
                $response = array('url' => Yii::app()->getBaseUrl(true) . '/index.php/procesoed/reporteed/' . $idEvalacion);
                echo CJSON::encode($response);
                Yii::app()->end();
            } else if ($tipoProceso == "EC") {
                $response = array('url' => Yii::app()->getBaseUrl(true) . '/index.php/procesoevaluacion/reporteec/' . $idEvalacion);
                echo CJSON::encode($response);
                Yii::app()->end();
            }
        }
    }
    
    /*Metodos Analisis Competencias*/
    
    public function actionAnalisisCompetencias(){
        $this->render('analisis', array());
    }
    
    public function actionGenerarReporteAnalisis() {
        if (Yii::app()->request->isAjaxRequest) {
            $tipoProceso = $_POST['tipoproceso'];
            $fechaInicio = CommonFunctions::datephptomysql($_POST['fechainicio']);
            $fechaFin = CommonFunctions::datephptomysql($_POST['fechafin']);
            $tipoAnalisis = $_POST['tipoanalisis'];

            $departamentos = array();
            if (isset($_POST['departamentos']))
                $departamentos = implode($_POST['departamentos'], ',');
            else
                $tipoAnalisis = "masiva";

            if ($tipoProceso == "ED") {
                $url = Yii::app()->createUrl("ProcesoED/ReporteAnalisisED", array("fechainicio" => $fechaInicio, "fechafin" => $fechaFin, "tipoanalisis" => $tipoAnalisis, "departamentos" => $departamentos));
                $response = array('url' => $url);
                echo CJSON::encode($response);
                Yii::app()->end();
            } else if ($tipoProceso == "EC") {
                $url = Yii::app()->createUrl("Procesoevaluacion/ReporteAnalisisEC", array("fechainicio" => $fechaInicio, "fechafin" => $fechaFin, "tipoanalisis" => $tipoAnalisis, "departamentos" => $departamentos));
                $response = array('url' => $url);
                echo CJSON::encode($response);
                Yii::app()->end();
            }
        }
    }

    /*Metodos Generales*/
    
    public function actionAutocompleteColaborador() {
        if (isset($_GET['term'])) {

            $keyword = $_GET['term'];
            // escape % and _ characters
            $keyword = strtr($keyword, array('%' => '\%', '_' => '\_'));
            $dataReader = Colaborador::model()->BuscarColaborador($keyword, false);

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
                    );
                }
            }
            echo CJSON::encode($return_array);
        }
    }
    
    
}