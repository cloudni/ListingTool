<?php

class ADCampaignController extends Controller
{
    public $layout='';

	public function actionIndex()
	{
        $this->layout='//layouts/column2';

		$this->render('index',array());
	}

    public function actionCreate()
    {
        $model = new ADCampaign();

        if(isset($_POST['campaign']))
        {
            $transaction=NULL;
            try
            {
                $transaction = Yii::app()->db->beginTransaction();
                $model->name = (string)$_POST['campaign']['name'];
                $model->budget = (float)$_POST['campaign']['budget'];
                $model->company_id = Yii::app()->session['user']->company_id;
                $model->status = ADCampaign::Status_Pending;
                $model->is_delete = ADCampaign::Delete_No;
                $criteria['language'] = !isset($_POST['language_option_all_value']) && isset($_POST['language_option_value']) && !empty($_POST['language_option_value']) ? implode(',', $_POST['language_option_value']) : '';
                $locations = array();
                foreach($_POST as $key => $value)
                {
                    if(substr($key, 0, 37) === 'exclude_ship_location_worldwide_list_') foreach($value as $local) $locations[] = $local;
                }
                $criteria['location'] = implode(',', $locations);
                $criteria['timezone'] = $_POST['schedule_timezone'];
                $model->start_datetime = strtotime($_POST['startdate']);
                $model->end_datetime = $_POST['enddate_select'] == 'select_end_date' && isset($_POST['enddate']) ? strtotime($_POST['enddate']) : null;
                if(isset($_POST['schedule_option_value_day']) && !empty($_POST['schedule_option_value_day']))
                {
                    $criteria['schedule'] = array();
                    for($i = 0; $i < count($_POST['schedule_option_value_day']); $i++)
                    {
                        if(!isset($_POST['schedule_option_value_day'][$i]) || !isset($_POST['schedule_option_value_from_hour'][$i]) || !isset($_POST['schedule_option_value_from_minute'][$i]) || !isset($_POST['schedule_option_value_to_hour'][$i]) || !isset($_POST['schedule_option_value_to_minute'][$i])) continue;
                        $criteria['schedule'][] = array('day' => $_POST['schedule_option_value_day'][$i], 'from_hour' => $_POST['schedule_option_value_from_hour'][$i], 'from_minute' => $_POST['schedule_option_value_from_minute'][$i], 'to_hour' => $_POST['schedule_option_value_to_hour'][$i], 'to_minute' => $_POST['schedule_option_value_to_minute'][$i],);
                    }
                }
                $model->criteria = json_encode($criteria);
                if($model->save())
                {
                    $aDLog = new ADChangeLog();
                    $aDLog->company_id = Yii::app()->session['user']->company_id;
                    $aDLog->object_type = "ADCampaign";
                    $aDLog->object_id = $model->id;
                    $aDLog->title = "Add New AD Campaign for Company: " . Yii::app()->session['user']->company->name;
                    $aDLog->action = ADChangeLog::Action_AddNew;
                    $aDLog->status = ADChangeLog::Status_Pending;
                    $aDLog->priority = ADChangeLog::Priority_Normal;
                    $aDLog->create_time_utc = time();
                    $aDLog->create_user_id = Yii::app()->session['user']->id;
                    $content = "";
                    $content .= "Add New AD Campaign for Company id: " . Yii::app()->session['user']->company->id . ", name: " . Yii::app()->session['user']->company->name . "<br />";
                    $content .= "Campaign Name: {$model->name}.<br />";
                    $content .= "Campaign Budget: " . sprintf("$%1\$.2f", $model->budget) . "<br />";
                    $content .= "Campaign Start Date: " . date('Y-m-d', $model->start_datetime) . "<br />";
                    if(isset($model->end_datetime)) $content .= "Campaign End Date: " . date('Y-m-d', $model->end_datetime) . "<br />";
                    $content .= "Campaign Language: " . ($criteria['language'] ? $criteria['language'] : "All Languages") . "<br />";
                    $content .= "Campaign Location: " . ($criteria['location'] ? $criteria['location'] : "All Countries and Regions") . "<br />";
                    if(isset($criteria['schedule']) && !empty($criteria['schedule']))
                    {
                        $content .= "Campaign Time-zone: {$criteria['timezone']}<br />";
                        $content .= "Campaign Schedule:<br/>";
                        foreach($criteria['schedule'] as $schedule) $content .= "Day: {$schedule['day']}, From: {$schedule['from_hour']}:{$schedule['from_minute']}, To: {$schedule['to_hour']}:{$schedule['to_minute']}<br />";
                    }
                    $aDLog->content = $content;
                    $aDLog->save();

                    $transaction->commit();

                    $this->redirect($this->createAbsoluteUrl("marketing/advertisement/ADGroup/create", array('campaignid' => $model->id, 'lead' => true,)));
                }
            }
            catch(Exception $ex)
            {
                if(isset($transaction)) $transaction->rollback();
                Yii::app()->user->setFlash('Error', "Fail to create new AD Campaign, Code: ".$ex->getCode().", Msg: ".$ex->getMessage());
            }
        }

        $this->render('create', array(
            'model'=>$model,
        ));
    }

    public function actionView($id)
    {
        $this->layout='//layouts/column2';
        $model = $this->loadModel($id);

        $this->render('view',array(
            'model'=>$model,
        ));
    }

    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);

        if(isset($_POST['campaign']))
        {
            $transaction=NULL;
            try
            {
                $transaction = Yii::app()->db->beginTransaction();
                $oldModel = $this->loadModel($id);
                $model->budget = (float)$_POST['campaign']['budget'];
                $model->company_id = Yii::app()->session['user']->company_id;
                $model->status = ADCampaign::Status_Eligible;
                $model->is_delete = ADCampaign::Delete_No;
                $criteria['language'] = !isset($_POST['language_option_all_value']) && isset($_POST['language_option_value']) && !empty($_POST['language_option_value']) ? implode(',', $_POST['language_option_value']) : '';
                $locations = array();
                foreach($_POST as $key => $value)
                {
                    if(substr($key, 0, 37) === 'exclude_ship_location_worldwide_list_') foreach($value as $local) $locations[] = $local;
                }
                $criteria['location'] = implode(',', $locations);
                $criteria['timezone'] = $_POST['schedule_timezone'];
                $model->start_datetime = strtotime($_POST['startdate']);
                $model->end_datetime = $_POST['enddate_select'] == 'select_end_date' && isset($_POST['enddate']) ? strtotime($_POST['enddate']) : null;
                if(isset($_POST['schedule_option_value_day']) && !empty($_POST['schedule_option_value_day']))
                {
                    $criteria['schedule'] = array();
                    for($i = 0; $i < count($_POST['schedule_option_value_day']); $i++)
                    {
                        if(!isset($_POST['schedule_option_value_day'][$i]) || !isset($_POST['schedule_option_value_from_hour'][$i]) || !isset($_POST['schedule_option_value_from_minute'][$i]) || !isset($_POST['schedule_option_value_to_hour'][$i]) || !isset($_POST['schedule_option_value_to_minute'][$i])) continue;
                        $criteria['schedule'][] = array('day' => $_POST['schedule_option_value_day'][$i], 'from_hour' => $_POST['schedule_option_value_from_hour'][$i], 'from_minute' => $_POST['schedule_option_value_from_minute'][$i], 'to_hour' => $_POST['schedule_option_value_to_hour'][$i], 'to_minute' => $_POST['schedule_option_value_to_minute'][$i],);
                    }
                }
                $model->criteria = json_encode($criteria);
                if($model->save())
                {
                    $aDLog = new ADChangeLog();
                    $aDLog->company_id = Yii::app()->session['user']->company_id;
                    $aDLog->object_type = "ADCampaign";
                    $aDLog->object_id = $model->id;
                    $aDLog->title = "UpDate AD Campaign for Company: " . Yii::app()->session['user']->company->name . ", Campaign Name: " . $model->name;
                    $aDLog->action = ADChangeLog::Action_Update;
                    $aDLog->status = ADChangeLog::Status_Pending;
                    $aDLog->priority = ADChangeLog::Priority_Normal;
                    $aDLog->create_time_utc = time();
                    $aDLog->create_user_id = Yii::app()->session['user']->id;
                    $content = "";
                    $content .= "UpDate AD Campaign for Company id: " . Yii::app()->session['user']->company->id . ", name: " . Yii::app()->session['user']->company->name . "<br />";
                    $content .= "Campaign Name: {$model->name}.<br />";
                    if($oldModel->budget != $model->budget) $content .= "Campaign Budget Changed From: " . sprintf("$%1\$.2f", $oldModel->budget) . ", To: " . sprintf("$%1\$.2f", $model->budget) . "<br />";
                    if($oldModel->start_datetime != $model->start_datetime) $content .= "Campaign Start Date Changed From: " . date('Y-m-d', $oldModel->start_datetime) . ", To: " . date('Y-m-d', $model->start_datetime) . "<br />";
                    if($oldModel->end_datetime != $model->end_datetime) $content .= "Campaign End Date Changed From: " . (isset($oldModel->end_datetime) ? date('Y-m-d', $oldModel->end_datetime) : "NULL") . ", TO: " . (isset($model->end_datetime) ? date('Y-m-d', $model->end_datetime) : "NULL") . "<br />";
                    $oldCriteria = json_decode($oldModel->criteria);
                    if((string)$oldCriteria->language != $criteria['language']) $content .= "Campaign Language Changed From: " . ((string)$oldCriteria->language ? (string)$oldCriteria->language : "All Languages") . ", To: " . ($criteria['language'] ? $criteria['language'] : "All Languages") . "<br />";
                    if((string)$oldCriteria->location != $criteria['location']) $content .= "Campaign Location Changed From: " . ((string)$oldCriteria->location ? (string)$oldCriteria->location : "All Countries and Regions") . ", To: " . ($criteria['location'] ? $criteria['location'] : "All Countries and Regions") . "<br />";
                    if(isset($criteria['schedule']) && !empty($criteria['schedule']))
                    {
                        $content .= "Campaign Time-zone Changed To: {$criteria['timezone']}<br />";
                        $content .= "Campaign Schedule Changed To:<br />";
                        foreach($criteria['schedule'] as $schedule) $content .= "Day: {$schedule['day']}, From: {$schedule['from_hour']}:{$schedule['from_minute']}, To: {$schedule['to_hour']}:{$schedule['to_minute']}<br />";
                    }
                    $aDLog->content = $content;
                    $aDLog->save();

                    $transaction->commit();

                    $this->redirect($this->createAbsoluteUrl("marketing/advertisement/ADCampaign/view", array('id' => $model->id)));
                }
            }
            catch(Exception $ex)
            {
                if(isset($transaction)) $transaction->rollback();
                Yii::app()->user->setFlash('Error', "Fail to update new AD Campaign, Code: ".$ex->getCode().", Msg: ".$ex->getMessage());
            }
        }

        $this->render('update',array(
            'model'=>$model,
        ));
    }

    protected function getCampaignPerformance($campaignid=0, $adgroupid=null, $start='', $end='')
    {
        $performanceList = array();

        $whereSQL = "";
        $groupBySQL = "group by garag.date ";
        if(isset($adgroupid) && $adgroupid)
        {
            $whereSQL .= " and ag.id = :group_id ";
            $groupBySQL .= ", ag.id ";
        }
        $performanceSQL = "select sum(garag.clicks) as clicks, sum(garag.impressions) as impr, sum(garag.charge_amount) as cost,
                            garag.date, garag.month, garag.year, garag.date, garag.week, garag.month_of_year
                            from lt_ad_campaign t
                            left join lt_ad_group ag on ag.campaign_id = t.id
                            left join lt_google_adwords_ad_group gaag on gaag.lt_ad_group_id = ag.id
                            inner join lt_ad_google_adwords_report_ad_group garag on garag.ad_group_id = gaag.id and garag.date >= :startdate and garag.date <= :enddate
                            where t.company_id = :company_id and t.id = :campaignid
                            $whereSQL $groupBySQL
                            order by garag.date desc";
        $command = Yii::app()->db->createCommand($performanceSQL);
        $command->bindValue(":company_id", Yii::app()->session['user']->company_id, PDO::PARAM_INT);
        $command->bindValue(":campaignid", $campaignid, PDO::PARAM_INT);
        $command->bindValue(":startdate", $start, PDO::PARAM_STR);
        $command->bindValue(":enddate", $end, PDO::PARAM_STR);
        if(isset($adgroupid) && $adgroupid)
        {
            $command->bindValue(":group_id", $adgroupid, PDO::PARAM_INT);
        }
        $performances = $command->queryAll();

        $index = 0;
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
                if(isset($performanceList[$performance['date']])) $performanceList[$performance['date']] = array(
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

    public function actionGetPerformanceData($adcampaignid=null, $adgroupid=null, $start='', $end='')
    {
        if(!$end) $end = date("Y-m-d");
        if(!$start) $start = date("Y-m-d", strtotime(date("Y-m-d")) - 60 * 60 * 24 * 14);

        if(isset($_POST['adcampaignid'])) $adcampaignid = $_POST['adcampaignid'];
        if(isset($_POST['adgroupid'])) $adgroupid = $_POST['adgroupid'];
        if(isset($_POST['start'])) $start = $_POST['start'];
        if(isset($_POST['end'])) $end = $_POST['end'];

        if(!isset($adcampaignid))
        {
            $result = array('status'=>'fail', 'data'=>"Invalid AD Campaign and AD Group!");
            echo json_encode($result);
            exit();
        }

        $performanceList = $this->getCampaignPerformance($adcampaignid, $adgroupid, $start, $end);

        echo json_encode($performanceList);
        exit();
    }

    public function actionUpdateCampaignStatus()
    {
        $status = isset($_POST['status']) ? $_POST['status'] : null;
        $appliedList = isset($_POST['idList']) ? $_POST['idList'] : null;;
        $successList = array();
        if(!array_key_exists($status, ADCampaign::getStatusOptions()))
        {
            $result = array('status'=>'fail', 'msg'=>"Invalid Campaign Status!");
            echo json_encode($result);
            exit();
        }
        foreach($appliedList as $id)
        {
            $transaction=NULL;
            try
            {
                $transaction = Yii::app()->db->beginTransaction();
                $campaign = ADCampaign::model()->findByPk($id, "company_id=:company_id", array(':company_id' => Yii::app()->session['user']->company_id));
                if($campaign != null)
                {
                    $oldStatus = $campaign->status;
                    $campaign->status = $status;
                    if($campaign->save())
                    {
                        $successList[] = $campaign->id;

                        $aDLog = new ADChangeLog();
                        $aDLog->company_id = Yii::app()->session['user']->company_id;
                        $aDLog->object_type = "ADCampaign";
                        $aDLog->object_id = $campaign->id;
                        $aDLog->title = "UpDate AD Campaign for Company: " . Yii::app()->session['user']->company->name . ", Campaign Name: " . $campaign->name;
                        $aDLog->action = ADChangeLog::Action_Update;
                        $aDLog->status = ADChangeLog::Status_Pending;
                        $aDLog->priority = ADChangeLog::Priority_Normal;
                        $aDLog->create_time_utc = time();
                        $aDLog->create_user_id = Yii::app()->session['user']->id;
                        $content = "";
                        $content .= "UpDate AD Campaign for Company id: " . Yii::app()->session['user']->company->id . ", name: " . Yii::app()->session['user']->company->name . "<br />";
                        $content .= "Campaign Name: {$campaign->name}.<br />";
                        $content .= "Campaign Status Changed From: " . ADCampaign::getStatusText($oldStatus) . ", To: " . ADCampaign::getStatusText($status) . "<br />";
                        $aDLog->content = $content;
                        $aDLog->save();
                    }
                }
                $transaction->commit();
            }
            catch(Exception $ex)
            {
                if(isset($transaction)) $transaction->rollback();
            }
        }

        $result = array('status'=>'success', 'data'=>$successList);
        echo json_encode($result);
        exit();
    }

    public function actionAutomaticPlacementReport($id)
    {
        $this->layout='//layouts/column2';
        $model = $this->loadModel($id);

        $placementSQL = "SELECT t.domain, t.clicks, t.impressions as impr, t.charge_amount as cost
                            FROM lt_ad_google_adwords_report_automatic_placements t
                            left join lt_google_adwords_campaign gaag on gaag.id = t.campaign_id
                            left join lt_ad_campaign ag on ag.id = gaag.lt_ad_campaign_id
                            where ag.company_id = :company_id and ag.id = :campaign_id";
        $command = Yii::app()->db->createCommand($placementSQL);
        $command->bindValue(":company_id", Yii::app()->session['user']->company_id, PDO::PARAM_INT);
        $command->bindValue(":campaign_id", $id, PDO::PARAM_INT);
        $placements = $command->queryAll();

        $this->render("automaticPlacement", array(
            'model'=>$model,
            'placements'=>$placements,
        ));
    }

    public function actionGeoGraphicReport($id)
    {
        $this->layout='//layouts/column2';
        $model = $this->loadModel($id);

        $sql="SELECT sum(garg.clicks) as clicks, sum(garg.impressions) as impr, sum(garg.charge_amount) as cost, garg.location_type,
                garg.city_criteria_id, garg.region_criteria_id, garg.country_criteria_id
                from lt_ad_campaign t
                left join lt_google_adwords_campaign gac on gac.lt_ad_campaign_id = t.id
                left join lt_ad_google_adwords_report_geo garg on garg.campaign_id = gac.id
                where t.id = :campaign_id and t.company_id = :company_id
                group by garg.city_criteria_id";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":company_id", Yii::app()->session['user']->company_id, PDO::PARAM_INT);
        $command->bindValue(":campaign_id", $id, PDO::PARAM_INT);
        $performances = $command->queryAll();

        $this->render("geoGraphic", array(
            'model'=>$model,
            'performances'=>$performances,
        ));
    }

    public function actionKeywordsReport($id)
    {
        $this->layout='//layouts/column2';
        $model = $this->loadModel($id);

        $sql = "SELECT sum(garg.clicks) as clicks, sum(garg.impressions) as impr, sum(garg.charge_amount) as cost, garg.keyword_text,
                garg.date, garg.month, garg.year,
                garg.status
                from lt_ad_campaign t
                left join lt_google_adwords_campaign gac on gac.lt_ad_campaign_id = t.id
                left join lt_ad_google_adwords_report_keywords garg on garg.campaign_id = gac.id
                where t.id = :campaign_id and t.company_id = :company_id
                group by garg.keyword_text";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":company_id", Yii::app()->session['user']->company_id, PDO::PARAM_INT);
        $command->bindValue(":campaign_id", $id, PDO::PARAM_INT);
        $performances = $command->queryAll();

        $this->render("keywordsReport", array(
            'model'=>$model,
            'performances'=>$performances,
        ));
    }

    public function actionGetPerformanceStatistic($adcampaignid=null, $adgroupid=null, $start='', $end='')
    {
        if(!$end) $end = date("Y-m-d");
        if(!$start) $start = date("Y-m-d", strtotime(date("Y-m-d")) - 60 * 60 * 24 * 14);

        if(isset($_POST['adcampaignid'])) $adcampaignid = $_POST['adcampaignid'];
        if(isset($_POST['adgroupid'])) $adgroupid = $_POST['adgroupid'];
        if(isset($_POST['start'])) $start = $_POST['start'];
        if(isset($_POST['end'])) $end = $_POST['end'];

        if(!isset($adcampaignid))
        {
            $result = array('status'=>'fail', 'data'=>"Invalid AD Campaign and AD Group!");
            echo json_encode($result);
            exit();
        }

        $performanceSQL = "SELECT sum(t.clicks) as clicks, sum(t.impressions) as impr, sum(t.charge_amount) as cost
                            FROM lt_ad_google_adwords_report_campaign t
                            left join lt_google_adwords_campaign gac on gac.id = t.campaign_id
                            left join lt_ad_campaign adc on adc.id = gac.lt_ad_campaign_id
                            where adc.id=:id and t.date >= :startdate and t.date <= :enddate ";
        $command = Yii::app()->db->createCommand($performanceSQL);
        $command->bindValue(":id", $adcampaignid, PDO::PARAM_INT);
        $command->bindValue(":startdate", $start, PDO::PARAM_STR);
        $command->bindValue(":enddate", $end, PDO::PARAM_STR);
        $result = $command->queryRow();
        $performance = array('clicks'=>null, 'impr'=>null, 'cost'=>null);
        if(!empty($result)) $performance = array('clicks'=>$result['clicks'], 'impr'=>$result['impr'], 'cost'=>$result['cost']);

        $adGroupPerformanceSQL = "SELECT t.id, t.name, t.default_bid, t.status, sum(garc.clicks) as clicks, sum(garc.impressions) as impr, sum(garc.charge_amount) as cost
                                    FROM lt_ad_group t
                                    left join lt_google_adwords_ad_group gac on gac.lt_ad_group_id = t.id
                                    left join lt_ad_google_adwords_report_ad_group garc on garc.ad_group_id = gac.id and garc.date >= :startdate and garc.date <= :enddate
                                    where t.campaign_id = :campaign_id
                                    group by t.id";
        $command = Yii::app()->db->createCommand($adGroupPerformanceSQL);
        $command->bindValue(":campaign_id", $adcampaignid, PDO::PARAM_INT);
        $command->bindValue(":startdate", $start, PDO::PARAM_STR);
        $command->bindValue(":enddate", $end, PDO::PARAM_STR);
        $result = $command->queryAll();
        $adGroupPerformance = $result;

        $performanceList = $this->getCampaignPerformance($adcampaignid, $adgroupid, $start, $end);

        $result = array('status'=>'success', 'all'=>$performance, 'group'=>$adGroupPerformance, 'chart'=>$performanceList);
        echo json_encode($result);
    }

    public function actionGetIndexPerformance($start='', $end='')
    {
        if(!$end) $end = date("Y-m-d");
        if(!$start) $start = date("Y-m-d", strtotime(date("Y-m-d")) - 60 * 60 * 24 * 14);

        if(isset($_POST['start'])) $start = $_POST['start'];
        if(isset($_POST['end'])) $end = $_POST['end'];

        $campaignPerformanceSQL = "SELECT t.id, t.name, t.budget, t.status, sum(garc.clicks) as clicks, sum(garc.impressions) as impr, sum(garc.charge_amount) as cost
                                    FROM lt_ad_campaign t
                                    left join lt_google_adwords_campaign gac on gac.lt_ad_campaign_id = t.id
                                    left join lt_ad_google_adwords_report_campaign garc on garc.campaign_id = gac.id and garc.date >= :startdate and garc.date <= :enddate
                                    where t.company_id = :company_id
                                    group by t.id
                                    order by t.id desc";
        $command = Yii::app()->db->createCommand($campaignPerformanceSQL);
        $command->bindValue(":company_id", Yii::app()->session['user']->company_id, PDO::PARAM_INT);
        $command->bindValue(":startdate", $start, PDO::PARAM_STR);
        $command->bindValue(":enddate", $end, PDO::PARAM_STR);
        $campaignPerformance = $command->queryAll();

        $result = array('status'=>'success', 'all'=>$campaignPerformance);
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
        $model=ADCampaign::model()->findByPk($id, "company_id=:company_id" ,array(':company_id' => Yii::app()->session['user']->company_id));
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
            'postOnly + delete, getPerformanceData, updateCampaignStatus, getPerformanceStatistic, getIndexPerformance', // we only allow deletion via POST request
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
                'actions'=>array('index', 'create', 'view', 'update', 'getPerformanceData', 'updateCampaignStatus', 'automaticPlacementReport', 'geoGraphicReport', 'keywordsReport', 'getPerformanceStatistic', 'getIndexPerformance'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
}