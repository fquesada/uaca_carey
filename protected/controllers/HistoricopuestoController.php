<?php

class HistoricopuestoController extends Controller
{
	public function actionCreate()
	{
		$this->render('create');
	}

	public function actionUpdate()
	{
		$this->render('update');
	}
        
        public function actionGetPuestos()
        {
            echo CHtml::tag('option',
                            array('value'=>'empty'),CHtml::encode('Selecione un puesto'),true);//Para que siempre aparezca al inicio
            
            if(isset($_POST['Historicopuesto']['unidadnegocio']))
            {
                $unidadnegocio = $_POST['Historicopuesto']['unidadnegocio'];
                
                $dataReader = Yii::app()->db->createCommand(
                        'SELECT p.id, p.nombre '.
                        'FROM puesto p '.
                        'JOIN unidadnegociopuesto up ON up.puesto = p.id '.
                        'JOIN unidadnegocio u ON up.unidadnegocio = u.id '.
                        'WHERE unidadnegocio = '.$unidadnegocio.' AND p.estado = 1;'
                        )->query();
                
                $data=CHtml::listData($dataReader,'id','nombre');
                
                foreach($data as $value=>$nombre) {
                            echo CHtml::tag('option',
                            array('value'=>$value),CHtml::encode($nombre),true);
                    }
            }
            else
            {
                echo CHtml::tag('option',
                            array('value'=>'0'),CHtml::encode('No existen puestos en esa unidad.'),true);
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