<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
$console = array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'ListingTool Admin Console Application',

	// preloading 'log' component
	'preload'=>array('log'),

    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.components.*',
        'application.extensions.*',
        'application.vendor.*',
    ),

	// application components
	'components'=>array(
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
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
        'session' => array (
            'class' => 'system.web.CDbHttpSession',
            'connectionID' => 'db',
            'sessionTableName' => 'lt_session_admin',
        ),
	),
);

//add parameters for eBay API calls
$ebay =  require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'ebay.php');
if (!empty($ebay)) {
    $console['params']['ebay'] = $ebay;
}
$bulletin =  require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'bulletin.php');
if (!empty($bulletin)) {
    $console['params']['bulletin'] = $bulletin;
}

return $console;