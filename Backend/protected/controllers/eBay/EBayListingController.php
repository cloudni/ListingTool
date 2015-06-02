<?php

class eBayListingController extends Controller
{
	public function actionIndex($id_page=1)
	{
        $company_id = isset($_POST['company_select']) && $_POST['company_select'] ? (int)$_POST['company_select'] : null;
        $store_id = isset($_POST['store_select']) && $_POST['store_select'] ? (int)$_POST['store_select'] : null;
        $listingStatus = isset($_POST['listing_status_select']) && $_POST['listing_status_select'] ? (string)$_POST['listing_status_select'] : null;
        $listingType = isset($_POST['listing_type_select']) && $_POST['listing_type_select'] ? (string)$_POST['listing_type_select'] : null;
        $siteId = isset($_POST['ebay_site_select']) ? (int)$_POST['ebay_site_select'] : 'all';
        $searchKeyword = isset($_POST['search_keyword']) && $_POST['search_keyword'] ? (int)$_POST['search_keyword'] : null;
        $id_page = isset($_POST['id_page']) && $_POST['id_page'] ? (int)$_POST['id_page'] : 1;

        $criteria= new CDbCriteria();
        $criteria->join = "left join {{ebay_entity_type}} et on et.id = t.entity_type_id";
        $criteria->condition = "t.is_active = 1 and et.entity_table = 'ebay_listing'";
        $eBayAttributeSet = eBayAttributeSet::model()->find($criteria);
        if(empty($eBayAttributeSet)) throw new CHttpException(404,'The requested page does not exist.');

        $statusAttribute = $eBayAttributeSet->getEntityAttribute('SellingStatus->ListingStatus');
        $soldQuantityAttribute = $eBayAttributeSet->getEntityAttribute('SellingStatus->QuantitySold');
        $listingTypeAttribute = $eBayAttributeSet->getEntityAttribute('ListingType');
        $listingDurationAttribute = $eBayAttributeSet->getEntityAttribute('ListingDuration');
        $viewItemURLAttribute = $eBayAttributeSet->getEntityAttribute('ListingDetails->ViewItemURL');
        $titleAttribute = $eBayAttributeSet->getEntityAttribute('Title');

        $sql = "SELECT eevls.value as listingtstatus, eevlt.value as listingtype, eevld.value as listingduration, eeisq.value as soldquantity,
                eevt.value as title, eevviu.value as viewitemurl,
                ls.name as storename, c.name as companyname,
                el.id, el.ebay_listing_id, el.site_id, el.update_time_utc, el.note
                FROM lt_ebay_listing el
                left join lt_store ls on ls.id = el.store_id
                left join lt_company c on c.id = el.company_id
                left join lt_ebay_entity_varchar eevls on eevls.ebay_entity_id = el.id and eevls.ebay_entity_attribute_id = {$statusAttribute->id} /*listing status*/
                left join lt_ebay_entity_varchar eevlt on eevlt.ebay_entity_id = el.id and eevlt.ebay_entity_attribute_id = {$listingTypeAttribute->id} /*listing type*/
                left join lt_ebay_entity_varchar eevld on eevld.ebay_entity_id = el.id and eevld.ebay_entity_attribute_id = {$listingDurationAttribute->id} /*listing duration*/
                left join lt_ebay_entity_int eeisq on eeisq.ebay_entity_id = el.id and eeisq.ebay_entity_attribute_id = {$soldQuantityAttribute->id} /*sold quantity*/
                left join lt_ebay_entity_varchar eevviu on eevviu.ebay_entity_id = el.id and eevviu.ebay_entity_attribute_id = {$viewItemURLAttribute->id} /*listing status*/
                left join lt_ebay_entity_varchar eevt on eevt.ebay_entity_id = el.id and eevt.ebay_entity_attribute_id = {$titleAttribute->id} /*listing status*/
                where 1=1 ";

        $where = "";
        if($listingStatus)
            $where .= " and eevls.`value`= '$listingStatus' ";
        if($listingType)
            $where .= " and eevlt.`value` = '$listingType' ";
        if($siteId != 'all')
            $where .= " and el.site_id = ".(int)$siteId." ";
        if($store_id)
            $where .= " and el.store_id = ".(int)$store_id." ";
        if($company_id)
            $where .= " and el.company_id = ".(int)$company_id." ";

        $rawData=Yii::app()->db->createCommand($sql.$where)->queryAll();
        $dataProvider=new CArrayDataProvider($rawData, array(
            'id'=>'id',
            'sort'=>array(
                'attributes'=>array(
                    //'el.id', 'soldquantity'
                ),
            ),
            'pagination'=>array(
                'pageSize'=>30,
                'currentPage'=>($id_page - 1),
            ),
        ));

		$this->render('index',array(
            'dataProvider'=>$dataProvider,
            'company_id'=>$company_id,
            'store_id'=>$store_id,
            'listingStatus'=>$listingStatus,
            'listingType'=>$listingType,
            'siteId'=>$siteId,
            'searchKeyword'=>$searchKeyword,
            'id_page'=>$id_page,
        ));
	}

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
}