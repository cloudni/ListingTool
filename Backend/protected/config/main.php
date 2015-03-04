<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
$config = array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'Item Tool Manage',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
        'application.extensions.*',
        'application.vendor.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		/*'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123456',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),*/
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
            'urlFormat'=>'path',
            'showScriptName'=>'false',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		// uncomment the following to use a MySQL database
		'db'=>array(
            'connectionString' => 'mysql:host=127.0.0.1;dbname=listtool',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '123456',
			'charset' => 'utf8',
            'tablePrefix'=>"lt_",
            'charset'=>'utf8',
            'enableProfiling'=>true,
            'enableParamLogging'=>true,
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
                    /*array(
                        'class'=>'CFileLogRoute',
                        'levels'=>'error, warning',
                    ),*/
                    /*array(
                        'class'=>'CProfileLogRoute',
                        'levels'=>'error, warning',
                    ),*/
                    // uncomment the following to show log messages on web pages
                    /*array(
					    'class'=>'CWebLogRoute',
                        'levels'=>'trace, info, error, warning',
                        'categories' => 'system.db.*',
				    ),*/
                array(
                    'class'=>'CDbLogRoute',
                    'logTableName'=>'lt_applog',
                    'connectionID'=>'db',
                ),
			),
		),
        'session' => array (
            'class' => 'system.web.CDbHttpSession',
            'connectionID' => 'db',
            'sessionTableName' => 'lt_session_admin',
        ),
        'authManager'=>array(
            'class'=>'CDbAuthManager',
            'connectionID'=>'db',
            'itemTable'=>'lt_AuthItem',
            'itemChildTable'=>'lt_AuthItemChild',
            'assignmentTable'=>'lt_AuthAssignment',
        ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
        'displayVerifyCode'=>false,
        'pageSize'=>20,
	),
);

//add parameters for eBay API calls
$ebay =  require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'ebay.php');
if (!empty($ebay)) {
    $config['params']['ebay'] = $ebay;
}
$bulletin =  require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'bulletin.php');
if (!empty($bulletin)) {
    $config['params']['bulletin'] = $bulletin;
}

return $config;