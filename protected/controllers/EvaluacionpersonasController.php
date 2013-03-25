<?php

class EvaluacionpersonasController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
        
        public function actionAgregarPersona()
        {
            if(Yii::app()->request->isAjaxRequest)
            {
                
                $idpersona = $_POST['id'];
                $tipopersona = $_POST['tipo'];                                
                $idevaluacion = $_POST['idevaluacion'];
                
//Validar si llegan null                
                
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
        
        public function actionEditar($id)
        {
            $dataProvider =new CActiveDataProvider('Evaluacioncompetencias',array('criteria'=>array(
                  'condition'=>'evaluacionpersonas='.$id)));
            $evaluacionpersonas = Evaluacionpersonas::model()->findByPk($id);                         
	
            $this->render('editar',array(
			'model'=>$evaluacionpersonas,'dataProvider'=>$dataProvider
		));
            
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
                        $nombrecompleto = $row['nombre'].' '.$row['apellido1'].' '.$row['apellido1'];
                        $return_array[] = array(
                        'label'=>'<div style="font-size:x-small">Cédula: '.$row['cedula'].'</div>'.'<div>'.$nombrecompleto.'</div>',
                        'value'=>$nombrecompleto, 
                        'id'=>$row['id'],
                         'cedula'=>$row['cedula'],                        
                            'tipo'=>1,                        
                        );
                    }
                    foreach($dataReaderPos as $row){ 
                        $nombrecompleto = $row['nombre'].' '.$row['apellido1'].' '.$row['apellido1'];
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