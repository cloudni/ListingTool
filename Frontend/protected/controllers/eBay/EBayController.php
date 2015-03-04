<?php

Yii::import('application.vendor.eBay.*');
require_once 'reference.php';

class EBayController extends Controller
{
    public $layout='//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('index','view'),
                'users'=>array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('create','update'),
                'users'=>array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('admin','delete'),
                'users'=>array('admin'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $criteria= new CDbCriteria();
        $criteria->join = "left join {{ebay_entity_type}} et on et.id = t.entity_type_id";
        $criteria->condition = "t.is_active = 1 and et.entity_model = 'eBayUser'";
        $eBayUserAttributeSet = eBayAttributeSet::model()->find($criteria);
        if(empty($eBayUserAttributeSet)) throw new CHttpException(404,'The requested page does not exist.');

        $criteria= new CDbCriteria();
        $criteria->join = "left join {{ebay_entity_type}} et on et.id = t.entity_type_id";
        $criteria->condition = "t.is_active = 1 and et.entity_model = 'eBaySellerDashboard'";
        $eBaySellerDashboardAttributeSet = eBayAttributeSet::model()->find($criteria);
        if(empty($eBaySellerDashboardAttributeSet)) throw new CHttpException(404,'The requested page does not exist.');

        /*Get User attribute*/
        $feedbackScoreAttribute = $eBayUserAttributeSet->getEntityAttribute('FeedbackScore');
        $positiveFeedbackPercentScoreAttribute = $eBayUserAttributeSet->getEntityAttribute('PositiveFeedbackPercent');
        $feedbackRatingStarAttribute = $eBayUserAttributeSet->getEntityAttribute('FeedBackRatingStar');
        $eBayGoodStandingAttribute = $eBayUserAttributeSet->getEntityAttribute('eBayGoodStanding');
        $userIDAttribute = $eBayUserAttributeSet->getEntityAttribute('UserID');
        $storeURLAttribute = $eBayUserAttributeSet->getEntityAttribute('SellerInfo->StoreURL');
        $uniquePositiveFeedbackAttribute = $eBayUserAttributeSet->getEntityAttribute('UniquePositiveFeedbackCount');
        $uniqueNeutralFeedbackAttribute = $eBayUserAttributeSet->getEntityAttribute('UniqueNeutralFeedbackCount');
        $uniqueNegativeFeedbackAttribute = $eBayUserAttributeSet->getEntityAttribute('UniqueNegativeFeedbackCount');
        $eBaySubscriptionAttribute = $eBayUserAttributeSet->getEntityAttribute('EBaySubscription');
        $topRatedSellerAttribute = $eBayUserAttributeSet->getEntityAttribute('SellerInfo->TopRatedSeller');
        $topRatedProgramAttribute = $eBayUserAttributeSet->getEntityAttribute('SellerInfo->TopRatedSellerDetails->TopRatedProgram');

        /*Get Seller Dashboard attribute*/
        $sellerFeeDiscountAttribute = $eBaySellerDashboardAttributeSet->getEntityAttribute('SellerFeeDiscount->Percent');
        $powerSellerStatusAttribute = $eBaySellerDashboardAttributeSet->getEntityAttribute('PowerSellerStatus->Level');
        //$performanceAttribute = $eBaySellerDashboardAttributeSet->getEntityAttribute('Performance');

        $sql = "select fbs.value as feedbackscore, pfbp.value as positivefeedbackpercent, fbrs.value as feedbackratingstar,
                egs.value as ebaygoodstanding, ui.value as userid, surl.value as storeurl,
                upf.value as positivefeedback, unf.value as neutralfeedback, unegaf.value as negativefeedback,
                es.value as ebaysubscription,
                trs.value as topratedseller, trp.value as topratedprogram,
                sellerdashboard.id as sellerdashboardid,
                pss.value as powersellerstatus, sfdd.value as sellerfeediscount,
                t.*
                from lt_store t
                /*user*/
                left join lt_ebay_user as seller on seller.store_id = t.id
                left join lt_ebay_entity_int as fbs on fbs.ebay_entity_id = seller.id and fbs.ebay_entity_attribute_id = {$feedbackScoreAttribute->id}
                left join lt_ebay_entity_decimal as pfbp on pfbp.ebay_entity_id = seller.id and pfbp.ebay_entity_attribute_id = {$positiveFeedbackPercentScoreAttribute->id}
                left join lt_ebay_entity_varchar as fbrs on fbrs.ebay_entity_id = seller.id and fbrs.ebay_entity_attribute_id = {$feedbackRatingStarAttribute->id}
                left join lt_ebay_entity_boolean as egs on egs.ebay_entity_id = seller.id and egs.ebay_entity_attribute_id = {$eBayGoodStandingAttribute->id}
                left join lt_ebay_entity_varchar as ui on ui.ebay_entity_id = seller.id and ui.ebay_entity_attribute_id = {$userIDAttribute->id}
                left join lt_ebay_entity_varchar as surl on surl.ebay_entity_id = seller.id and surl.ebay_entity_attribute_id = {$storeURLAttribute->id}
                left join lt_ebay_entity_int as upf on upf.ebay_entity_id = seller.id and upf.ebay_entity_attribute_id = {$uniquePositiveFeedbackAttribute->id}
                left join lt_ebay_entity_int as unf on unf.ebay_entity_id = seller.id and unf.ebay_entity_attribute_id = {$uniqueNeutralFeedbackAttribute->id}
                left join lt_ebay_entity_int as unegaf on unegaf.ebay_entity_id = seller.id and unegaf.ebay_entity_attribute_id = {$uniqueNegativeFeedbackAttribute->id}
                left join (
                    SELECT ebay_entity_id, group_concat(`value` separator ', ') as value, ebay_entity_type_id
                    FROM lt_ebay_entity_varchar
                    where ebay_entity_attribute_id = {$eBaySubscriptionAttribute->id} and ebay_entity_type_id = {$eBayUserAttributeSet->entity_type_id}
                    group by ebay_entity_id
                ) as es on es.ebay_entity_id = seller.id
                left join lt_ebay_entity_boolean as trs on trs.ebay_entity_id = seller.id and trs.ebay_entity_attribute_id = {$topRatedSellerAttribute->id}
                left join (
                    SELECT ebay_entity_id, group_concat(`value` separator ', ') as value, ebay_entity_type_id
                    FROM lt_ebay_entity_varchar
                    where ebay_entity_attribute_id = {$topRatedProgramAttribute->id} and ebay_entity_type_id = {$eBayUserAttributeSet->entity_type_id}
                    group by ebay_entity_id
                ) as trp on trp.ebay_entity_id = seller.id
                /*seller dashboard*/
                left join lt_ebay_seller_dashboard as sellerdashboard on sellerdashboard.store_id = t.id
                left join lt_ebay_entity_varchar as pss on pss.ebay_entity_id = sellerdashboard.id and pss.ebay_entity_attribute_id = {$powerSellerStatusAttribute->id}
                left join lt_ebay_entity_decimal as sfdd on sfdd.ebay_entity_id = sellerdashboard.id and sfdd.ebay_entity_attribute_id = {$sellerFeeDiscountAttribute->id}

                where t.platform = ".Store::PLATFORM_EBAY." and t.is_active = ".Store::ACTIVE_YES." and company_id = ".Yii::app()->session['user']->company_id." ";
//var_dump($sql);die();
        $rawData=Yii::app()->db->createCommand($sql)->queryAll();

        $dataProvider=new CArrayDataProvider($rawData, array(
            'id'=>'id',
            'sort'=>array(
                'attributes'=>array(
                    'id'
                ),
            ),
            'pagination'=>array(
                'pageSize'=>25,
            ),
        ));

        $this->render('index', array(
            'dataProvider'=>$dataProvider,
        ));
    }
}