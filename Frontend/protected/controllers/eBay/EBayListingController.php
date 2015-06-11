<?php

Yii::import('application.vendor.eBay.*');
require_once 'reference.php';

class EBayListingController extends Controller
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
			'postOnly + delete, bulkUpdateSubmit, searchAppliedListings, geteBayCategories', // we only allow deletion via POST request
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
				'actions'=>array('index', 'view', 'bulkUpdate', 'geteBayCategories', 'searchAppliedListings', 'bulkUpdateSubmit', 'testGetItem'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    public function actionTestGetItem()
    {
        
        //eBayTradingAPI::GetItem($list);
        //var_dump($list->getEntityAttributeValueByCodeWithAllChildren("ShippingDetails"));
        //eBayTradingAPI::ReviseFixedPriceItem($list, array("ItemID"=>"271824209129", "ExcludeShipToLocation"=>array("PO Box", "CN")));
        /*Yii::import('application.vendor.Wish.*');
        require_once 'WishAPI.php';
        WishAPI::GetAllProducts(29);*/
        //var_dump($client->getAllProducts());
        //eBayShoppingAPI::GetItem();
        /*try
        {
            set_error_handler(array($this, 'errorHandler'));
            $str = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><GetCategoryFeaturesResponse xmlns=\"urn:ebay:apis:eBLBaseComponents\"><Timestamp>2015-01-15T03:27:52.422Z</Tim";
            simplexml_load_string($str);
        }
        catch(Exception $ex)
        {
            echo 'eeee';
        }*/
        //eBayShoppingAPI::GetItem();
        //var_dump(Yii::app()->params['eBay']['logPath']);die();
        //$this->redirect($this->createAbsoluteUrl("/index", array()));
        //eBayTradingAPI::GetSellerDashboard(1);
        //eBayTradingAPI::GetItem(eBayListing::model()->findByPk(259));
        //Yii::app()->session['store_12_ebay_session_id'] = 'sfregeabvsfbaenethb';
        //eBayTradingAPI::FetchToken(Store::model()->findByPk(12));
    }

    /*protected  function errorHandler($error_level,$error_message)
    {
        $info= "Error Level：$error_level\n";
        $info.= "Error Msg：$error_message\n";
        throw new Exception('ddd');
    }*/

    /*public function actionTestCurlLogin()
    {
        $login_url = 'https://developer.ebay.com/base/membership/signin/default.aspx?ReturnUrl=http%3a%2f%2fdeveloper.ebay.com%2fDevZone%2faccount%2fdefault.aspx&mo=true';

        $post_fields['membername'] = 'cloud2012';
        $post_fields['password'] = '123456pP!';
        //$post_fields = 'membername=cloud2012&password=123456pP!';
        $cookie_file = tempnam(dirname(__FILE__) . DIRECTORY_SEPARATOR . "..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR.'temp','cookie');

        $viewUrl = 'https://developer.ebay.com/DevZone/account/default.aspx';

        $ch = curl_init($login_url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.9.1.5) Gecko/20091102 Firefox/3.5.5');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 100);
        $result = curl_exec($ch);
        var_dump('dd', $result, curl_error($ch));
        curl_close($ch);

        die();
    }*/

    /*
     * search eBay listings by input params, remotely
     */
    public function actionSearchAppliedListings()
    {
        $params = array(
            'searchKeyword'=>'',
            'searchSite'=>'all',
            'searchCategory'=>'all',
            'searchStore'=>'all',
            'searchMode'=>'normal',
            'searchEngine'=>'normal',
            'searchListType'=>'all',
        );
        if(isset($_POST['searchKeyword'])) $params['searchKeyword'] = (string)$_POST['searchKeyword'];
        if(isset($_POST['searchSite'])) $params['searchSite'] = (string)$_POST['searchSite'];
        if(isset($_POST['searchCategory'])) $params['searchCategory'] = (string)$_POST['searchCategory'];
        if(isset($_POST['searchStore'])) $params['searchStore'] = (string)$_POST['searchStore'];
        if(isset($_POST['searchMode'])) $params['searchMode'] = (string)$_POST['searchMode'];
        if(isset($_POST['searchEngine'])) $params['searchEngine'] = (string)$_POST['searchEngine'];
        if(isset($_POST['searchListType'])) $params['searchListType'] = (string)$_POST['searchListType'];

        $excludeShipLocation = true;
        if(isset($_POST['excludeShipLocation'])) $excludeShipLocation = $_POST['excludeShipLocation'] == 'false' ? false : true;

        try
        {
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

            if(strtolower($params['searchMode']) == 'normal')
            {
                $whereSQL = "";
                $keywords = array_filter(array_unique(explode(' ', trim($params['searchKeyword']))));
                if(!empty($keywords) && $mainSKUAttribute && $variationSKUAttribute)
                {
                    $searchWord = "";
                    $variationSearchWord = "";
                    $titleSearchWord = "";
                    foreach($keywords as $key=>$word)
                    {
                        if(empty($searchWord))
                        {
                            $searchWord = " mainsku.value like '%$word%' ";
                            $variationSearchWord = " variationsku.value like '%$word%' ";
                            $titleSearchWord = " title.value like '%$word%' ";
                        }
                        else
                        {
                            $searchWord .= " or mainsku.value like '%$word%' ";
                            $variationSearchWord .= " or variationsku.value like '%$word%' ";
                            $titleSearchWord .= " or title.value like '%$word%' ";
                        }
                    }
                    $whereSQL .= " and (($searchWord) or ($variationSearchWord) or ($titleSearchWord)) ";
                }
                if(strtolower($params['searchSite']) != 'all')
                {
                    $whereSQL .= " and t.site_id=:site_id";
                }
                if(strtolower($params['searchStore']) != 'all')
                {
                    $whereSQL .= " and t.store_id=:store_id";
                }
                if(strtolower($params['searchCategory']) != 'all' && $primaryCategoryAttribute && $secondaryCategoryAttribute)
                {
                    $whereSQL .= " and (pc.value=:primarycate OR sc.value=:secondarycate) ";
                }
                if(strtolower($params['searchListType']) != 'all')
                {
                    if(strtolower($params['searchListType']) == strtolower('FixedPriceItem'))
                        $whereSQL .= " and ltype.value = '{$params['searchListType']}' ";
                    else if(strtolower($params['searchListType']) == 'auction')
                        $whereSQL .= " and (ltype.value = '".eBayListingTypeCodeType::Auction."' or ltype.value = '".eBayListingTypeCodeType::Chinese."') ";
                }

                $select = "SELECT t.*, s.name as storename,
                            mainsku.value as msku,
                            pc.value as primarycate,
                            sc.value as secondarycate,
                            duration.value as listduration,
                            ltype.value as listtype,
                            title.value as title,
                            vurl.value as viewurl,
                            ".Store::PLATFORM_EBAY." as platform
                            FROM `lt_ebay_listing` `t`
                            left join lt_ebay_entity_varchar as mainsku on mainsku.ebay_entity_id = t.id and mainsku.ebay_entity_attribute_id = {$mainSKUAttribute->id}
                            left join lt_ebay_entity_varchar as variationsku on variationsku.ebay_entity_id = t.id and variationsku.ebay_entity_attribute_id = {$variationSKUAttribute->id}
                            left join lt_ebay_entity_varchar as pc on pc.ebay_entity_id = t.id and pc.ebay_entity_attribute_id = {$primaryCategoryAttribute->id}
                            left join lt_ebay_entity_varchar as sc on sc.ebay_entity_id = t.id and sc.ebay_entity_attribute_id = {$secondaryCategoryAttribute->id}
                            left join lt_ebay_entity_varchar as duration on duration.ebay_entity_id = t.id and duration.ebay_entity_attribute_id = {$listingDurationAttribute->id}
                            left join lt_ebay_entity_varchar as ltype on ltype.ebay_entity_id = t.id and ltype.ebay_entity_attribute_id = {$listingTypeAttribute->id}
                            left join lt_ebay_entity_varchar as title on title.ebay_entity_id = t.id and title.ebay_entity_attribute_id = {$titleAttribute->id}
                            left join lt_ebay_entity_varchar as sstatus on sstatus.ebay_entity_id = t.id and sstatus.ebay_entity_attribute_id = {$listingStatusAttribute->id}
                            left join lt_ebay_entity_varchar as vurl on vurl.ebay_entity_id = t.id and vurl.ebay_entity_attribute_id = {$viewUrlAttribute->id}
                            left join lt_store as s on s.id = t.store_id
                            where t.company_id=:company_id
                            and sstatus.value = '".eBayListingStatusCodeType::Active."'
                            $whereSQL
                            group by t.ebay_listing_id
                            order by msku asc; ";
                $command = Yii::app()->db->createCommand($select);
                $command->bindValue(":company_id", Yii::app()->session['user']->company_id, PDO::PARAM_INT);
                if(strtolower($params['searchSite']) != 'all')
                {
                    $command->bindValue(":site_id", $params['searchSite'], PDO::PARAM_INT);
                }
                if(strtolower($params['searchStore']) != 'all')
                {
                    $command->bindValue(":store_id", $params['searchStore'], PDO::PARAM_INT);
                }
                if(strtolower($params['searchCategory']) != 'all' && $primaryCategoryAttribute && $secondaryCategoryAttribute)
                {
                    $command->bindValue(":primarycate", $params['searchCategory'], PDO::PARAM_STR);
                    $command->bindValue(":secondarycate", $params['searchCategory'], PDO::PARAM_STR);
                }
                $listings = $command->queryAll();
                /*test for site code start*/
                $allSameSite = true;
                $siteID = -1;
                $index = 0;
                $domestic = array(); $worldwide = array(); $additional = array();
                $excludeLocationList = array('domestic' => $domestic, 'additional' => $additional, 'worldwide' => $worldwide);
                if($excludeShipLocation)
                {
                    foreach($listings as $list)
                    {
                        if($index == 0) $siteID = $list['site_id'];
                        if($siteID != $list['site_id'])
                        {
                            $allSameSite = false;
                            break;
                        }
                        $index++;
                    }
                    //if same site, pull exclude ship location detail
                    if($allSameSite && $siteID >= 0)
                    {
                        $excludeLocationList = Yii::app()->cache->get(sprintf("ebay_site_%S_exclude_ship_location", $siteID));
                        if($excludeLocationList === false)
                        {
                            $siteDetail = eBayDetail::model()->find("site_id=:site_id", array(':site_id' => $siteID));
                            if(!empty($siteDetail))
                            {
                                $excludeShipLocationDetail = $siteDetail->getEntityAttributeValueByCodeWithAllChildren("ExcludeShippingLocationDetails");
                                if(!empty($excludeShipLocationDetail))
                                {
                                    foreach($excludeShipLocationDetail as $detail)
                                    {
                                        if($detail['Region'] == 'Domestic Location')
                                        {
                                            $excludeLocationList['domestic'][] = $detail;
                                        }
                                        else if($detail['Region'] == 'Additional Locations')
                                        {
                                            $excludeLocationList['additional'][] = $detail;
                                        }
                                        else if($detail['Region'] == 'Worldwide' || $detail['Location'] == 'Middle East' || $detail['Location'] == 'Southeast Asia')
                                        {
                                            if(!isset($excludeLocationList['worldwide'][$detail['Location']]))
                                            {
                                                $excludeLocationList['worldwide'][$detail['Location']] = $detail;
                                            }
                                            else
                                            {
                                                $excludeLocationList['worldwide'][$detail['Location']]['Location'] = $detail['Location'];
                                                $excludeLocationList['worldwide'][$detail['Location']]['Description'] = $detail['Description'];
                                            }
                                        }
                                        else
                                        {
                                            if(!isset($excludeLocationList['worldwide'][$detail['Region']])) $excludeLocationList['worldwide'][$detail['Region']] = array();
                                            $excludeLocationList['worldwide'][$detail['Region']]['values'][] = $detail;
                                        }
                                    }
                                    Yii::app()->cache->set(sprintf("ebay_site_%S_exclude_ship_location", $siteID), $excludeLocationList, 60 * 60 * 24 * 7);
                                }
                            }
                            else
                                $excludeLocationList = array('domestic' => $domestic, 'additional' => $additional, 'worldwide' => $worldwide);
                        }
                    }
                }
                /*test for site code end*/
                $result = array('status'=>'success', 'data'=>$listings, 'allSameSite'=>$allSameSite, 'siteID'=>$siteID, 'excludeLocation'=>$excludeLocationList);
                echo json_encode($result);
            }
            else
            {
                //todo advanced search
            }
        }
        catch(Exception $ex)
        {
            $result = array('status'=>'fail', 'data'=>"Error Code: ".$ex->getCode().", ".$ex->getMessage());
            echo json_encode($result);
        }
    }

    /*
     * get eBay category by site, remotely
     */
    public function actionGeteBayCategories()
    {
        try
        {
            $siteId = intval($_POST['site_id']);
            $categories = eBayCategory::model()->findAll('CategoryParentID = CategoryID and CategorySiteID=:CategorySiteID', array(':CategorySiteID'=>$siteId));
            $dataList = array();
            if(!empty($categories))
            {
                foreach($categories as $category)
                    $dataList[] = array('id'=>$category['CategoryID'], 'name'=>$category['CategoryName']);
            }
            $result = array('status'=>'success', 'data'=>$dataList);
            echo json_encode($result);
        }
        catch(Exception $ex)
        {
            $result = array('status'=>'error', 'msg'=>var_dump($ex));
            echo json_encode($result);
        }
    }

    /*
     * bulk update eBay listings
     */
    public function actionBulkUpdate()
    {
        $this->layout='';

        $criteria= new CDbCriteria();
        $criteria->join = "left join {{ebay_entity_type}} et on et.id = t.entity_type_id";
        $criteria->condition = "t.is_active = 1 and et.entity_table = 'ebay_listing'";
        $eBayAttributeSet = eBayAttributeSet::model()->find($criteria);
        if(empty($eBayAttributeSet)) throw new CHttpException(404,'The requested page does not exist.');

        $this->render('bulkUpdate');
        $this->layout='//layouts/column2';
    }

    /*
     * process bulk update submit
     */
    public function actionBulkUpdateSubmit()
    {
        $verifyonly = false;
        if(isset($_POST['params']))//submit from bulk update confirm
        {
            $inputs = json_decode($_POST['params']);
            if(!isset($inputs->Success)) $this->redirect('bulkUpdate');
            $params['applied_listings'] = $inputs->Success;
            if(isset($_POST['submitwarning']) && isset($inputs->Warning))
                $params['applied_listings'] = array_merge($inputs->Success, $inputs->Warning);
            $params['update_rules'] = array();
            if(isset($inputs->update_rules->quantity))
                $params['update_rules']['quantity'] = $inputs->update_rules->quantity;
            if(isset($inputs->update_rules->price))
            {
                $params['update_rules']['price'] = array(
                    'action'=>$inputs->update_rules->price->action,
                    'value'=>$inputs->update_rules->price->value,
                    'type'=>$inputs->update_rules->price->type,
                );
            }
            if(isset($inputs->update_rules->description))
            {
                $params['update_rules']['description'] = array(
                    'action'=>$inputs->update_rules->description->action,
                    'tag'=>$inputs->update_rules->description->tag,
                    'value'=>$inputs->update_rules->description->value,
                    'position'=>$inputs->update_rules->description->position,
                );
            }
            if(isset($inputs->update_rules->excludeShipLocation))
            {
                $params['update_rules']['excludeShipLocation'] = $inputs->update_rules->excludeShipLocation;
            }
        }
        else //submit from bulk update
        {
            $params = array();
            $verifyonly = isset($_POST['verifyonly']) ? true : false;
            $params['applied_listings'] = isset($_POST['applied_listing']) ? $_POST['applied_listing'] : array();
            //process update price rule
            if(isset($_POST['update_price_panel_enable']) && isset($_POST['update_price_value']))
            {
                $params['update_rules']['price'] = array(
                    'action'=>(string)$_POST['update_price_action'],
                    'value'=>(float)$_POST['update_price_value'],
                    'type'=>(string)$_POST['update_price_type'],
                );
            }
            //process update inventory rule
            if(isset($_POST['update_quantity_panel_enable']) && isset($_POST['update_quantity_value']))
            {
                $params['update_rules']['quantity'] = (int)$_POST['update_quantity_value'];
            }
            //process update description rule
            if(isset($_POST['update_description_panel_enable']) && isset($_POST['update_description_tag']))
            {
                $params['update_rules']['description'] = array(
                    'action'=>(string)$_POST['update_description_action'],
                    'tag'=>(string)$_POST['update_description_tag'],
                    'value'=>(string)$_POST['update_description_value'],
                    'position'=>(string)$_POST['update_description_position'],
                );
            }
            //process update exclude shipping location
            if(isset($_POST['update_exclude_ship_location_panel_enable']))
            {
                $params['update_rules']['excludeShipLocation'] = array();
                if(isset($_POST['exclude_ship_location_domestic_list']) && count($_POST['exclude_ship_location_domestic_list']) > 0 )
                    $params['update_rules']['excludeShipLocation'] = array_merge($params['update_rules']['excludeShipLocation'], $_POST['exclude_ship_location_domestic_list']);
                if(isset($_POST['exclude_ship_location_additional_list']) && count($_POST['exclude_ship_location_additional_list']) > 0 )
                    $params['update_rules']['excludeShipLocation'] = array_merge($params['update_rules']['excludeShipLocation'], $_POST['exclude_ship_location_additional_list']);
                foreach($_POST as $key => $value)
                {
                    if(substr($key,0, strlen("exclude_ship_location_worldwide_list_")) == "exclude_ship_location_worldwide_list_")
                        $params['update_rules']['excludeShipLocation'] = array_merge($params['update_rules']['excludeShipLocation'], $value);
                }
            }
        }

        if(!isset($params['applied_listings']) || empty($params['applied_listings']))
        {
            Yii::app()->user->setFlash('Error', 'None eBay Listings have been selected, please try again!');
            $this->redirect($this->createAbsoluteUrl("eBay/eBayListing/bulkUpdate", array()));
        }

        $params["company_id"] = Yii::app()->session['user']->company_id;

        if(count($params['applied_listings'])>3)
        {
            $instantJob = new InstantJob();
            $instantJob->action = InstantJob::ACTION_BULKUPDATEITEMS;
            $instantJob->status = InstantJob::STATUS_WAIT;
            $instantJob->platform = Store::PLATFORM_EBAY;
            $instantJob->params = json_encode($params);
            $instantJob->create_time_utc = time();
            if($instantJob->save(false))
            {
                Yii::app()->user->setFlash('Success', 'Request has been added into schedule successfully. You will receive notification after done!<br />');//If you want to execute immediately, please select less than or equal to 1 items.');
                $this->redirect($this->createAbsoluteUrl("eBay/eBayListing/bulkUpdate", array()));
            }
            else
            {
                Yii::app()->user->setFlash('Error', 'Internal error happened, Please try again!');
                $this->redirect($this->createAbsoluteUrl("eBay/eBayListing/bulkUpdate", array()));
            }
        }

        $result = eBayTradingAPI::ReviseListing($params, $verifyonly);

        if($verifyonly)
        {
            $this->layout='';
            $this->render('bulkUpdateSubmit', array('result'=>$result));
            $this->layout='//layouts/column2';
        }
        else
        {
            $info = "";
            if(!empty($result['UnknownStatus']))
            {
                foreach($result['UnknownStatus'] as $unknown)
                {
                    $info .= "Unknown Status Item: ".$unknown['listingId'].", ".$unknown['Msg'][0]."<br />";
                }
            }
            $info = "Total {$result['Total']} item(s) processed.<br />".$info;
            Yii::app()->user->setFlash('Info', $info);

            if(!empty($result['Success']))
            {
                $successInfo = "";
                foreach($result['Success'] as $success)
                {
                    $successInfo .= (!empty($successInfo) ? "<br />" : "")."Item: ".$success['listingId']." processed successfully<br />";
                    foreach($success['Msg'] as $msg)
                        $successInfo .= "$msg<br />";
                }
                Yii::app()->user->setFlash('Success', $successInfo);
            }

            $warningInfo = "";
            if(!empty($result['Warning']))
            {
                foreach($result['Warning'] as $warning)
                {
                    $warningInfo .= (!empty($warningInfo) ? "<br />" : "")."Item: ".$warning['listingId']." got warning!<br />";
                    foreach($warning['Msg'] as $msg)
                        $warningInfo .= "$msg<br />";
                }

            }
            $failureInfo = "";
            if(!empty($result['Failure']))
            {
                foreach($result['Failure'] as $failure)
                {
                    $failureInfo .= (!empty($failureInfo) ? "<br />" : "")."Item: ".$failure['listingId']." got failure!<br />";
                    foreach($failure['Msg'] as $msg)
                        $failureInfo .= "$msg<br />";
                }
            }
            if($warningInfo || $failureInfo) Yii::app()->user->setFlash('Error', $warningInfo.(empty($warningInfo)? "" : "<br />").$failureInfo);

            $this->redirect($this->createAbsoluteUrl("eBay/eBayListing/bulkUpdate", array()));
        }
    }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        //load entity object
        $model = $this->loadModel($id);

		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new eBayListing;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['eBayListing']))
		{
			$model->attributes=$_POST['eBayListing'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['eBayListing']))
		{
			$model->attributes=$_POST['eBayListing'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
    public function actionIndex($eBaySite='All', $status='Active', $type='All', $store='All')
    {
        $this->layout='';
        //check input parameters
        if(strtolower($eBaySite) != 'all' && $eBaySite != (string)(int)$eBaySite) $eBaySite = 'All';
        if(strtolower($status)!='active' && strtolower($status)!= 'sold' && strtolower($status) != 'unsold') $status='Active';
        if(strtolower($type) != 'all' && !in_array($type, eBayListingTypeCodeType::getListingTypeOptions())) $type = 'All';


        $stores = Store::model()->findAll(
            "company_id=:company_id and platform=:platform and is_active=:is_active",
            array(
                ':company_id' => Yii::app()->session['user']->company_id,
                ':platform'=>Store::PLATFORM_EBAY,
                ':is_active'=>Store::ACTIVE_YES,
            )
        );
        if(empty($stores))
        {
            Yii::app()->user->setFlash('Error', 'No store created, please create a store first!');
            $store = 'All';
        }
        else
        {
            $tempList = array();
            $findStore = false;
            foreach($stores as $row)
            {
                $tempList[$row['id']] = $row['name'];
                if($row['id'] == (int)$store) $findStore = true;
            }
            $stores = $tempList;
            if(!$findStore && strtolower($store) != 'all')
            {
                Yii::app()->user->setFlash('Error', 'The Store you selected does not exist or is not active!');
                $store = 'All';
            }
        }

        //process page filters
        $query = "SELECT distinct site_id FROM {{ebay_listing}} where company_id = :company_id;";
        $command = Yii::app()->db->createCommand($query);
        $command->bindValue(":company_id", Yii::app()->session['user']->company_id, PDO::PARAM_INT);
        $result = $command->QueryAll();
        $sites[] = array('name'=>'All', 'id'=>'All', 'selected'=>(strtolower($eBaySite) == 'all' ? true : false));
        if(!empty($result))
            foreach($result as $site_id)
            {
                $sites[] = array(
                    'name'=>eBaySiteIdCodeType::getSiteIdCodeTypeText($site_id['site_id']),
                    'id'=>$site_id['site_id'],
                    'selected'=>(strtolower($eBaySite) == $site_id['site_id'] ? true : false)
                );
            }
        $statusList = array(
            'Active'=>array('name'=>'Active', 'selected'=>(strtolower($status) == 'active' ? true : false)),
            'Sold'=>array('name'=>'Sold', 'selected'=>(strtolower($status) == 'sold' ? true : false)),
            'UnSold'=>array('name'=>'UnSold', 'selected'=>(strtolower($status) == 'unsold' ? true : false)),
        );

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
                ls.name as storename,
                el.id, el.ebay_listing_id, el.site_id, el.update_time_utc, el.note
                FROM lt_ebay_listing el
                left join lt_store ls on ls.id = el.store_id
                left join lt_ebay_entity_varchar eevls on eevls.ebay_entity_id = el.id and eevls.ebay_entity_attribute_id = {$statusAttribute->id} /*listing status*/
                left join lt_ebay_entity_varchar eevlt on eevlt.ebay_entity_id = el.id and eevlt.ebay_entity_attribute_id = {$listingTypeAttribute->id} /*listing type*/
                left join lt_ebay_entity_varchar eevld on eevld.ebay_entity_id = el.id and eevld.ebay_entity_attribute_id = {$listingDurationAttribute->id} /*listing duration*/
                left join lt_ebay_entity_int eeisq on eeisq.ebay_entity_id = el.id and eeisq.ebay_entity_attribute_id = {$soldQuantityAttribute->id} /*sold quantity*/
                left join lt_ebay_entity_varchar eevviu on eevviu.ebay_entity_id = el.id and eevviu.ebay_entity_attribute_id = {$viewItemURLAttribute->id} /*listing status*/
                left join lt_ebay_entity_varchar eevt on eevt.ebay_entity_id = el.id and eevt.ebay_entity_attribute_id = {$titleAttribute->id} /*listing status*/
                where el.company_id = ".Yii::app()->session['user']->company_id;

        $where = "";
        if(strtolower($status) == 'active')
            $where .= ' and eevls.`value`=\'Active\' ';
        else
            $where .= ' and (eevls.`value`=\'Ended\' or eevls.`value`=\'Completed\') ';
        if(strtolower($status) == 'sold')
            $where .= ' and eeisq.`value` > 0 ';
        elseif(strtolower($status) == 'unsold')
            $where .= ' and eeisq.`value` <= 0 ';
        if(strtolower($type) != 'all')
            $where .= " and eevlt.`value` = '$type' ";
        if(strtolower($eBaySite) != 'all')
            $where .= " and el.site_id = ".(int)$eBaySite." ";
        if(strtolower($store) != 'all')
            $where .= " and el.store_id = ".(int)$store." ";

        $rawData=Yii::app()->db->createCommand($sql.$where)->queryAll();
        // or using: $rawData=User::model()->findAll();
        $dataProvider=new CArrayDataProvider($rawData, array(
            'id'=>'id',
            'sort'=>array(
                'attributes'=>array(
                    //'el.id', 'soldquantity'
                ),
            ),
            'pagination'=>array(
                'pageSize'=>25,
            ),
        ));

        $this->render('index',array(
            'dataProvider'=>$dataProvider,
            'sites'=>$sites,
            'statusList'=>$statusList,
            'storeList'=>$stores,
            'currentSite'=>$eBaySite,
            'currentStatus'=>$status,
            'currentType'=>$type,
            'currentStore'=>$store,
        ));

        $this->layout='//layouts/column2';
    }

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new eBayListing('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['eBayListing']))
			$model->attributes=$_GET['eBayListing'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return eBayListing the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=eBayListing::model()->findByPk($id, "company_id=:company_id" ,array(':company_id' => Yii::app()->session['user']->company_id));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param eBayListing $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='e-bay-listing-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
