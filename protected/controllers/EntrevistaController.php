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
            $core = Competenciacore::model()->findAll();
            $competencias = $puesto->_competencias;
            
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
            
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('Logo');
            $objDrawing->setDescription('Logo');
            $objDrawing->setPath('./images/UACA.png');
            $objDrawing->setHeight(40);
            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
            $objDrawing->setCoordinates('A2');

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
                        ->mergeCells('A2:I3') 
                        ->setCellValue('A2', 'Entrevista Conductual Estructurada')                                          
                        ->mergeCells('B4:H4')
                        ->setCellValue('F5', 'Puesto')
                        ->mergeCells('F6:I7')
                        ->setCellValue('F6', $puesto->nombre)
                        ->mergeCells('F5:I5');
                        
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A2:I3')->applyFromArray(array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '000066')
            )
                )
                    );
            
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A2')->getFont() 
                     ->setSize(24)
                     ->getColor()
                     ->setRGB('FFFFFF');   
            
            $objPHPExcel->setActiveSheetIndex(0)->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
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
                    ->getStyle('B18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
             $objPHPExcel->setActiveSheetIndex(0)
                    ->getStyle('D18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
             $objPHPExcel->setActiveSheetIndex(0)
                    ->getStyle('G18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
             
             $objPHPExcel->setActiveSheetIndex(0)                        
                        ->mergeCells('A18:B18')                        
                        ->setCellValue('A15', 'Competencia')                                          
                        ->mergeCells('C15:H15')                        
                        ->setCellValue('C15', 'Preguntas y Respuestas')                        
                        ->setCellValue('I15', 'U.V.');
             

             $styleTableBorder = array(
                 'borders'=>array(
                     'allborders'=>array(
                         'style'=> PHPExcel_Style_Border::BORDER_THIN,                         
                     )
                 ),
             );
 
             $objPHPExcel->setActiveSheetIndex()->getStyle('A15:I15')->applyFromArray($styleTableBorder);
             $objPHPExcel->setActiveSheetIndex(0)->getStyle('A15:I15')->getFont()->setBold(TRUE);
             $objPHPExcel->setActiveSheetIndex(0)->getStyle('A15:I15')->applyFromArray(array(
                    'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '6699FF')
                    )
                        )
                            );
             
             
             $i = '16';
                       
            foreach($core as $competencia_core)
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
                        ->setCellValue('A'.$i, $competencia_core->competencia)                                          
                        ->mergeCells('C'.$i.':H'.$i)                        
                        ->setCellValue('C'.$i, $competencia_core->pregunta);
                 
                 $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(350);
                 $objPHPExcel->setActiveSheetIndex()->getStyle('A'.$i.':I'.$i)->applyFromArray($styleTableBorder);
                 $i++;  
             }         

             $j = '20';
                       
            foreach($competencias as $competencia)
            {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->getStyle('A'.$j.':B'.$j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                $objPHPExcel->setActiveSheetIndex(0)
                    ->getStyle('A'.$j.':B'.$j)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)
                    ->getStyle('C'.$j.':H'.$j)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)
                    ->getStyle('C'.$j.':H'.$j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                        
                 $objPHPExcel->setActiveSheetIndex(0)                        
                        ->mergeCells('A'.$j.':B'.$j)   
                        ->setCellValue('A'.$j, $competencia->competencia)                                          
                        ->mergeCells('C'.$j.':H'.$j)                        
                        ->setCellValue('C'.$j, $competencia->pregunta);
                 
                 $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(350);
                 $objPHPExcel->setActiveSheetIndex()->getStyle('A'.$j.':I'.$j)->applyFromArray($styleTableBorder);
                 $objPHPExcel->getActiveSheet()->getPageSetup()->setPrintArea('A1:I'.$j);
                 $j++;  
             }   
             
            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            

            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="ECE.xls"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            
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