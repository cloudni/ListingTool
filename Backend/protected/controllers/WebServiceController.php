<?php

Yii::import('application.vendor.eBay.*');
require_once 'eBayTradingAPI.php';
require_once 'reference.php';

class WebServiceController extends Controller
{
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/

    public function actions()
    {
        return array(
            'quote'=>array(
                'class'=>'CWebServiceAction',
            ),
        );
    }

    /**
     * @param string eBay listing id
     * @param string the store id
     * @param string the company id
     * @return array success or fail with msg
     * @soap
     */
    public function eBayGetItem($listing_id, $store_id, $company_id)
    {
        if(!$store_id) return array('status'=>'fail', 'msg'=>'store id is invalid.');

        if(!$company_id) return array('status'=>'fail', 'msg'=>'company id is invalid.');

        $list = eBayListing::model()->find("ebay_listing_id=:ebay_listing_id and store_id=:store_id and company_id=:company_id", array(":ebay_listing_id"=>$listing_id, ":store_id"=>$store_id, ":company_id"=>$company_id));

        if(empty($list))
        {
            $list = new eBayListing();
            $list->store_id = $store_id;
            $list->ebay_listing_id = (string)$listing_id;
            $list->company_id = $company_id;
        }
        if(eBayTradingAPI::GetItem($list))
            return array('status'=>'success', 'msg'=>"$listing_id has been updated.");
        else
            return array('status'=>'fail', 'msg'=>"fail to update $listing_id.");
    }
}