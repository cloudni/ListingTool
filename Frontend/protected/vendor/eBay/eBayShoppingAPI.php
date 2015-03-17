<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/3/16
 * Time: 22:20
 */

Yii::import('application.vendor.*');
require_once("reference.php");
require_once("eBayService.php");
Yii::import('application.components.*');
require_once("ExceptionHandler/ExceptionCode.php");

class eBayShoppingAPI
{
    const Prod_API_URL = 'http://open.api.ebay.com/shopping';
    const Sandbox_API_URL = 'http://open.api.sandbox.ebay.com/shopping';

    public static function GetItem($params=array('includeSelector'=>array(eBayIncludeSelectorCodeType::Details, eBayIncludeSelectorCodeType::Description, eBayIncludeSelectorCodeType::ItemSpecifics, eBayIncludeSelectorCodeType::Variations), 'itemID'=>array('400844296652')))
    {
        if(empty($params['itemID'])) return false;

        $eBayAPIKey = eBayApiKey::model()->findByPk(6);
        if(empty($eBayAPIKey)) return false;

        $eBayService = new eBayService();
        $eBayService->post_data = $eBayService->getRequestAuthHead(null, "GetMultipleItems").eBayShoppingAPI::GetMultipleItemsXML($params).$eBayService->getRequestAuthFoot("GetMultipleItems");
        $eBayService->api_url = self::Prod_API_URL;
        $eBayService->createHTTPHead(null, $eBayAPIKey->compatibility_level, $eBayAPIKey->dev_id, $eBayAPIKey->app_id, $eBayAPIKey->cert_id, "GetMultipleItems");

        try
        {
            $result = $eBayService->request();
            var_dump($result);
        }
        catch(Exception $ex)
        {
            var_dump($ex);
            return array(
                'ErrorCode'=>$ex->getCode(),
                'ShortMessage'=>$ex->getMessage(),
            );
        }
        return true;
    }

    protected static function GetMultipleItemsXML($params)
    {
        $xml = '';

        if(empty($params) || empty($params['itemID'])) return $xml;

        if(!empty($params['includeSelector']))
        {
            if(count($params['includeSelector'])>1)
                $xml .= eBayService::createXMLElement('IncludeSelector', implode(",", $params['includeSelector']));
            else
                $xml .= eBayService::createXMLElement('IncludeSelector', $params['includeSelector']);
        }

        foreach($params['itemID'] as $item)
        {
            $xml .= eBayService::createXMLElement('ItemID',$item);
        }

        return $xml;
    }
}