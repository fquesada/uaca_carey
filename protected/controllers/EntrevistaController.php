<?php
       


class EntrevistaController extends Controller
{
        
    
	public function actionIndex()
	{
		$this->render('index');                
	}
        
        
        public function actionPdf($id)
        {
            
            Yii::import('application.modules.tcpdf.*');
            require_once('tcpdf.php');
            require_once('config/lang/eng.php');

            $puesto = Puesto::model()->findByPk($id);
            
            
            // create new PDF document
            $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor("Carey");
            $pdf->SetTitle($puesto->nombre);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->AliasNbPages();
            $pdf->AddPage();
            
            
            
            $html = '<h1>Entrevista</h1>';
            $html .= '<h2>Puesto: '.$puesto->nombre.'</h2>';
            $html .= '<h3>Nombre entrevistado: ______________________ Cédula: ____________</h3>
                <h3>Fecha evaluación: ___/______/________</h3>
                <h3>Tipo reclutamiento:    ( ) Interno    ( ) Externo</h3>';
            
            $html .= '<table border="0.5" cellpadding="3"><tr><td width="20%">Competencias</td> <td width="70%">Preguntas y Respuestas</td><td width="10%">Valoración</td></tr>';
            
            foreach($puesto->_competencias as $competencia)
            {
               // $html .= 'comp: '.$competencia->competencia;
                $html .= '<tr>';
                $html .= '<td>'.$competencia->competencia.'</td>';
                $html .= '<td ><p align="justify">'.$competencia->pregunta.' <br><br><br><br><br><br><br></p></td>';
                $html .= '<td>                </td>';
                $html .= '</tr>';
            }
            
            $html .= '</table>';            
            
            $pdf->writeHTML($html);
            $fecha = date("d-m-Y");
            
            $pdf->Output('ECE-'.$puesto->nombre."-".$fecha.".pdf", "I");
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
	*/
}