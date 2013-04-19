<?php

class EntrevistaController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
        
        
        public function actionExcel()
        {            
            $id = $_POST['puesto'];
            $puesto = Puesto::model()->findByPk($id);
            $competencias = $puesto->_competencias;
            
            if(count($competencias)>1)
            {
            // get a reference to the path of PHPExcel classes 
                $phpExcelPath = Yii::getPathOfAlias('application.modules.excel.Classes');

                // Turn off our amazing library autoload 
                spl_autoload_unregister(array('YiiBase','autoload'));        

                include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
                //require_once('phpexcel.php');

                $objPHPExcel = new PHPExcel();

                // Set document properties
                $objPHPExcel->getProperties()->setCreator("Carey")
                                                                        ->setLastModifiedBy("Carey")
                                                                        ->setTitle("Office 2007 XLSX Test Document")
                                                                        ->setSubject("Office 2007 XLSX Test Document")
                                                                        ->setDescription("Entrevista Conductual Estructurada.")
                                                                        ->setKeywords("office 2007 openxml php")
                                                                        ->setCategory("Test result file");


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
                            ->mergeCells('B2:H3')                        
                            ->setCellValue('B2', 'Entrevista Conductual Estructurada')                                          
                            ->mergeCells('B4:H4')
                            ->setCellValue('B4', 'Puesto: '.$puesto->nombre);

                $styleBottonBorder = array(
                    'borders'=>array(
                        'bottom'=>array(
                            'style'=> PHPExcel_Style_Border::BORDER_THIN,                         
                        )
                    ),
                );

                $objPHPExcel->setActiveSheetIndex(0)  
                            ->mergeCells('D6:G6')
                            ->mergeCells('D8:G8')
                            ->mergeCells('D9:G9')
                            ->setCellValue('C6', 'Unidad de Negocio:')
                            ->setCellValue('C8', 'Nombre:')
                            ->setCellValue('C9', 'Cédula:');

                $objPHPExcel->setActiveSheetIndex(0)->getStyle('D6:G6')->applyFromArray($styleBottonBorder);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('D8:G8')->applyFromArray($styleBottonBorder);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('D9:G9')->applyFromArray($styleBottonBorder);

                //Tabla
                $objPHPExcel->setActiveSheetIndex(0)
                        ->getStyle('B11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->setActiveSheetIndex(0)
                        ->getStyle('D11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->setActiveSheetIndex(0)
                        ->getStyle('G11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $objPHPExcel->setActiveSheetIndex(0)                        
                            ->mergeCells('A11:B11')                        
                            ->setCellValue('A11', 'Competencia')                                          
                            ->mergeCells('C11:H11')                        
                            ->setCellValue('C11', 'Preguntas y Respuestas')                        
                            ->setCellValue('I11', 'U.C.');


                $styleTableBorder = array(
                    'borders'=>array(
                        'allborders'=>array(
                            'style'=> PHPExcel_Style_Border::BORDER_THIN,                         
                        )
                    ),
                );

                $objPHPExcel->setActiveSheetIndex()->getStyle('A11:I11')->applyFromArray($styleTableBorder);


                $i = '12';

                foreach($competencias as $competencia)
                {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->getStyle('A'.$i.':B'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->getStyle('A'.$i.':B'.$i)->getAlignment()->setWrapText(true);
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->getStyle('C'.$i.':H'.$i)->getAlignment()->setWrapText(true);
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->getStyle('C'.$i.':H'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

                    $objPHPExcel->setActiveSheetIndex(0)                        
                            ->mergeCells('A'.$i.':B'.$i)   
                            ->setCellValue('A'.$i, $competencia->competencia)                                          
                            ->mergeCells('C'.$i.':H'.$i)                        
                            ->setCellValue('C'.$i, $competencia->pregunta);

                    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(350);
                    $objPHPExcel->setActiveSheetIndex()->getStyle('A'.$i.':I'.$i)->applyFromArray($styleTableBorder);
                    $i++;                             
                }         

                // Set active sheet index to the first sheet, so Excel opens this as the first sheet


                // Redirect output to a client’s web browser (Excel5)
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="ECE.xls"');
                header('Cache-Control: max-age=0');

                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');
            }
            else
            {
                Yii::app()->user->setFlash('entrevista','El puesto seleccionado no posee competencias favor agreguelas.');
                $this->redirect(array('index'));
            }
            
        }
        

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
         * 
         * 
         * 
         *  $puesto = Puesto::model()->findByPk($id);
            
            
           // get a reference to the path of PHPExcel classes 
            $phpExcelPath = Yii::getPathOfAlias('application.modules.excel.Classes');

            // Turn off our amazing library autoload 
            spl_autoload_unregister(array('YiiBase','autoload'));        

            //
            // making use of our reference, include the main class
            // when we do this, phpExcel has its own autoload registration
            // procedure (PHPExcel_Autoloader::Register();)
            include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
            //require_once('phpexcel.php');
            
            $objPHPExcel = new PHPExcel();

            // Set document properties
            $objPHPExcel->getProperties()->setCreator("Carey")
                                                                    ->setLastModifiedBy("Carey")
                                                                    ->setTitle("Office 2007 XLSX Test Document")
                                                                    ->setSubject("Office 2007 XLSX Test Document")
                                                                    ->setDescription("Entrevista Conductual Estructurada.")
                                                                    ->setKeywords("office 2007 openxml php")
                                                                    ->setCategory("Test result file");


            // Add some data
            $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('B2', 'Entrevista')
                        ->setCellValue('B4', 'Puesto')
                        ->setCellValue('C4', $puesto->nombre);
            


            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);


            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="ECE.xls"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
	*/
}
