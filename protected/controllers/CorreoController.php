<?php

class CorreoController extends Controller
{
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
    
    	public function actionEnviarEvaluacion()
	{
            
            $model=new Correo;
		if(isset($_POST['Correo']))
		{
			$model->attributes=$_POST['Correo'];
                        
			if($model->validate())
			{
                                $correo = new YiiMailer();
                                $correo->setView('contact');
                                $correo->setData(array('message' => $model->mensaje , 'name' => $model->destinatario, 'description' => 'Evaluación de Colaboradores'));
				
                                //set properties
                                $correo->setFrom('willcha9019@hotmail.com', 'William Chacón C.');
                                $correo->setSubject($model->asunto);
                                $correo->setTo($model->destinatario);

                                //envio
                                if ($correo->send()) {
                                        Yii::app()->user->setFlash('contact','Gracias por darnos su opinión.');
                                } else {
                                        Yii::app()->user->setFlash('error','Error: '.$correo->getError());
                                }
			}
		}
                
		$this->render('correoevaluacion',array('model'=>$model));
                        
        }
}