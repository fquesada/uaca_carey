<?php

class EvaluacionController extends Controller
{
	public function actionIndex()
	{            
            $dataProvider = new CActiveDataProvider('Evaluaciondesempeno',array('data'=>array()));// Evaluacion::model()->findAll();//ByAttributes(array('colaborador'=>2));
           if (Yii::app()->request->isAjaxRequest) 
            {
               $colaborador = $_GET['idcolaborador'];
               $dataProvider =new CActiveDataProvider('Evaluaciondesempeno',array('criteria'=>array(
                  'condition'=>'colaborador='.$colaborador)));                                
               $this->renderPartial('index',array('dataProvider'=>$dataProvider));
            }                           
            else
            {                            
		$this->render('index',array('dataProvider'=>$dataProvider));
            }
	}
        
        public function actionAutoCompleteColaborador()
        {
            if (isset($_GET['term'])) {

                $keyword=$_GET['term'];
                // escape % and _ characters
                $keyword=strtr($keyword, array('%'=>'\%', '_'=>'\_'));
                               
                $dataReader = Yii::app()->db->createCommand(
                        'SELECT c.cedula,c.nombre,c.apellido1,c.apellido2,p.nombre as puesto,u.nombre as unidad, c.id '.
                        'FROM colaborador c '.
                        'JOIN puesto p ON c.puesto = p.id '.
                        'JOIN unidadnegocio u ON c.unidadnegocio = u.id '.
                        'WHERE CONCAT_WS(" ", c.nombre, c.apellido1, c.apellido2 ) like "%'.$keyword.'%" AND c.estado = 1;'
                        )->query();                               
                
                /*->select(array('c.cedula','c.nombre','c.apellido1','c.apellido2','p.nombre as puesto','u.nombre as unidad', 'c.id'))
                ->from('colaborador c')
                ->join('puesto p', 'c.puesto=p.id')                  
                ->join('unidadnegocio u', 'u.id=c.unidadnegocio')
                ->where(array('like', 'CONCAT_WS(" ", c.nombre, c.apellido1, c.apellido2 )','%'.$keyword.'%'))                
                ->limit(10)*/
                                

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
                        'label'=>'<div style="font-size:x-small"> céd: '.$row['cedula'].'</div>'.'<div>'.$nombrecompleto.'</div><hr>',
                        'value'=>$nombrecompleto, 
                        'id'=>$row['id'],
                         'cedula'=>$row['cedula'],
                        'puesto'=>$row['puesto'],
                        'unidad'=>$row['unidad'],
                        );
                    }
                }
                
                echo CJSON::encode($return_array);               
            }
        }
        
        public function actionObtenerEvaluciones($id)
        {
            $evaluado = $id;//$_POST['idevaluado'];
            if (isset($evaluado)) {
                
                $evaluacionesModelo = EvaluacionDesempeno::model()->findAllByAttributes(array('colaborador'=>$evaluado));
                if($evaluacionesModelo)
                {
                    $evaluaciones = array();                    
                    foreach($evaluacionesModelo as $evaluacionModelo)
                    {
                        $evaluacion = array('periodo'=>$evaluacionModelo->periodo);
                        array_push($evaluaciones, $evaluacion);
                    }
                    echo json_encode($evaluaciones);
                }
                else
                    echo json_encode(array('error'=>'No hay evaluaciones realizadas.'));
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