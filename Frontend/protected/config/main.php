<?php

// uncomment the following to define a path alias
//Yii::setPathOfAlias('system','/home/ni/yii/framework');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
$config = array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Item Tool',

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
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123456',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
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
            'showScriptName'=>false,
            'urlSuffix'=>'.html',
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
            'enableProfiling'=>true,//CDbConnection::getStats() to show how much time used
            'enableParamLogging'=>true,//show log in page foot
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
                /*array(
                    'class'=>'CProfileLogRoute',
                    'levels'=>'error, warning',
                ),*/
                // uncomment the following to show log messages on web pages
                /*array(
                    'class'=>'CWebLogRoute',
                    'levels'=>'trace, info, error, warning',
                    //'categories' => 'system.db.*',
                ),*/
                /*array(
                    'class'=>'CDbLogRoute',
                    'logTableName'=>'lt_applog',
                    'connectionID'=>'db',
                ),*/
			),
		),
        'session' => array (
            'class' => 'system.web.CDbHttpSession',
            'connectionID' => 'db',
            'sessionTableName' => 'lt_session',
        ),
        'authManager'=>array(
            'class'=>'CDbAuthManager',
            'connectionID'=>'db',
            'itemTable'=>'lt_AuthItem',
            'itemChildTable'=>'lt_AuthItemChild',
            'assignmentTable'=>'lt_AuthAssignment',
        ),
        'cache'=>array(
            'class'=>'system.caching.CDummyCache',
            /*'class'=>'system.caching.CMemCache',
            'servers'=>array(
                array('host'=>'192.168.0.156', 'port'=>11211, 'weight'=>60),
            ),*/
        ),
	),

	'theme'=>'facebook',

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
        'signInDisplayVerificationCode'=>false,
        'signUpDisplayVerificationCode'=>false,
        'pageSize'=>20,
        'sitePrivateKey'=>'php_front_site_1',
	),
    'language'=>'zh_cn',
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

$google =  require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'google.php');
if (!empty($google)) {
    $config['params']['google'] = $google;
}

$wish =  require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'wish.php');
if (!empty($wish)) {
    $config['params']['wish'] = $wish;
}

return $config;