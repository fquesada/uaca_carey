<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Gestión por Competencias',

	// preloading 'log' component
	'preload'=>array('log'),
        'sourceLanguage' => 'en',
        'language' => 'es',

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
                //'application.modules.rights.*', 
		//'application.modules.rights.components.*',
                'application.components.jpgraph.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'uaca',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
            
//                'rights'=>array( 
//                    'superuserName'=>'admin',                    
//                    'authenticatedName'=>'Authenticated',
//                    'userClass' => 'Usuario',
//                    'userIdColumn'=>'id',
//                    'userNameColumn'=>'login',                    
//                    
//                    'install'=>false),

	),
        
        'homeUrl'=>array('site/login'),
	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
                        'loginUrl'=>array('site/login'),
                        //'class'=>'RWebUser',
		),
                //'authManager'=>array( 'class'=>'RDbAuthManager'),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
//		'db'=>array(
//			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
//		),
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=uacasec',
			'emulatePrepare' => true,
			'username' => 'root',
			//'password' => 'dbUACAsecadmin13!',
			'charset' => 'utf8',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
                                array(
                                    'class'=>'CFileLogRoute',
                                    'levels'=>'info, trace',
                                    'logFile'=>'info.log',
                                ),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
        
);
