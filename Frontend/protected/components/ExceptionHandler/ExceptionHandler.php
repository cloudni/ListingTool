<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-12-20
 * Time: 1:00am
 */

class ExceptionHandler
{
    public function __construct()
    {
        define('YII_ENABLE_EXCEPTION_HANDLER',false);
        //define('YII_ENABLE_ERROR_HANDLER',false);
        set_exception_handler(array($this,'handleException'));
    }

    public function handleException($exception)
    {
        // disable error capturing to avoid recursive errors
        restore_error_handler();
        restore_exception_handler();

        $event=new CExceptionEvent($this,$exception);
        if($exception instanceof CHttpException)
        {
            try
            {
                Yii::app()->runController("site/error");
            }
            catch(Exception $e) {}
        }
        elseif($exception instanceof CDbException)
        {
            if($exception->getCode()>=2000)
            echo('Unrecoverable exception happened, Please try again!<br />Code: '.$exception->getCode());die();
            //var_dump($exception);die();
            try
            {
                Yii::app()->runController("site/error");
            }
            catch(CException $e) {}
        }
        else
        {
            Yii::app()->user->setFlash('Error', $exception->__toString());
            //$redirectURL = $exception->getRedirectURL();
            if(!empty($redirectURL))
            {
                try
                {
                    Yii::app()->runController($redirectURL);exit;
                }
                catch(Exception $e) {}
            }
            else
                Yii::app()->runController("site/error");
        }

        if(!$event->handled)
        {
            Yii::app()->handleException($exception);
        }
    }
}