<?php

Yii::import('application.vendor.eBay.*');
require_once 'reference.php';

class ADController extends Controller
{
	public function actionIndex()
	{
        $this->layout='//layouts/column2';

        $campaignList = ADCampaign::model()->findAll("company_id=:company_id" ,array(':company_id' => Yii::app()->session['user']->company_id));

		$this->render('index', array(
            'campaignList'=>$campaignList,
        ));
	}

    public function actionGetDynamicGroupList()
    {
        try
        {
            $adCampaignId = $_POST['campaign_id'];
            $adGroups = ADGroup::model()->findALL("campaign_id=:campaign_id and company_id=:company_id", array(":campaign_id"=>$adCampaignId, ":company_id"=>Yii::app()->session['user']->company_id));
            $adGroupList = "<option value=''>".ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'select_an_ad_group_dropdown')."</option>";
            foreach($adGroups as $adGroup)
                $adGroupList .= "<option value='{$adGroup->id}'>{$adGroup->name}</option>";
            echo json_encode($adGroupList);
            exit();
        }
        catch(Exception $ex)
        {
            $result = array('status'=>'error', 'msg'=>"Exception, Code: ".$ex->getCode().", Msg: ".$ex->getMessage());
            echo json_encode($result);
        }
    }

    public function actionCreate($adcampaignid=null, $adgroupid=null, $lead=null)
    {
        $model = new ADAdvertise();

        if(isset($_POST['advertise']))
        {
            $transaction = null;
            try
            {
                $transaction= Yii::app()->db->beginTransaction();

                //create advertise first
                $model->name = $_POST['advertise']['name'];
                $model->ad_campaign_id = $adcampaignid;
                $model->ad_group_id = $adgroupid;
                $model->company_id = Yii::app()->session['user']->company_id;
                if(!$model->save())
                    throw new Exception("create advertise error");

                //create ad_feed second
                $error = "";
                $eBayEntityType = eBayEntityType::model()->find('entity_model=:entity_model', array(':entity_model'=>'eBayListing'));
                $eBayAttributeSet = eBayAttributeSet::model()->find('entity_type_id=:entity_type_id',array(':entity_type_id'=>$eBayEntityType->id,));
                $titleAttribute = $eBayAttributeSet->getEntityAttribute("Title");
                $listingStatusAttribute = $eBayAttributeSet->getEntityAttribute("SellingStatus->ListingStatus");
                $viewUrlAttribute = $eBayAttributeSet->getEntityAttribute("ListingDetails->ViewItemURL");
                $locationAttribute = $eBayAttributeSet->getEntityAttribute("Location");
                $pictureURLAttribute = $eBayAttributeSet->getEntityAttribute("PictureDetails->PictureURL");
                $subTitleAttribute = $eBayAttributeSet->getEntityAttribute("SubTitle");
                $startPriceAttribute = $eBayAttributeSet->getEntityAttribute("StartPrice->Value");
                foreach($_POST['applied_listings_value'] as $id)
                {
                    $select = "SELECT t.*,
                            title.value as title,
                            vurl.value as viewurl,
                            location.value as location,
                            subtitle.value as subtitle,
                            startprice.value as startprice,
                            picture.value as picture
                            FROM `lt_ebay_listing` `t`
                            left join lt_ebay_entity_varchar as title on title.ebay_entity_id = t.id and title.ebay_entity_attribute_id = {$titleAttribute->id}
                            left join lt_ebay_entity_varchar as sstatus on sstatus.ebay_entity_id = t.id and sstatus.ebay_entity_attribute_id = {$listingStatusAttribute->id}
                            left join lt_ebay_entity_varchar as vurl on vurl.ebay_entity_id = t.id and vurl.ebay_entity_attribute_id = {$viewUrlAttribute->id}
                            left join lt_ebay_entity_varchar as location on location.ebay_entity_id = t.id and location.ebay_entity_attribute_id = {$locationAttribute->id}
                            left join lt_ebay_entity_varchar as subtitle on subtitle.ebay_entity_id = t.id and subtitle.ebay_entity_attribute_id = {$subTitleAttribute->id}
                            left join lt_ebay_entity_varchar as startprice on startprice.ebay_entity_id = t.id and startprice.ebay_entity_attribute_id = {$startPriceAttribute->id}
                            left join lt_ebay_entity_varchar as picture on picture.ebay_entity_id = t.id and picture.ebay_entity_attribute_id = {$pictureURLAttribute->id}
                            where t.company_id=:company_id
                            and sstatus.value = '".eBayListingStatusCodeType::Active."'
                            and t.id = :id";
                    $command = Yii::app()->db->createCommand($select);
                    $command->bindValue(":company_id", Yii::app()->session['user']->company_id, PDO::PARAM_INT);
                    $command->bindValue(":id", $id, PDO::PARAM_INT);
                    $listing = $command->queryRow();

                    $feed = new ADAdvertiseFeed();
                    $feed->ad_advertise_id = $model->id;
                    $feed->ad_group_id = $adgroupid;
                    $feed->ad_campaign_id = $adcampaignid;
                    $feed->company_id = Yii::app()->session['user']->company_id;
                    $feed->item_id = $listing['ebay_listing_id'];var_dump($listing['ebay_listing_id']);
                    $feed->item_type = 'eBayListing';
                    $feed->item_keywords = '';
                    $feed->item_headline = $listing['title'];
                    $feed->item_sub_headline = isset($listing['subtitle']) ? $listing['subtitle'] : '';
                    $feed->item_description = $listing['title'];
                    $feed->item_address = $listing['location'];
                    $feed->price = isset($listing['startprice']) ? $listing['startprice'] : 0;
                    $feed->image_url = isset($listing['picture']) ? $listing['picture'] : '';
                    $feed->sale_price = isset($listing['startprice']) ? $listing['startprice'] : 0;
                    $feed->remarketing_url = isset($listing['viewurl']) ? $listing['viewurl'] : '';
                    $feed->destination_url = isset($listing['viewurl']) ? $listing['viewurl'] : '';
                    $feed->final_url = isset($listing['viewurl']) ? $listing['viewurl'] : '';

                    if(!$feed->save()) $error .= "Item Feed processed error for eBay Listing, ID: ".$id."<br />";
                }

                //create variations third
                $params = array(
                    'logo' => isset($_POST["logo_value"]) ? $_POST["logo_value"] : "",
                    'headline' => array(
                        'text' => isset($_POST["headline_value"]) ? $_POST["headline_value"] : "",
                        'color' => isset($_POST["headlineColor_value"]) ? $_POST["headlineColor_value"] : "#000",
                        'background-color' => isset($_POST["headlineBackgroundColor_value"]) ? $_POST["headlineBackgroundColor_value"] : "#fff",
                        'size' => isset($_POST["headlineTextSize_value"]) ? $_POST["headlineTextSize_value"] : "18",
                        'shadow' => (isset($_POST["headlineShadow_value"]) ? ($_POST["headlineShadow_value"] == 'true' ? true : false) : false),
                    ),
                    'pricePrefix' => array(
                        'text' => isset($_POST["pricePrefix_value"]) ? $_POST["pricePrefix_value"] : "",
                        'color' => isset($_POST["pricePrefixColor_value"]) ? $_POST["pricePrefixColor_value"] : "#0073ED",
                        'size' => isset($_POST["pricePrefixTextSize_value"]) ? $_POST["pricePrefixTextSize_value"] : "11",
                    ),
                    'priceSuffix' => array(
                        'text' => isset($_POST["priceSuffix_value"]) ? $_POST["priceSuffix_value"] : "",
                        'color' => isset($_POST["priceSuffixColor_value"]) ? $_POST["priceSuffixColor_value"] : "#B00000",
                        'size' => isset($_POST["priceSuffixTextSize_value"]) ? $_POST["priceSuffixTextSize_value"] : "18",
                    ),
                    'button' => array(
                        'text' => isset($_POST["button_value"]) ? $_POST["button_value"] : "Shop now!",
                        'color' => isset($_POST["buttonTextColor_value"]) ? $_POST["buttonTextColor_value"] : "#fff",
                        'background-color' => isset($_POST["buttonColor_value"]) ? $_POST["buttonColor_value"] : "#0073ED",
                        'rolloverColor' => isset($_POST["rolloverColor_value"]) ? $_POST["rolloverColor_value"] : "#004479",
                        'shadow' => (isset($_POST["buttonShadow_value"]) ? ($_POST["buttonShadow_value"] == 'true' ? true : false) : false),
                        'buttonCorner' => (isset($_POST["buttonCorner_value"]) ? $_POST["buttonCorner_value"] : 'square'),
                        'buttonBevel' => (isset($_POST["buttonBevel_value"]) ? ($_POST["buttonBevel_value"] == 'true' ? true : false) : false),
                    ),
                    'clickBehavior' => isset($_POST["clickBehavior_value"]) ? $_POST["clickBehavior_value"] : "product_url",
                );
                foreach(ADAdvertiseVariation::$FlashResolutionList as $flash)
                {
                    $variation = new ADAdvertiseVariation();
                    $variation->ad_advertise_id = $model->id;
                    $variation->ad_group_id = $adgroupid;
                    $variation->ad_campaign_id = $adcampaignid;
                    $variation->company_id = Yii::app()->session['user']->company_id;
                    $variation->type = ADAdvertiseVariation::Type_AdGallery;
                    $variation->code = ADAdvertiseVariation::Code_Flash;
                    $variation->status = ADAdvertiseVariation::Status_Paused;
                    $variation->criteria = json_encode($params);
                    $variation->display_url = $_POST['displayURL_value'];
                    $variation->landing_page = isset($_POST['landingPage_value']) ? $_POST['landingPage_value'] : '';
                    $variation->width = $flash['width'];
                    $variation->height = $flash['height'];
                    $variation->is_delete = ADAdvertiseVariation::Delete_No;
                    if(!$variation->save()) $error .= "Flash variation creation failed. Width: {$flash['width']}, Height: {$flash['height']}.<br />";
                }
                foreach(ADAdvertiseVariation::$Html5ResolutionList as $html5)
                {
                    $variation = new ADAdvertiseVariation();
                    $variation->ad_advertise_id = $model->id;
                    $variation->ad_group_id = $adgroupid;
                    $variation->ad_campaign_id = $adcampaignid;
                    $variation->company_id = Yii::app()->session['user']->company_id;
                    $variation->type = ADAdvertiseVariation::Type_AdGallery;
                    $variation->code = ADAdvertiseVariation::Code_Html5;
                    $variation->status = ADAdvertiseVariation::Status_Paused;
                    $variation->criteria = json_encode($params);
                    $variation->display_url = $_POST['displayURL_value'];
                    $variation->landing_page = isset($_POST['landingPage_value']) ? $_POST['landingPage_value'] : '';
                    $variation->width = $html5['width'];
                    $variation->height = $html5['height'];
                    $variation->is_delete = ADAdvertiseVariation::Delete_No;
                    if(!$variation->save()) $error .= "HTML5 variation creation failed. Width: {$html5['width']}, Height: {$html5['height']}.<br />";
                }

                $transaction->commit();
                if($error) Yii::app()->user->setFlash('Error', $error);
                $this->redirect($this->createAbsoluteUrl("marketing/advertisement/AD/view", array('id'=>$model->id)));
            }
            catch(Exception $ex)
            {
                if(isset($transaction)) $transaction->rollback();
                Yii::app()->user->setFlash('Error', 'Fail to create advertisement for you, please try it again!');
            }
        }

        if(!isset($adcampaignid) || !isset($adgroupid))
        {
            $this->render('chooseCampaignAndGroup');
            exit();
        }

        $this->render('create', array(
            'adCampaignId'=>$adcampaignid,
            'adGroupId'=>$adgroupid,
            'model'=>$model,
            'lead'=>$lead,
        ));
    }

    public function actionGetListingParams()
    {
        $params = array(
            'itemType'=>'eBayListing',
            'id'=>null,
        );
        if(isset($_POST['itemType'])) $params['itemType'] = (string)$_POST['itemType'];
        if(isset($_POST['id'])) $params['id'] = (int)$_POST['id'];

        if(!isset($params['itemType']) || !isset($params['id']))
        {
            $result = array('status'=>'fail', 'data'=>"Missing input params");
            echo json_encode($result);
        }

        switch($params['itemType'])
        {
            case "eBayListing":
                $eBayEntityType = eBayEntityType::model()->find('entity_model=:entity_model', array(':entity_model'=>'eBayListing'));
                $eBayAttributeSet = eBayAttributeSet::model()->find('entity_type_id=:entity_type_id',array(':entity_type_id'=>$eBayEntityType->id,));
                $titleAttribute = $eBayAttributeSet->getEntityAttribute("Title");
                $listingStatusAttribute = $eBayAttributeSet->getEntityAttribute("SellingStatus->ListingStatus");
                $viewUrlAttribute = $eBayAttributeSet->getEntityAttribute("ListingDetails->ViewItemURL");
                $locationAttribute = $eBayAttributeSet->getEntityAttribute("Location");
                $pictureURLAttribute = $eBayAttributeSet->getEntityAttribute("PictureDetails->PictureURL");
                $subTitleAttribute = $eBayAttributeSet->getEntityAttribute("SubTitle");
                $startPriceAttribute = $eBayAttributeSet->getEntityAttribute("StartPrice->Value");

                $select = "SELECT t.*,
                            title.value as title,
                            vurl.value as viewurl,
                            location.value as location,
                            subtitle.value as subtitle,
                            startprice.value as startprice,
                            picture.value as picture
                            FROM `lt_ebay_listing` `t`
                            left join lt_ebay_entity_varchar as title on title.ebay_entity_id = t.id and title.ebay_entity_attribute_id = {$titleAttribute->id}
                            left join lt_ebay_entity_varchar as sstatus on sstatus.ebay_entity_id = t.id and sstatus.ebay_entity_attribute_id = {$listingStatusAttribute->id}
                            left join lt_ebay_entity_varchar as vurl on vurl.ebay_entity_id = t.id and vurl.ebay_entity_attribute_id = {$viewUrlAttribute->id}
                            left join lt_ebay_entity_varchar as location on location.ebay_entity_id = t.id and location.ebay_entity_attribute_id = {$locationAttribute->id}
                            left join lt_ebay_entity_varchar as subtitle on subtitle.ebay_entity_id = t.id and subtitle.ebay_entity_attribute_id = {$subTitleAttribute->id}
                            left join lt_ebay_entity_varchar as startprice on startprice.ebay_entity_id = t.id and startprice.ebay_entity_attribute_id = {$startPriceAttribute->id}
                            left join lt_ebay_entity_varchar as picture on picture.ebay_entity_id = t.id and picture.ebay_entity_attribute_id = {$pictureURLAttribute->id}
                            where t.company_id=:company_id
                            and sstatus.value = '".eBayListingStatusCodeType::Active."'
                            and t.id = :id";
                $command = Yii::app()->db->createCommand($select);
                $command->bindValue(":company_id", Yii::app()->session['user']->company_id, PDO::PARAM_INT);
                $command->bindValue(":id", $params['id'], PDO::PARAM_INT);
                $listings = $command->queryRow();
                if(!isset($listings['startprice'])) $listings['startprice'] = sprintf("$%1\$.2f", $listings['startprice']); else $listings['startprice'] = sprintf("$%1\$.2f", 0);
                $result = array('status'=>'success', 'data'=>$listings);
                echo json_encode($result);
                break;
            default:
                $result = array('status'=>'fail', 'data'=>"Invalid item type");
                echo json_encode($result);
                break;
        }
        exit();
    }

    public function actionUploadLogo()
    {
        if(!isset($_FILES['logo_upload_file']))
        {
            $result = array('status'=>'fail', 'data'=>"No file uploaded.");
            echo json_encode($result);
        }
        if($_FILES['logo_upload_file']['size'] <= 0)
        {
            $result = array('status'=>'fail', 'data'=>"No file uploaded.");
            echo json_encode($result);
        }
        switch($_FILES['logo_upload_file']['error'])
        {
            case 1:
            case 2:
                $result = array('status'=>'fail', 'data'=>"File size is too big.");
                echo json_encode($result);
                exit();
                break;
            case 3:
                $result = array('status'=>'fail', 'data'=>"Upload failed, please try again.");
                echo json_encode($result);
                exit();
                break;
            case 4:
                $result = array('status'=>'fail', 'data'=>"No file uploaded.");
                echo json_encode($result);
                exit();
                break;
        }

        $uploadFolder = dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR.'upload';
        if (!file_exists($uploadFolder))  @mkdir($uploadFolder);
        $uploadFolder .= DIRECTORY_SEPARATOR.date("Y");
        if (!file_exists($uploadFolder))  @mkdir($uploadFolder);
        $uploadFolder .= DIRECTORY_SEPARATOR.date("m");
        if (!file_exists($uploadFolder))  @mkdir($uploadFolder);

        $fileName = explode('.', $_FILES['logo_upload_file']['name']);
        $fileName = time().'.'.$fileName[count($fileName)-1];
        if(!move_uploaded_file( $_FILES['logo_upload_file']['tmp_name'], $uploadFolder.DIRECTORY_SEPARATOR.$fileName))
        {
            $result = array('status'=>'fail', 'data'=>"Upload failed, please try again.");
            echo json_encode($result);
        }
        $result = array('status'=>'success', 'data'=>$_SERVER['HTTP_ORIGIN'].'/'."upload".'/'.date("Y").'/'.date("m").'/'.$fileName);
        echo json_encode($result);
    }

    public function actionView($id)
    {
        $this->layout='//layouts/column2';
        $model = $this->loadModel($id);

        $this->render('view', array(
            'model' => $model,
        ));
    }

    protected function getAdvertisementPerformance($advertisementid=null, $advariationid=null, $start='', $end='')
    {
        $performanceList = array();

        $whereSQL = "";
        $groupBySQL = " group by gara.date";
        if(isset($advariationid) && $advariationid)
        {
            $whereSQL .= " and t.id = :ad_variation_id ";
            $groupBySQL .= " , t.id ";
        }
        $performanceSQL = "select sum(gara.clicks) as clicks, sum(gara.impressions) as impr, sum(gara.cost) / ".Yii::app()->params['google']['AdWords']['reportCurrencyUnit']." as cost,
                            gara.date, gara.month, gara.year, gara.week, gara.month_of_year
                            from lt_ad_advertise_variation t
                            left join lt_google_adwords_ad gaa on gaa.lt_ad_advertise_variation_id = t.id
                            inner join lt_google_adwords_report_ad gara on gara.id = gaa.id and gara.date >= :startdate and gara.date <= :enddate
                            where t.company_id = :company_id and t.ad_advertise_id = :ad_advertise_id
                            $whereSQL
                            $groupBySQL;";
        $command = Yii::app()->db->createCommand($performanceSQL);
        $command->bindValue(":company_id", Yii::app()->session['user']->company_id, PDO::PARAM_INT);
        $command->bindValue(":ad_advertise_id", $advertisementid, PDO::PARAM_INT);
        $command->bindValue(":startdate", $start, PDO::PARAM_STR);
        $command->bindValue(":enddate", $end, PDO::PARAM_STR);
        if(isset($advariationid) && $advariationid)
        {
            $command->bindValue(":ad_variation_id", $advariationid, PDO::PARAM_INT);
        }
        $performances = $command->queryAll();

        $index = 0;
        $performanceList = array();
        while(true)
        {
            if( strtotime($start) + 60 * 60 * 24 * $index > strtotime($end) ) break;
            $performanceList[date("Y-m-d", strtotime($start) + 60 * 60 * 24 * $index)] = array(
                'clicks'=> "0",
                'impr'=> "0",
                'ctr'=> "0",
                'cpc'=> "0",
                'cost'=> "0",
            );
            $index++;
        }

        if(isset($performances) && !empty($performances))
        {
            foreach($performances as $performance)
            {
                if(isset($performanceList[$performance['date']]))
                    $performanceList[$performance['date']] = array(
                        'clicks'=> $performance['clicks'],
                        'impr'=> $performance['impr'],
                        'ctr'=> isset($performance['impr']) && $performance['impr'] ? sprintf("%1\$.2f%", $performance['clicks'] / $performance['impr'] * 100) : "0",
                        'cpc'=> isset($performance['clicks']) && $performance['clicks'] ? sprintf("%1\$.2f", $performance['cost'] / $performance['clicks']) : "0",
                        'cost'=> sprintf("%1\$.2f", $performance['cost']),
                    );
            }
        }

        return $performanceList;
    }

    public function actionGetPerformanceData($advertisementid=null, $advariationid=null, $start='', $end='')
    {
        if(!$end) $end = date("Y-m-d");
        if(!$start) $start = date("Y-m-d", strtotime(date("Y-m-d")) - 60 * 60 * 24 * 14);

        if(isset($_POST['advertisementid'])) $advertisementid = $_POST['advertisementid'];
        if(isset($_POST['advariationid'])) $advariationid = $_POST['advariationid'];
        if(isset($_POST['start'])) $start = $_POST['start'];
        if(isset($_POST['end'])) $end = $_POST['end'];

        if(!isset($advertisementid))
        {
            $result = array('status'=>'fail', 'data'=>"Invalid AD information!");
            echo json_encode($result);
            exit();
        }

        $performanceList = $this->getAdvertisementPerformance($advertisementid, $advariationid, $start, $end);

        echo json_encode($performanceList);
        exit();
    }

    public function actionUpdateVariationStatus()
    {
        $status = isset($_POST['status']) ? $_POST['status'] : null;
        $appliedList = isset($_POST['idList']) ? $_POST['idList'] : null;;
        $successList = array();
        if(!array_key_exists($status, ADAdvertiseVariation::getStatusOptions()))
        {
            $result = array('status'=>'fail', 'msg'=>"Invalid Advertisement Status!");
            echo json_encode($result);
            exit();
        }
        foreach($appliedList as $id)
        {
            $variation = ADAdvertiseVariation::model()->findByPk($id, "company_id=:company_id" ,array(':company_id' => Yii::app()->session['user']->company_id));
            if($variation!=null)
            {
                $variation->status = $status;
                if($variation->save()) $successList[] = $variation->id;
            }
        }

        $result = array('status'=>'success', 'data'=>$successList);
        echo json_encode($result);
        exit();
    }

    public function actionGetPerformanceStatistic($advertisementid=null, $advariationid=null, $start='', $end='')
    {
        if(!$end) $end = date("Y-m-d");
        if(!$start) $start = date("Y-m-d", strtotime(date("Y-m-d")) - 60 * 60 * 24 * 34);

        if(isset($_POST['advertisementid'])) $advertisementid = $_POST['advertisementid'];
        if(isset($_POST['advariationid'])) $advariationid = $_POST['advariationid'];
        if(isset($_POST['start'])) $start = $_POST['start'];
        if(isset($_POST['end'])) $end = $_POST['end'];

        if(!isset($advertisementid))
        {
            $result = array('status'=>'fail', 'data'=>"Invalid Advertisement information!");
            echo json_encode($result);
            exit();
        }

        $performanceSQL = "select sum(gara.clicks) as clicks, sum(gara.impressions) as impr, sum(gara.cost) / ".Yii::app()->params['google']['AdWords']['reportCurrencyUnit']." as cost
                            from lt_ad_advertise_variation t
                            left join lt_google_adwords_ad gaa on gaa.lt_ad_advertise_variation_id = t.id
                            left join lt_google_adwords_report_ad gara on gara.id = gaa.id and gara.date >= :startdate and gara.date <= :enddate
                            where t.company_id = :company_id and t.ad_advertise_id = :ad_advertise_id";
        $command = Yii::app()->db->createCommand($performanceSQL);
        $command->bindValue(":company_id", Yii::app()->session['user']->company_id, PDO::PARAM_INT);
        $command->bindValue(":ad_advertise_id", $advertisementid, PDO::PARAM_INT);
        $command->bindValue(":startdate", $start, PDO::PARAM_STR);
        $command->bindValue(":enddate", $end, PDO::PARAM_STR);
        $result = $command->queryRow();
        $performance = array('clicks'=>null, 'impr'=>null, 'cost'=>null);
        if(!empty($result)) $performance = array('clicks'=>$result['clicks'], 'impr'=>$result['impr'], 'cost'=>$result['cost']);

        //get ad variation performance if have
        $adPerformanceSQL = "select t.id, t.code, t.width, t.height, t.status, sum(gara.clicks) as clicks, sum(gara.impressions) as impr, sum(gara.cost) / ".Yii::app()->params['google']['AdWords']['reportCurrencyUnit']." as cost
                                from lt_ad_advertise_variation t
                                left join lt_google_adwords_ad gaa on gaa.lt_ad_advertise_variation_id = t.id
                                left join lt_google_adwords_report_ad gara on gara.id = gaa.id and gara.date >= :startdate and gara.date <= :enddate
                                where t.company_id = :company_id and t.ad_advertise_id = :ad_advertise_id
                                group by t.id
                                order by t.id desc";
        $command = Yii::app()->db->createCommand($adPerformanceSQL);
        $command->bindValue(":company_id", Yii::app()->session['user']->company_id, PDO::PARAM_INT);
        $command->bindValue(":ad_advertise_id", $advertisementid, PDO::PARAM_INT);
        $command->bindValue(":startdate", $start, PDO::PARAM_STR);
        $command->bindValue(":enddate", $end, PDO::PARAM_STR);
        $adVariationPerformance = $command->queryAll();

        $performanceList = $this->getAdvertisementPerformance($advertisementid, $advariationid, $start, $end);

        $result = array('status'=>'success', 'all'=>$performance, 'advariation'=>$adVariationPerformance, 'chart'=>$performanceList);
        echo json_encode($result);
    }

    public function actionGetADGroupList($adcampaignid=null)
    {
        if(isset($_POST['adcampaignid'])) $adcampaignid = $_POST['adcampaignid'];
        $criteria=new CDbCriteria;
        $criteria->condition='company_id=:company_id'.(isset($adcampaignid) && $adcampaignid > 0 ? ' and campaign_id = :campaign_id' : '');
        $criteria->params=array(':company_id'=>Yii::app()->session['user']->company_id);
        if(isset($adcampaignid) && $adcampaignid > 0)
            $criteria->params[':campaign_id'] = $adcampaignid;
        $adGroupList=ADGroup::model()->findAll($criteria);

        $result = array('status'=>'success', 'data'=>CHtml::listData($adGroupList, 'id', 'name'));
        echo json_encode($result);
    }

    public function actionGetIndexPerformance($adcampaignid=null, $adgroupid=null, $start='', $end='')
    {
        if(!$end) $end = date("Y-m-d");
        if(!$start) $start = date("Y-m-d", strtotime(date("Y-m-d")) - 60 * 60 * 24 * 34);

        if(isset($_POST['adcampaignid'])) $adcampaignid = $_POST['adcampaignid'];
        if(isset($_POST['adgroupid'])) $adgroupid = $_POST['adgroupid'];
        if(isset($_POST['start'])) $start = $_POST['start'];
        if(isset($_POST['end'])) $end = $_POST['end'];

        $whereSQL = "";
        if(isset($adcampaignid) && $adcampaignid)
        {
            $whereSQL .= " and t.ad_campaign_id = :ad_campaign_id ";
        }
        if(isset($adgroupid) && $adgroupid)
        {
            $whereSQL .= " and t.ad_group_id = :ad_group_id ";
        }
        $performanceSQL = "SELECT t.id, t.name, sum(gara.clicks) as clicks, sum(gara.impressions) as impr, sum(gara.cost) / ".Yii::app()->params['google']['AdWords']['reportCurrencyUnit']." as cost
                            FROM lt_ad_advertise t
                            left join lt_ad_advertise_variation aav on aav.ad_advertise_id = t.id
                            left join lt_google_adwords_ad gaa on gaa.lt_ad_advertise_variation_id = aav.id
                            left join lt_google_adwords_report_ad gara on gara.id = gaa.id and gara.date >= :startdate and gara.date <= :enddate
                            where t.company_id = :company_id
                            $whereSQL
                            group by t.id
                            order by t.id desc";
        $command = Yii::app()->db->createCommand($performanceSQL);
        $command->bindValue(":company_id", Yii::app()->session['user']->company_id, PDO::PARAM_INT);
        $command->bindValue(":startdate", $start, PDO::PARAM_STR);
        $command->bindValue(":enddate", $end, PDO::PARAM_STR);
        if(isset($adcampaignid) && $adcampaignid)
        {
            $command->bindValue(":ad_campaign_id", $adcampaignid, PDO::PARAM_INT);
        }
        if(isset($adgroupid) && $adgroupid)
        {
            $command->bindValue(":ad_group_id", $adgroupid, PDO::PARAM_INT);
        }
        $adPerformance = $command->queryAll();

        $result = array('status'=>'success', 'data'=>$adPerformance);
        echo json_encode($result);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Department the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=ADAdvertise::model()->findByPk($id, "company_id=:company_id" ,array(':company_id' => Yii::app()->session['user']->company_id));
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete, getDynamicGroupList, getListingParams, uploadLogo, getPerformanceData, updateVariationStatus', // we only allow deletion via POST request
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
                'actions'=>array('index', 'create', 'view', 'update', 'getDynamicGroupList', 'getListingParams', 'uploadLogo', 'view', 'getPerformanceData', 'updateVariationStatus', 'getPerformanceStatistic', 'getADGroupList', 'getIndexPerformance'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
}