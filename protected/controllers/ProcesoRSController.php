<?php

class ProcesoRSController extends Controller {

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
                'actions' => array('EvaluarProcesoECV', 'GuardarEvaluacionECV', 'InfoPonderacion', 'entrevista', 'AutocompletePuesto', ),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array(),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('CrearProcesoECV', 'AdminProcesoECV', 'EditarProcesoECV', 'EliminarProcesoECV', 'admin', 'AutocompleteEvaluado', 
                    'CrearReporteECV', 'ReporteECV', 'entrevista', 'excel'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionEntrevista() {
        $this->render('entrevista');
    }

    public function actionExcel() {
        $id = $_POST['idpuesto'];
        $puesto = Puesto::model()->findByPk($id);
        $core = $puesto->competenciascoreactuales;
        //$competencias = $puesto->_competencias;
        $competencias = $puesto->competenciasactuales;



        $phpExcelPath = null;
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        // get a reference to the path of PHPExcel classes 
        try {
            $phpExcelPath = Yii::getPathOfAlias('application.modules.excel.Classes');
        } catch (Exception $e) {
            spl_autoload_register(array('YiiBase', 'autoload'));
            throw $e;
        }





        include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
        //require_once('phpexcel.php');

        $objPHPExcel = new PHPExcel();
        spl_autoload_register(array('YiiBase', 'autoload'));

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Carey")
                ->setLastModifiedBy("Carey")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Entrevista Conductual Estructurada.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");

        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $objDrawing->setPath('./images/UACA.png');
        $objDrawing->setHeight(40);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objDrawing->setCoordinates('A1');

        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L' . date("d-m-Y") . '&R &P');
        //$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R &P');

        $objPHPExcel->setActiveSheetIndex(0)
                ->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->setActiveSheetIndex(0)
                ->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->setActiveSheetIndex(0)
                ->getStyle('C6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $objPHPExcel->setActiveSheetIndex(0)
                ->getStyle('C8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $objPHPExcel->setActiveSheetIndex(0)
                ->getStyle('C9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                ->mergeCells('A1:I2')
                ->setCellValue('A1', 'Entrevista Conductual Estructurada')
                //->mergeCells('B4:H4')
                ->setCellValue('F5', 'Puesto')
                ->mergeCells('F6:I7')
                ->setCellValue('F6', $puesto->nombre)
                ->mergeCells('F5:I5');

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:I2')->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '000066')
            )
                )
        );

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->getFont()
                ->setSize(24)
                ->getColor()
                ->setRGB('FFFFFF');

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('F5')
                ->getFont()
                ->setBold(TRUE);

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('F5:I7')->applyFromArray($styleArray);

        $objPHPExcel->setActiveSheetIndex(0)
                ->mergeCells('A6:D7')
                ->mergeCells('A10:D11')
                ->mergeCells('F10:I11')
                ->mergeCells('F9:I9')
                ->mergeCells('A5:D5')
                ->mergeCells('A9:D9')
                ->setCellValue('F9', 'Unidad de Negocio:')
                ->setCellValue('A5', 'Nombre')
                ->setCellValue('A9', 'Cédula');

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A5:D5')->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '6699FF')
            )
                )
        );

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('F5:I5')->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '6699FF')
            )
                )
        );

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A9:D9')->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '6699FF')
            )
                )
        );

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('F9:I9')->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '6699FF')
            )
                )
        );

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('F9')->getFont()->setBold(TRUE);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A5')->getFont()->setBold(TRUE);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A9')->getFont()->setBold(TRUE);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A5:D7')->applyFromArray($styleArray);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A9:D11')->applyFromArray($styleArray);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('F9:I11')->applyFromArray($styleArray);

        //Tabla
        $objPHPExcel->setActiveSheetIndex(0)
                ->getStyle('B17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)
                ->getStyle('D17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)
                ->getStyle('G17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->setActiveSheetIndex(0)
                ->mergeCells('A17:B17')
                ->setCellValue('A14', 'Competencia')
                ->mergeCells('C14:H14')
                ->setCellValue('C14', 'Preguntas y Respuestas')
                ->setCellValue('I14', 'U.V.');


        $styleTableBorder = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                )
            ),
        );

        $objPHPExcel->setActiveSheetIndex()->getStyle('A14:I14')->applyFromArray($styleTableBorder);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A14:I14')->getFont()->setBold(TRUE);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A14:I14')->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '6699FF')
            )
                )
        );


        $i = '15';

        foreach ($core as $competencia_core) {

            $objPHPExcel->setActiveSheetIndex(0)
                    ->getStyle('A' . $i . ':B' . $i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->getStyle('A' . $i . ':B' . $i)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->getStyle('C' . $i . ':H' . $i)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->getStyle('C' . $i . ':H' . $i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

            $objPHPExcel->setActiveSheetIndex(0)
                    ->mergeCells('A' . $i . ':B' . $i)
                    ->setCellValue('A' . $i, $competencia_core['competencia'])
                    ->mergeCells('C' . $i . ':H' . $i)
                    ->setCellValue('C' . $i, $competencia_core['pregunta']);

            $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(350);
            $objPHPExcel->setActiveSheetIndex()->getStyle('A' . $i . ':I' . $i)->applyFromArray($styleTableBorder);
            $i++;
        }

        $j = '19';

        foreach ($competencias as $competencia) {

            $objPHPExcel->setActiveSheetIndex(0)
                    ->getStyle('A' . $j . ':B' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->getStyle('A' . $j . ':B' . $j)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->getStyle('C' . $j . ':H' . $j)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)
                    ->getStyle('C' . $j . ':H' . $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

            $objPHPExcel->setActiveSheetIndex(0)
                    ->mergeCells('A' . $j . ':B' . $j)
                    ->setCellValue('A' . $j, $competencia['competencia'])
                    ->mergeCells('C' . $j . ':H' . $j)
                    ->setCellValue('C' . $j, $competencia['pregunta']);

            $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(350);
            $objPHPExcel->setActiveSheetIndex()->getStyle('A' . $j . ':I' . $j)->applyFromArray($styleTableBorder);
            $objPHPExcel->getActiveSheet()->getPageSetup()->setPrintArea('A1:I' . $j);
            $j++;
        }

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        // Redirect output to a client’s web browser (Excel5)
        date_default_timezone_set('America/Costa_Rica');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $puesto->nombre . "_" . date("d-m-Y") . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function actionAutocompleteEvaluado() {
        if (isset($_GET['term'])) {

            $keyword = $_GET['term'];
            // escape % and _ characters
            $keyword = strtr($keyword, array('%' => '\%', '_' => '\_'));

            //CLEAN CODE, DEBERIA ESTAR EN MODELS
            $dataReader = Yii::app()->db->createCommand(
                            'SELECT c.cedula,c.nombre,c.apellido1,c.apellido2, c.id, p.nombre as "puesto" ' .
                            'FROM colaborador c INNER JOIN historicopuesto hp on c.id = hp.colaborador and hp.puestoactual = 1 INNER JOIN puesto p  ON hp.puesto = p.id ' .
                            'WHERE CONCAT_WS(" ", c.nombre, c.apellido1, c.apellido2 ) like "%' . $keyword . '%" AND c.estado = 1;'
                    )->query();

//                $dataReaderPos = Yii::app()->db->createCommand(
//                        'SELECT c.cedula,c.nombre,c.apellido1,c.apellido2, c.id '.
//                        'FROM postulante c '.                        
//                        'WHERE CONCAT_WS(" ", c.nombre, c.apellido1, c.apellido2 ) like "%'.$keyword.'%" AND c.estado = 1;'
//                        )->query(); 


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

    public function actionCrearProcesoECV() {

        if (Yii::app()->request->isAjaxRequest) {
            //VALORAR PONER UN VALIDADOR ISSET TANTO DE VARIABLES DEL PROCESO COMO DE COLABORADORES
            $nombreproceso = $_POST['nombreproceso'];
            $idevaluador = CommonFunctions::stringtonumber($_POST['idevaluador']);
            $periodo = CommonFunctions::stringtonumber($_POST['periodo']);
            $puesto = CommonFunctions::stringtonumber($_POST['puesto']);
            $fechareclutamiento = $_POST['fechareclutamiento'];
            $fechaseleccion = $_POST['fechaseleccion'];
            $postulantes = $_POST['postulantes'];


            $procesoevaluacion = new Procesoevaluacion();
            $procesoevaluacion->fecha = CommonFunctions::datenow();
            $procesoevaluacion->evaluador = $idevaluador;
            $procesoevaluacion->descripcion = $nombreproceso;
            $procesoevaluacion->tipo = 3; //MIGRAR VARIABLES GLOBALES CLEAN CODE
            $procesoevaluacion->periodo = $periodo;


            $transaction = Yii::app()->db->beginTransaction();

            $resultadoguardarbd = $procesoevaluacion->save();

            $vacante = new Vacante();
            $vacante->puesto = $puesto;
            $vacante->procesoevaluacion = $procesoevaluacion->id;
            $vacante->fechareclutamiento = CommonFunctions::datephptomysql($fechareclutamiento);
            $vacante->fechaseleccion = CommonFunctions::datephptomysql($fechaseleccion);
            $vacante->periodo = $periodo;

            $vacante->save();

            if ($resultadoguardarbd) {
                foreach ($postulantes as $index => $nuevopostulante) {

                    $postulante = new Postulante();
                    $postulante->cedula = CommonFunctions::stringtonumber($nuevopostulante[0]);
                    $postulante->nombre = $nuevopostulante[1];
                    $postulante->apellido1 = $nuevopostulante[2];
                    $postulante->apellido2 = $nuevopostulante[3];
                    $postulante->estado = 1;
                    $postulante->save();


                    $evaluacioncompetencias = new Evaluacioncompetencias();
                    $evaluacioncompetencias->procesoevaluacion = $procesoevaluacion->id;
                    $evaluacioncompetencias->puesto = $vacante->puesto;
                    $evaluacioncompetencias->colaborador = $postulante->id;
                    $evaluacioncompetencias->save();

                    $link = new Links();
                    $link->url = $evaluacioncompetencias->id; //FALTA FUNCION HASH                          
                    $link->save();

                    $evaluacioncompetencias->links = $link->id;
                    $resultadoguardarbd = $evaluacioncompetencias->save();

                    if (!$resultadoguardarbd) {
                        $transaction->rollback();
                        $response = array('resultado' => false, 'mensaje' => "Ha ocurrido un inconveniente al intentar guardar el proceso: " . $procesoevaluacion->descripcion);
                        echo CJSON::encode($response);
                        Yii::app()->end();
                    }
                }
                $transaction->commit();
                $response = array('resultado' => true, 'mensaje' => "Se guardó con éxito el proceso: " . $procesoevaluacion->descripcion, 'url' => Yii::app()->getBaseUrl(true) . '/index.php/procesors/adminprocesoecv/' . $procesoevaluacion->id);
                echo CJSON::encode($response);
                Yii::app()->end();
            }
        }
        $editar = false;
        $this->render('crearprocesoecv', array(
            'indicadoreditar' => $editar,
        ));
    }

    public function actionAdminProcesoECV($id) {

        $procesoecv = Procesoevaluacion::model()->findByPk($id);
        $this->render('adminprocesoecv', array(
            'procesoecv' => $procesoecv,
        ));
    }

    public function actionEditarProcesoECV($id) {

        if (Yii::app()->request->isAjaxRequest) {
            $nombreproceso = $_POST['nombreproceso'];

            $periodo = CommonFunctions::stringtonumber($_POST['periodo']);
            $fechareclutamiento = $_POST['fechareclutamiento'];
            $fechaseleccion = $_POST['fechaseleccion'];
            $postulantes = $_POST['postulantes'];

            $procesoevaluacion = Procesoevaluacion::model()->findByPk($id);
            $evaluacioncompetenciaactual = $procesoevaluacion->_evaluacionescompetencias;
            $vacante = Vacante::model()->findByAttributes(array('procesoevaluacion' => $procesoevaluacion->id));

            $transaction = Yii::app()->db->beginTransaction();

            $procesoevaluacion->descripcion = $nombreproceso;
            $procesoevaluacion->periodo = $periodo;

            $vacante->fechareclutamiento = CommonFunctions::datephptomysql($fechareclutamiento);
            $vacante->fechaseleccion = CommonFunctions::datephptomysql($fechaseleccion);
            $puesto = $vacante->puesto;

            $resultadoguardarbd = $procesoevaluacion->save() && $vacante->save();
            if (!$resultadoguardarbd) {
                $transaction->rollback();
                $response = array('resultado' => false, 'mensaje' => "Ha ocurrido un inconveniente al intentar guardar los cambios del proceso: " . $procesoevaluacion->descripcion);
                echo CJSON::encode($response);
                Yii::app()->end();
            } else {

                foreach ($postulantes as $index => $nuevopostulante) {
                    $indicadoragregarec = false;
                    if (CommonFunctions::stringtonumber($nuevopostulante[4]) == 0) {
                        $indicadoragregarec = true;
                    }
                    if ($indicadoragregarec) {

                        $postulante = new Postulante();
                        $postulante->cedula = CommonFunctions::stringtonumber($nuevopostulante[0]);
                        $postulante->nombre = $nuevopostulante[1];
                        $postulante->apellido1 = $nuevopostulante[2];
                        $postulante->apellido2 = $nuevopostulante[3];
                        $postulante->estado = 1;
                        $postulante->save();


                        $evaluacioncompetencias = new Evaluacioncompetencias();
                        $evaluacioncompetencias->procesoevaluacion = $procesoevaluacion->id;
                        $evaluacioncompetencias->puesto = $puesto; //CLEAN CODE
                        $evaluacioncompetencias->colaborador = $postulante->id;
                        $evaluacioncompetencias->save();

                        $link = new Links();
                        $link->url = $evaluacioncompetencias->id; //FALTA FUNCION HASH                          
                        $link->save();

                        $evaluacioncompetencias->links = $link->id;
                        $resultadoguardarbd = $evaluacioncompetencias->save();
                        if (!$resultadoguardarbd) {
                            $transaction->rollback();
                            $response = array('resultado' => false, 'mensaje' => "Ha ocurrido un inconveniente al intentar guardar los cambios del proceso: " . $procesoevaluacion->descripcion);
                            echo CJSON::encode($response);
                            Yii::app()->end();
                        }
                    }
                }

                foreach ($evaluacioncompetenciaactual as $ec) {
                    $indicadorborrarec = true;
                    foreach ($postulantes as $index => $postulante) {
                        if (CommonFunctions::stringtonumber($postulante[4]) == $ec->colaborador) {
                            $indicadorborrarec = false;
                            break 1;
                        }
                    }
                    if ($indicadorborrarec) {
                        $evaluacioncompetencias = Evaluacioncompetencias::model()->findByPk($ec->id);
                        $evaluacioncompetencias->estado = 0; //CLEAN CODE VARIABLES GLOBALES
                        $resultadoguardarbd = $evaluacioncompetencias->save();
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
            $response = array('resultado' => true, 'mensaje' => "Se guardó con éxito los cambios realizados al proceso: " . $procesoevaluacion->descripcion, 'url' => Yii::app()->getBaseUrl(true) . '/index.php/procesors/adminprocesoecv/' . $procesoevaluacion->id);
            echo CJSON::encode($response);
            Yii::app()->end();
        }

        $procesoecv = Procesoevaluacion::model()->findByPk($id);
        $vacante = Vacante::model()->findByAttributes(array('procesoevaluacion' => $procesoecv->id));
        $editar = true;
        $this->render('crearprocesoecv', array(
            'procesoec' => $procesoecv, 'vacante' => $vacante, 'indicadoreditar' => $editar,
        ));
    }

    public function actionEvaluarProcesoECV($id) {

        $this->layout = 'column1';

        $idoriginal = CommonFunctions::decrypt($id);
        $ec = Evaluacioncompetencias::model()->findByPk($idoriginal);

        if ($ec->estadoevaluacionindicador) {
            $this->render('notificacionECVfinalizada', array(
                'msj' => 'Esta Evaluación de Competencias ya fue calificada, si considera que es un error contacte al Departamento de Recursos Humanos.'));
        } else {
            $puntaje = Puntaje::model()->obtenerpuntajesactivos();
            $this->render('evaluarprocesoecv', array(
                'ec' => $ec, 'puntaje' => $puntaje));
        }
    }

    public function actionGuardarEvaluacionECV() {

        if (Yii::app()->request->isAjaxRequest) {

            $idec = CommonFunctions::stringtonumber($_POST['idec']);
            $ec = Evaluacioncompetencias::model()->findByPk($idec);

            $assessmentcenter = ($_POST['ac']);

            $meritos = ($_POST['meritos']);
            $habilidades = ($_POST['habilidades']);

            //Determinar si hay necesidad de guardar habilidadesnoequivalentes
            if (isset($_POST['habilidadesnoequivalentes'])) {
                $habilidadesnoequivalentes = ($_POST['habilidadesnoequivalentes']);
                $indicadorhabilidadesnoequivalentes = true;
            } else {
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
            } else {
                $calificacionec = $ec->calificacionec($meritos, $habilidades, 0, false);
                $ec->eccalificacion = $calificacionec;
                $ec->promedioec = $calificacionec;
                $ec->promedioponderado = $calificacionec;
            }
            $ec->estado = 2; //CLEAN CODE - PONER EN VARIABLES GLOBALES
            $ec->fechaevaluacion = CommonFunctions::datenow();

            $link = Links::model()->findByPk($ec->links);
            $link->estado = 0;

            $transaction = Yii::app()->db->beginTransaction();

            $resultadoguardarbdlink = $link->save();
            $resultadoguardarbd = $ec->save();

            //Valida que en el Proceso de Evaluacion se hallan completado sus evaluaciones.
            $pe = Procesoevaluacion::model()->findByPk($ec->procesoevaluacion);
            if ($pe->EvaluacionesSinEvaluar)
                $pe->estado = 1;
            else
                $pe->estado = 2;
            $resultestadoproceso = $pe->save();

            if ($resultadoguardarbd && $resultadoguardarbdlink && $resultestadoproceso) {

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
                        if ($assessmentcenter['indicadorac'] == "true") {
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
                $response = array('resultado' => true, 'mensaje' => "Se guardó con éxito la evaluacion", 'url' => Yii::app()->getBaseUrl(true) . '/index.php/procesors/adminprocesoecv/' . $ec->procesoevaluacion);
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

    public function actionEliminarProcesoECV($id) {
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

    public function actionAdmin() {
        $ec = Procesoevaluacion::model()->obtenerevaluacioncompetencias(3);
        $filtersForm = new FiltersForm;

        if (isset($_GET['FiltersForm']))
            $filtersForm->filters = $_GET['FiltersForm'];

        $this->layout = 'column1';
        $this->render('admin', array(
            'ecv' => $filtersForm->filter($ec),
            'filtersForm' => $filtersForm,
        ));
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

    public function actionCrearReporteECV() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = CommonFunctions::stringtonumber($_POST['id']);
            $response = array('url' => Yii::app()->getBaseUrl(true) . '/index.php/procesors/reporteecv/' . $id);
            echo CJSON::encode($response);
            Yii::app()->end();
        }
    }

    public function actionReporteECV($id) {

        $ec = Evaluacioncompetencias::model()->findByPk($id);
        $postulante = Postulante::model()->findByPk($ec->colaborador);
        $vacante = Vacante::model()->findByAttributes(array('procesoevaluacion' => $ec->_procesoevaluacion->id));
        $competencias = $ec->_habilidadesevaluacioncandidato;
        $meritos = $ec->_meritosevaluacioncandidato;


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
        if (count($competencias) == 7) { //Las 4 competencias CORE más 3 normales.
            if ($ec->acindicador == 0) {
                $objPHPExcel = $objReader->load($phpExcelPath . DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR . "EvaluacionPorCompetenciasTemplate.xlsx");

                $objPHPExcel->setActiveSheetIndex(0);  //set first sheet as active

                $objPHPExcel->getActiveSheet()->setCellValue('C4', $postulante->nombrecompleto);
                $objPHPExcel->getActiveSheet()->setCellValue('C5', $vacante->_puesto->nombre);
                $objPHPExcel->getActiveSheet()->setCellValue('G4', $postulante->cedula);
                $objPHPExcel->getActiveSheet()->setCellValue('G5', $ec->_procesoevaluacion->_evaluador->nombrecompleto);
                $objPHPExcel->getActiveSheet()->setCellValue('G6', $ec->_procesoevaluacion->fecha);

                $i = '35';

                foreach ($meritos as $merito) {

                    $objPHPExcel->setActiveSheetIndex(0)
                            //->mergeCells('E'.$i.':F'.$i)
                            ->setCellValue('B' . $i, $merito->_merito->_tipomerito->nombre)
                            ->setCellValue('F' . $i, $merito->ponderacion)
                            ->setCellValue('G' . $i, CommonFunctions::ponderaciontoideal($merito->ponderacion))
                            ->setCellValue('H' . $i, $merito->calificacion);

                    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(15);
                    $objPHPExcel->setActiveSheetIndex()->getStyle('B' . $i . ':H' . $i)->applyFromArray($styleTableBorder);
                    $i++;
                }

                $j = $i;

                foreach ($competencias as $competencia) {
                    $objPHPExcel->setActiveSheetIndex(0)
                            //->mergeCells('E'.$j.':F'.$j)
                            ->setCellValue('B' . $j, $competencia->_competencia->competencia)
                            ->setCellValue('C' . $j, $competencia->variablemetodo)
                            ->setCellValue('D' . $j, $competencia->metodo)
                            ->setCellValue('E' . $j, $competencia->calificacionvariablemetodo)
                            ->setCellValue('F' . $j, $competencia->ponderacion)
                            ->setCellValue('G' . $j, CommonFunctions::ponderaciontoideal($competencia->ponderacion))
                            ->setCellValue('H' . $j, $competencia->calificacion);

                    $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(15);
                    $objPHPExcel->setActiveSheetIndex()->getStyle('B' . $j . ':H' . $j)->applyFromArray($styleTableBorder);
                    $j++;
                }

                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('E49', $ec->promedioponderado);
            } else {
                $objPHPExcel = $objReader->load($phpExcelPath . DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR . "EvaluacionPorCompetenciasTemplate_AC.xlsx");

                $objPHPExcel->setActiveSheetIndex(0);  //set first sheet as active

                $objPHPExcel->getActiveSheet()->setCellValue('C4', $ec->_colaborador->nombrecompleto);
                $objPHPExcel->getActiveSheet()->setCellValue('C5', $ec->_puesto->nombre);
                $objPHPExcel->getActiveSheet()->setCellValue('G4', $ec->_colaborador->cedula);
                $objPHPExcel->getActiveSheet()->setCellValue('G5', $ec->_procesoevaluacion->_evaluador->nombrecompleto);
                $objPHPExcel->getActiveSheet()->setCellValue('G6', $ec->_procesoevaluacion->fecha);
                $objPHPExcel->getActiveSheet()->setCellValue('D34', $ec->accalificacion);
                $objPHPExcel->getActiveSheet()->setCellValue('D35', $ec->acdetalle);

                $i = '39';

                foreach ($meritos as $merito) {

                    $objPHPExcel->setActiveSheetIndex(0)
                            //->mergeCells('E'.$i.':F'.$i)
                            ->setCellValue('B' . $i, $merito->_merito->_tipomerito->nombre)
                            ->setCellValue('F' . $i, $merito->ponderacion)
                            ->setCellValue('G' . $i, CommonFunctions::ponderaciontoideal($merito->ponderacion))
                            ->setCellValue('H' . $i, $merito->calificacion);

                    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(15);
                    $objPHPExcel->setActiveSheetIndex()->getStyle('B' . $i . ':H' . $i)->applyFromArray($styleTableBorder);
                    $i++;
                }

                $j = $i;

                foreach ($competencias as $competencia) {
                    $objPHPExcel->setActiveSheetIndex(0)
                            //->mergeCells('E'.$j.':F'.$j)
                            ->setCellValue('B' . $j, $competencia->_competencia->competencia)
                            ->setCellValue('C' . $j, $competencia->variablemetodo)
                            ->setCellValue('D' . $j, $competencia->metodo)
                            ->setCellValue('E' . $j, $competencia->calificacionvariablemetodo)
                            ->setCellValue('F' . $j, $competencia->ponderacion)
                            ->setCellValue('G' . $j, CommonFunctions::ponderaciontoideal($competencia->ponderacion))
                            ->setCellValue('H' . $j, $competencia->calificacion);

                    $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(15);
                    $objPHPExcel->setActiveSheetIndex()->getStyle('B' . $j . ':H' . $j)->applyFromArray($styleTableBorder);
                    $j++;
                }

                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('E53', $ec->promedioponderado);
            }
        } else {
            if ($ec->acindicador == 0) {
                $objPHPExcel = $objReader->load($phpExcelPath . DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR . "EvaluacionPorCompetenciasTemplate2.xlsx");

                $objPHPExcel->setActiveSheetIndex(0);  //set first sheet as active

                $objPHPExcel->getActiveSheet()->setCellValue('C4', $ec->_colaborador->nombrecompleto);
                $objPHPExcel->getActiveSheet()->setCellValue('C5', $ec->_puesto->nombre);
                $objPHPExcel->getActiveSheet()->setCellValue('G4', $ec->_colaborador->cedula);
                $objPHPExcel->getActiveSheet()->setCellValue('G5', $ec->_procesoevaluacion->_evaluador->nombrecompleto);
                $objPHPExcel->getActiveSheet()->setCellValue('G6', $ec->_procesoevaluacion->fecha);

                $i = '35';

                foreach ($meritos as $merito) {

                    $objPHPExcel->setActiveSheetIndex(0)
                            //->mergeCells('E'.$i.':F'.$i)
                            ->setCellValue('B' . $i, $merito->_merito->_tipomerito->nombre)
                            ->setCellValue('F' . $i, $merito->ponderacion)
                            ->setCellValue('G' . $i, CommonFunctions::ponderaciontoideal($merito->ponderacion))
                            ->setCellValue('H' . $i, $merito->calificacion);

                    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(15);
                    $objPHPExcel->setActiveSheetIndex()->getStyle('B' . $i . ':H' . $i)->applyFromArray($styleTableBorder);
                    $i++;
                }

                $j = $i;

                foreach ($competencias as $competencia) {
                    $objPHPExcel->setActiveSheetIndex(0)
                            //->mergeCells('E'.$j.':F'.$j)
                            ->setCellValue('B' . $j, $competencia->_competencia->competencia)
                            ->setCellValue('C' . $j, $competencia->variablemetodo)
                            ->setCellValue('D' . $j, $competencia->metodo)
                            ->setCellValue('E' . $j, $competencia->calificacionvariablemetodo)
                            ->setCellValue('F' . $j, $competencia->ponderacion)
                            ->setCellValue('G' . $j, CommonFunctions::ponderaciontoideal($competencia->ponderacion))
                            ->setCellValue('H' . $j, $competencia->calificacion);

                    $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(15);
                    $objPHPExcel->setActiveSheetIndex()->getStyle('B' . $j . ':H' . $j)->applyFromArray($styleTableBorder);
                    $j++;
                }

                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('E49', $ec->promedioponderado);
            } else {
                $objPHPExcel = $objReader->load($phpExcelPath . DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR . "EvaluacionPorCompetenciasTemplate_AC2.xlsx");

                $objPHPExcel->setActiveSheetIndex(0);  //set first sheet as active

                $objPHPExcel->getActiveSheet()->setCellValue('C4', $ec->_colaborador->nombrecompleto);
                $objPHPExcel->getActiveSheet()->setCellValue('C5', $ec->_puesto->nombre);
                $objPHPExcel->getActiveSheet()->setCellValue('G4', $ec->_colaborador->cedula);
                $objPHPExcel->getActiveSheet()->setCellValue('G5', $ec->_procesoevaluacion->_evaluador->nombrecompleto);
                $objPHPExcel->getActiveSheet()->setCellValue('G6', $ec->_procesoevaluacion->fecha);
                $objPHPExcel->getActiveSheet()->setCellValue('D34', $ec->accalificacion);
                $objPHPExcel->getActiveSheet()->setCellValue('D35', $ec->acdetalle);

                $i = '39';

                foreach ($meritos as $merito) {

                    $objPHPExcel->setActiveSheetIndex(0)
                            //->mergeCells('E'.$i.':F'.$i)
                            ->setCellValue('B' . $i, $merito->_merito->_tipomerito->nombre)
                            ->setCellValue('F' . $i, $merito->ponderacion)
                            ->setCellValue('G' . $i, CommonFunctions::ponderaciontoideal($merito->ponderacion))
                            ->setCellValue('H' . $i, $merito->calificacion);

                    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(15);
                    $objPHPExcel->setActiveSheetIndex()->getStyle('B' . $i . ':H' . $i)->applyFromArray($styleTableBorder);
                    $i++;
                }

                $j = $i;

                foreach ($competencias as $competencia) {
                    $objPHPExcel->setActiveSheetIndex(0)
                            //->mergeCells('E'.$j.':F'.$j)
                            ->setCellValue('B' . $j, $competencia->_competencia->competencia)
                            ->setCellValue('C' . $j, $competencia->variablemetodo)
                            ->setCellValue('D' . $j, $competencia->metodo)
                            ->setCellValue('E' . $j, $competencia->calificacionvariablemetodo)
                            ->setCellValue('F' . $j, $competencia->ponderacion)
                            ->setCellValue('G' . $j, CommonFunctions::ponderaciontoideal($competencia->ponderacion))
                            ->setCellValue('H' . $j, $competencia->calificacion);

                    $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(15);
                    $objPHPExcel->setActiveSheetIndex()->getStyle('B' . $j . ':H' . $j)->applyFromArray($styleTableBorder);
                    $j++;
                }

                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('E53', $ec->promedioponderado);
            }
        }



        header('Content-Type: application/excel');
        header('Content-Disposition: attachment;filename="ReporteEC_' . $postulante->nombrecompleto . '.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
        exit();
    }
    
    public function actionAutocompletePuesto() {
        if (isset($_GET['term'])) {

            $keyword = $_GET['term'];
            // escape % and _ characters
            $keyword = strtr($keyword, array('%' => '\%', '_' => '\_'));

            //CLEAN CODE, DEBERIA ESTAR EN MODELS
            $dataReader = Yii::app()->db->createCommand(
                            'SELECT id, nombre, codigo ' .
                            'FROM puesto ' .
                            'WHERE nombre like "%' . $keyword . '%" AND estado = 1;'
                    )->query();

            $return_array = array();
            if ($dataReader->count() == 0) {
                $return_array[] = array(
                    'label' => 'No hay resultados.',
                    'value' => '',
                );
            } else {
                foreach ($dataReader as $row) {
                    
                    $return_array[] = array(
                        'label' => $row['nombre'] ,
                        'value' => $row['nombre'],                                                
                        'id' => $row['id'],
                        'tipo' => 1,
                    );
                }
            }
            echo CJSON::encode($return_array);
        }
    }
    
    

}