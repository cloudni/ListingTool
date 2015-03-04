<?php
// change the following paths if necessary
$yii='C:\Program Files\yii\framework\yii.php';
//$yii='/home/ni/yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

//ENVIRONMENT setting
const ENVIRONMENT_LOCALDEVELOP=0;
const ENVIRONMENT_TESTING=1;
const ENVIRONMENT_PRODUCTION=2;

define('Environment', ENVIRONMENT_LOCALDEVELOP);

require_once(dirname(__FILE__) . '/protected/components/ExceptionHandler/ExceptionHandler.php');
$router = new ExceptionHandler();

require_once($yii);
Yii::createWebApplication($config)->run();

