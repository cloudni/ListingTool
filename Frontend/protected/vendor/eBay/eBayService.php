<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-10-31
 * Time: 11:38pm
 */

Yii::import('application.vendor.*');
require_once("reference.php");
require_once("LogFile.php");

class eBayService
{
    public $httpHead;
    public $post_data;
    public $api_url;
    protected $callName = "";

    function __construct()
    {
        $this->httpHead = "1";
        $this->post_data = "";
        $this->api_url = "";
    }

    /*
    * Create a xml element.
    * demo:<ItemID comp="ebay:geturl">110098022988</ItemID>
    */
    public static function createXMLElement($name,$value,$name_extension='')
    {
        $str = '';
        if(!empty($name))
        {
            if(!empty($name_extension))
            {
                $str = '<'.$name.' '.$name_extension.'>'.$value.'</'.$name.'>';
            }
            else
            {
                $str = '<'.$name.'>'.$value.'</'.$name.'>';
            }
        }

        return $str;
    }

    /*
	 * Return ebay auth header.
	 */
    public function getRequestAuthHead($token=NULL,$CALLNAME=NULL)
    {
        if(!$CALLNAME) return false;

        $this->callName = $CALLNAME;
        // XML Request
        $post_data = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
        //start config callname
        $post_data .= "<".$CALLNAME."Request xmlns='urn:ebay:apis:eBLBaseComponents'>";
        if(isset($token))
        {
            $post_data .= "<RequesterCredentials>";
            $post_data .= "<eBayAuthToken>";
            $post_data .= $token;
            $post_data .= "</eBayAuthToken>";
            $post_data .= "</RequesterCredentials>";
        }

        return $post_data;
    }

    public function getRequestAuthHeadAPIKey($devID=NULL,$AppID=null, $certID=null, $CALLNAME=NULL)
    {
        if(!$devID || !$AppID || !$certID || !$CALLNAME) return false;
        // XML Request
        $post_data = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
        //start config callname
        $post_data .= "<".$CALLNAME."Request xmlns='urn:ebay:apis:eBLBaseComponents'>";
        if(isset($token))
        {
            $post_data .= "<RequesterCredentials>";
            $post_data .= "<DevId>$devID</DevId>";
            $post_data .= "<AppId>$AppID</AppId>";
            $post_data .= "<AuthCert>$certID</AuthCert>";
            $post_data .= "</RequesterCredentials>";
        }

        return $post_data;
    }

    /*
	 * return ebay auth footer
	 */
    public function getRequestAuthFoot($CALLNAME)
    {
        if(!$CALLNAME) return false;
        return "</".$CALLNAME."Request>";
    }

    /*
	 * Method: create ebay xml head
	 * return array.
	 */
    public function createHTTPHead($SITEID=0, $COMPATIBILITYLEVEL=893, $DEVID=NULL, $APPID=NULL, $CERTID=NULL, $CALLNAME=NULL)
    {
        if(intval($COMPATIBILITYLEVEL)<0 || !$DEVID || !$APPID || !$CERTID || !$CALLNAME || $SITEID<0) return false;

        $this->httpHead = array(
            "X-EBAY-API-COMPATIBILITY-LEVEL:".$COMPATIBILITYLEVEL,
            "X-EBAY-API-VERSION:".$COMPATIBILITYLEVEL,
            "X-EBAY-API-DEV-NAME:".$DEVID,
            "X-EBAY-API-APP-NAME:".$APPID,
            "X-EBAY-API-CERT-NAME:".$CERTID,
            "X-EBAY-API-CALL-NAME:".$CALLNAME,
            "X-EBAY-API-SITEID:".($SITEID == eBaySiteIdCodeType::eBayMotors ? eBaySiteIdCodeType::US : $SITEID),
            "X-EBAY-API-REQUEST-ENCODING:XML",
            "Content-Type : text/xml",
            "X-EBAY-API-DETAIL-LEVEL: 0",
            //"X-EBAY-API-SESSION-CERTIFICATE: $SESSIONCERTIFICATE",
        );
        if(!empty($SITEID)) $this->httpHead[] = "X-EBAY-API-SITEID:".($SITEID == eBaySiteIdCodeType::eBayMotors ? eBaySiteIdCodeType::US : $SITEID);
    }

    public function request($returnXML=false)
    {
        if(empty($this->api_url) or empty($this->httpHead) or empty($this->post_data) ) return false;

        $ch = curl_init();
        $res= curl_setopt($ch, CURLOPT_URL,$this->api_url);  //SET API  URL.

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0); // 0 = Don't give me the return header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->httpHead); // Set this for eBayAPI
        curl_setopt($ch, CURLOPT_POST, 1); // POST Method
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->post_data); //My XML post fild Request
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);     //return as string.
        curl_setopt($ch, CURLOPT_TIMEOUT, 60*15);

        $time = date("Ymd.his", time());
        if(Yii::app()->params['ebay']['logRequest'])
            LogFile::saveLogFile($this->callName.'.'.$time.'_request.xml', Yii::app()->params['ebay']['logPath'] . DIRECTORY_SEPARATOR . 'xml', preg_replace("/<eBayAuthToken>\S*<\/eBayAuthToken>/is", "<eBayAuthToken>******</eBayAuthToken>", $this->post_data));

        try
        {
            $body = curl_exec ($ch); //Send the request

            curl_close ($ch); // Close the connection
        }
        catch(Exception $ex)
        {
            echo "eBay API call returned exception\nException code: ".$ex->getCode().", msg: ".$ex->getMessage()."\n";
            return false;
        }

        if(Yii::app()->params['ebay']['logRequest'])
            LogFile::saveLogFile($this->callName.'.'.$time.'_response.xml', Yii::app()->params['ebay']['logPath'] . DIRECTORY_SEPARATOR . 'xml', $body);

        if($body)
        {
            //var_dump($this->post_data, $body);
            $body = preg_replace("/<([a-zA-Z]*)\s([a-zA-Z]*)=\"([a-zA-Z0-9\.]*)\">([a-zA-Z0-9\.]*)<\/([a-zA-Z]*)>/is", "<$1><$2>$3</$2><Value>$4</Value></$5>", $body);
            $body = preg_replace("/<([a-zA-Z]*)\s([a-zA-Z]*)=\"([a-zA-Z0-9\.]*)\">/is", "<$1><$2>$3</$2>", $body);

            if(Yii::app()->params['ebay']['logRequest'])
                LogFile::saveLogFile($this->callName.'.'.$time.'_response_processed.xml', Yii::app()->params['ebay']['logPath'] . DIRECTORY_SEPARATOR . 'xml', $body);

            try
            {
                set_error_handler(array($this, 'simpleXMLErrorHandler'));
                $body = $returnXML ? $body : simplexml_load_string($body);
                restore_error_handler();
                return $body;
            }
            catch(Exception $ex)
            {
                echo "error when transfer xml to object\nException code: ".$ex->getCode().", msg: ".$ex->getMessage()."\n";
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    protected function simpleXMLErrorHandler($error_level,$error_message)
    {
        restore_error_handler();
        $info= "Error Level: $error_level, Error Msg: $error_message\n";
        throw new Exception($info);
    }
} 