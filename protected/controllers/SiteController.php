<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
        
        public function actionIndex()
	{
            $usuario = (Yii::app()->user->name);
            $modelo = Usuario::model()->findBySql('SELECT * FROM usuario u WHERE u.login = "'.$usuario.'" AND u.estado = 1;');
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		if(!Yii::app()->user->isGuest)
                {
                    if ($modelo->estadopassword == 1)
                    {
                    $this->render('index');
                    }
                    else 
                    {
                       $this->redirect('index.php/usuario/CambiarPass/'.$modelo->id); 
                    }
                }
                else 
                {
                    $this->redirect('index.php/site/login');
                }
	}
        
                public function actionAdministracion()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		if(!Yii::app()->user->isGuest)
                {
                    $this->render('administracion');
                }
                else 
                {
                    $this->redirect('http://localhost/uaca_carey/index.php/site/logout');
                }
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
        
        public function actioncrearusuarioprovisional(){
            
            if(isset($_POST['user'])&& isset($_POST['password'])){
                
                $usuario = new Usuario();
                
                $usuario->login = $_POST['user'];
                $usuario->password = crypt($_POST['password'], $usuario->getsalt());
                
                $usuario->empresa = 1;
                $usuario->fechacreacion = date("Y-m-d");               
                
                $result = $usuario->save();
                if($result){
                   $model=new LoginForm;
                   $this->redirect('login',array('model'=>$model));                   
                   }
                else
                    throw new CHttpException(500,'Fallo al intentar crear usuario provisional,verifique conexion BD o Codigo.');
            }
            
            $this->render('crearusuarioprovisional');
        }
}
