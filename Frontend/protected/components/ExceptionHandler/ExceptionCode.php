<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-11-28
 * Time: 2:15pm
 */

require_once("HttpStatus.php");

class ExceptionCode
{
    /***eBay trading API exception error code start from 200000***/
    const NonInputErrorCode=200001;
    /***eBay trading API exception error code end to 299999***/


    public static function getExceptionCodeOption()
    {
        return array(
            self::NonInputErrorCode=>'No input parameter found!',
        );
    }

    public static function getExceptionCodeText($errorCode)
    {
        $exceptionErrors = self::getExceptionCodeOption();
        return isset($exceptionErrors[$errorCode]) ? $exceptionErrors[$errorCode] : "Unknown Exception Code ($errorCode)";
    }
}

class CustomException extends Exception
{
    protected $redirectURL;

    public function __construct($message="", $code=0, $redirectURL="")
    {
        parent::__construct($message, $code);
        $this->redirectURL=$redirectURL;

        if(empty($this->redirectURL))
            throw new CHttpException(HttpStatus::STATUS_500, $this->message, $this->code);
    }

    public function __toString()
    {
        return "Error: [{$this->code}], {$this->message}\n";
    }

    public function getRedirectURL()
    {
        return $this->redirectURL;
    }
}