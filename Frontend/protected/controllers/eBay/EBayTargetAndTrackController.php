<?php

Yii::import('application.vendor.eBay.*');
require_once 'reference.php';

class EBayTargetAndTrackController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete, searcheBayItemShoppingAPI, trackingSubmit', // we only allow deletion via POST request
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
				'actions'=>array('create','update', 'delete', 'searcheBayItemShoppingAPI', 'trackingSubmit'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new eBayTargetAndTrack;

        $this->layout='';

		$this->render('create',array(
			'model'=>$model,
		));

        $this->layout='//layouts/column2';
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

        $eBayEntityType = eBayEntityType::model()->find('entity_model=:entity_model', array(':entity_model'=>'eBayListing'));
        $eBayAttributeSet = eBayAttributeSet::model()->find(
            'entity_type_id=:entity_type_id',
            array(
                ':entity_type_id'=>$eBayEntityType->id,
            )
        );

        $primaryCategoryAttribute = $eBayAttributeSet->getEntityAttribute("PrimaryCategory->CategoryID");
        $secondaryCategoryAttribute = $eBayAttributeSet->getEntityAttribute("SecondaryCategory->CategoryID");
        $mainSKUAttribute = $eBayAttributeSet->getEntityAttribute("SKU");
        $variationSKUAttribute = $eBayAttributeSet->getEntityAttribute("Variations->Variation->SKU");
        $listingDurationAttribute = $eBayAttributeSet->getEntityAttribute("ListingDuration");
        $listingTypeAttribute = $eBayAttributeSet->getEntityAttribute("ListingType");
        $titleAttribute = $eBayAttributeSet->getEntityAttribute("Title");
        $listingStatusAttribute = $eBayAttributeSet->getEntityAttribute("SellingStatus->ListingStatus");
        $viewUrlAttribute = $eBayAttributeSet->getEntityAttribute("ListingDetails->ViewItemURL");

        $select = "SELECT t.*, s.name as storename,
                            mainsku.value as msku,
                            pc.value as primarycate,
                            sc.value as secondarycate,
                            duration.value as listduration,
                            ltype.value as listtype,
                            title.value as title,
                            vurl.value as viewurl
                            FROM `lt_ebay_listing` `t`
                            left join lt_ebay_entity_varchar as mainsku on mainsku.ebay_entity_id = t.id and mainsku.ebay_entity_attribute_id = {$mainSKUAttribute->id}
                            left join lt_ebay_entity_varchar as pc on pc.ebay_entity_id = t.id and pc.ebay_entity_attribute_id = {$primaryCategoryAttribute->id}
                            left join lt_ebay_entity_varchar as sc on sc.ebay_entity_id = t.id and sc.ebay_entity_attribute_id = {$secondaryCategoryAttribute->id}
                            left join lt_ebay_entity_varchar as duration on duration.ebay_entity_id = t.id and duration.ebay_entity_attribute_id = {$listingDurationAttribute->id}
                            left join lt_ebay_entity_varchar as ltype on ltype.ebay_entity_id = t.id and ltype.ebay_entity_attribute_id = {$listingTypeAttribute->id}
                            left join lt_ebay_entity_varchar as title on title.ebay_entity_id = t.id and title.ebay_entity_attribute_id = {$titleAttribute->id}
                            left join lt_ebay_entity_varchar as sstatus on sstatus.ebay_entity_id = t.id and sstatus.ebay_entity_attribute_id = {$listingStatusAttribute->id}
                            left join lt_ebay_entity_varchar as vurl on vurl.ebay_entity_id = t.id and vurl.ebay_entity_attribute_id = {$viewUrlAttribute->id}
                            left join lt_store as s on s.id = t.store_id
                            where t.company_id=:company_id and t.id in ({$model->tracking_ebay_listing_id})
                            order by msku asc; ";
        $command = Yii::app()->db->createCommand($select);
        $command->bindValue(":company_id", Yii::app()->session['user']->company_id, PDO::PARAM_INT);
        $trackingList = $command->queryAll();

        $eBayEntityType = eBayEntityType::model()->find('entity_model=:entity_model', array(':entity_model'=>'eBayItemShoppingAPI'));
        $eBayAttributeSet = eBayAttributeSet::model()->find(
            'entity_type_id=:entity_type_id',
            array(
                ':entity_type_id'=>$eBayEntityType->id,
            )
        );

        $titleAttribute = $eBayAttributeSet->getEntityAttribute("Title");
        $siteAttribute = $eBayAttributeSet->getEntityAttribute("Site");
        $listingTypeAttribute = $eBayAttributeSet->getEntityAttribute("ListingType");
        $sellerAttribute = $eBayAttributeSet->getEntityAttribute("Seller->UserID");
        $currencyAttribute = $eBayAttributeSet->getEntityAttribute("CurrentPrice->currencyID");
        $priceAttribute = $eBayAttributeSet->getEntityAttribute("CurrentPrice->Value");

        $sql = "select t.*, title.value as title, site.value as site, ltype.value as listtype, seller.value as seller, currency.value as currency, price.value as price
                from lt_ebay_item_shopping_api t
                left join lt_ebay_third_party_varchar as title on title.ebay_entity_id = t.id and title.ebay_entity_attribute_id = {$titleAttribute->id}
                left join lt_ebay_third_party_varchar as site on site.ebay_entity_id = t.id and site.ebay_entity_attribute_id = {$siteAttribute->id}
                left join lt_ebay_third_party_varchar as ltype on ltype.ebay_entity_id = t.id and ltype.ebay_entity_attribute_id = {$listingTypeAttribute->id}
                left join lt_ebay_third_party_varchar as seller on seller.ebay_entity_id = t.id and seller.ebay_entity_attribute_id = {$sellerAttribute->id}
                left join lt_ebay_third_party_varchar as currency on currency.ebay_entity_id = t.id and currency.ebay_entity_attribute_id = {$currencyAttribute->id}
                left join lt_ebay_third_party_decimal as price on price.ebay_entity_id = t.id and price.ebay_entity_attribute_id = {$priceAttribute->id}
                where t.ebay_listing_id in ({$model->target_ebay_item_id})";
        $command = Yii::app()->db->createCommand($sql);
        $targetList = $command->queryAll();

        $this->layout='';
		$this->render('update',array(
			'model'=>$model,
            'trackingList'=>$trackingList,
            'targetList'=>$targetList,
		));
        $this->layout='//layouts/column2';
	}

    public function actionSearcheBayItemShoppingAPI()
    {
        if(!isset($_POST['id']))
        {
            $result = array('status'=>'fail', 'data'=>"Please input eBay item id to search.");
            echo json_encode($result);
            exit();
        }
        $id = (string)$_POST['id'];
        $eBayItemShoppingAPI = eBayItemShoppingApi::model()->find('ebay_listing_id=:ebay_listing_id', array(':ebay_listing_id'=>(string)$id));
        if(empty($eBayItemShoppingAPI))
        {
            if(!eBayShoppingAPI::GetItem(array($id)))
            {
                $result = array('status'=>'fail', 'data'=>"Fail to get this item from eBay.");
                echo json_encode($result);
                exit();
            }
        }

        $eBayEntityType = eBayEntityType::model()->find('entity_model=:entity_model', array(':entity_model'=>'eBayItemShoppingAPI'));
        if(empty($eBayEntityType))
        {
            $result = array('status'=>'fail', 'data'=>"Internal Error, unknown data object structure.");
            echo json_encode($result);exit();
        }
        $eBayAttributeSet = eBayAttributeSet::model()->find(
            'entity_type_id=:entity_type_id',
            array(
                ':entity_type_id'=>$eBayEntityType->id,
            )
        );
        if(empty($eBayAttributeSet))
        {
            $result = array('status'=>'fail', 'data'=>"Internal Error, unknown data object structure.");
            echo json_encode($result);exit();
        }

        try
        {
            $titleAttribute = $eBayAttributeSet->getEntityAttribute("Title");
            $siteAttribute = $eBayAttributeSet->getEntityAttribute("Site");
            $listingTypeAttribute = $eBayAttributeSet->getEntityAttribute("ListingType");
            $sellerAttribute = $eBayAttributeSet->getEntityAttribute("Seller->UserID");
            $currencyAttribute = $eBayAttributeSet->getEntityAttribute("CurrentPrice->currencyID");
            $priceAttribute = $eBayAttributeSet->getEntityAttribute("CurrentPrice->Value");

            $sql = "select t.*, title.value as title, site.value as site, ltype.value as listtype, seller.value as seller, currency.value as currency, price.value as price
                from lt_ebay_item_shopping_api t
                left join lt_ebay_third_party_varchar as title on title.ebay_entity_id = t.id and title.ebay_entity_attribute_id = {$titleAttribute->id}
                left join lt_ebay_third_party_varchar as site on site.ebay_entity_id = t.id and site.ebay_entity_attribute_id = {$siteAttribute->id}
                left join lt_ebay_third_party_varchar as ltype on ltype.ebay_entity_id = t.id and ltype.ebay_entity_attribute_id = {$listingTypeAttribute->id}
                left join lt_ebay_third_party_varchar as seller on seller.ebay_entity_id = t.id and seller.ebay_entity_attribute_id = {$sellerAttribute->id}
                left join lt_ebay_third_party_varchar as currency on currency.ebay_entity_id = t.id and currency.ebay_entity_attribute_id = {$currencyAttribute->id}
                left join lt_ebay_third_party_decimal as price on price.ebay_entity_id = t.id and price.ebay_entity_attribute_id = {$priceAttribute->id}
                where t.ebay_listing_id = :ebay_listing_id";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindValue(":ebay_listing_id", (string)$id, PDO::PARAM_STR);
            $listing = $command->queryRow();

            $result = array('status' => 'success', 'data' => $listing);
            echo json_encode($result);
        }
        catch(Exception $ex)
        {
            $result = array('status'=>'fail', 'data'=>"Error Code: ".$ex->getCode().", ".$ex->getMessage());
            echo json_encode($result);exit();
        }
    }

    public function actionTrackingSubmit()
    {
        $error = "";
        if(!isset($_POST['target_track_name']) || empty($_POST['target_track_name']))
            $error .= "Please input plan's name.<br />";
        else
            $name = (string)$_POST['target_track_name'];
        if(!isset($_POST['applied_listings_value']) || empty($_POST['applied_listings_value']))
            $error .= "Please select eBay Listings to track.<br />";
        else
            $appliedListings = $_POST['applied_listings_value'];
        if(!isset($_POST['target_ebay_item_id']) || empty($_POST['target_ebay_item_id']))
            $error .= "Please input any target eBay Item.<br />";
        else
            $targetItems = $_POST['target_ebay_item_id'];
        $updatePriceTarget = $_POST['update_price_target'];
        $updatePriceAction = $_POST['update_price_action'];
        $updatePriceValue = "";
        $updatePriceNotificationOnly = false;
        if(!isset($_POST['update_price_notification_only']))
        {
            if(!isset($_POST['update_price_value']) || empty($_POST['update_price_value']))
                $error .= "Please input price update value.<br />";
            else
                $updatePriceValue = $_POST['update_price_value'];
        }
        else
        {
            $updatePriceNotificationOnly = true;
        }
        $updatePriceType = $_POST['update_price_type'];
        $updatePriceValueHighest = $_POST['update_price_value_highest'];
        $updatePriceValueLowest = empty($_POST['update_price_value_lowest']) ? 0.01 : $_POST['update_price_value_lowest'];

        if($error)
        {
            Yii::app()->user->setFlash('Error', $error);
            if(!isset($_POST['target_track_object_id']) || empty($_POST['target_track_object_id']))
                $this->redirect($this->createAbsoluteUrl("eBay/eBayTargetAndTrack/create", array()));
            else
                $this->redirect($this->createAbsoluteUrl("eBay/eBayTargetAndTrack/update/id/".$_POST['target_track_object_id'], array()));
        }


        $eBayTargetAndTrack = null;
        if(!isset($_POST['target_track_object_id']) || empty($_POST['target_track_object_id']))
        {
            $eBayTargetAndTrack = new eBayTargetAndTrack();
        }
        else
        {
            $eBayTargetAndTrack = eBayTargetAndTrack::model()->findByPk((int)$_POST['target_track_object_id']);
            if(empty($eBayTargetAndTrack)) $eBayTargetAndTrack = new eBayTargetAndTrack();
        }

        $eBayTargetAndTrack->name = $name;
        $eBayTargetAndTrack->company_id = Yii::app()->session['user']->company_id;
        $eBayTargetAndTrack->target_ebay_item_id = implode(',', $targetItems);
        $eBayTargetAndTrack->tracking_ebay_listing_id = implode(',', $appliedListings);
        $eBayTargetAndTrack->update_param = json_encode(array('price'=>array(
            'target'=>(string)$updatePriceTarget,
            'action'=>(string)$updatePriceAction,
            'value'=> $updatePriceValue != "" ? (float)$updatePriceValue : "",
            'highest_value'=>floatval($updatePriceValueHighest),
            'lowest_value'=>floatval($updatePriceValueLowest),
            'notification_only'=>$updatePriceNotificationOnly,
            'type'=>(string)$updatePriceType,
        )));
        if($eBayTargetAndTrack->isNewRecord) $eBayTargetAndTrack->is_active = eBayTargetAndTrack::ACTIVE_YES;
        if($eBayTargetAndTrack->save())
        {
            $this->redirect($this->createAbsoluteUrl("eBay/eBayTargetAndTrack/view", array('id'=>$eBayTargetAndTrack->id)));
            return;
        }
        else
        {
            Yii::app()->user->setFlash('Error', 'Internal error happened, Please try again!');
            $this->redirect($this->createAbsoluteUrl("eBay/eBayTargetAndTrack/create", array()));
        }
    }

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('eBayTargetAndTrack');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new eBayTargetAndTrack('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['eBayTargetAndTrack']))
			$model->attributes=$_GET['eBayTargetAndTrack'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return eBayTargetAndTrack the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=eBayTargetAndTrack::model()->findByPk($id, "company_id=:company_id" ,array(':company_id' => Yii::app()->session['user']->company_id));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param eBayTargetAndTrack $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='e-bay-target-and-track-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
