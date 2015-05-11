<?php

class ADGroupController extends Controller
{
    public $layout='';

	public function actionIndex()
	{
        $this->layout='//layouts/column2';

        $campaignList = ADCampaign::model()->findAll("company_id=:company_id" ,array(':company_id' => Yii::app()->session['user']->company_id));

		$this->render('index', array(
            'campaignList'=>$campaignList,
        ));
	}

    public function actionCreate($campaignid=null, $lead=false)
    {
        $model = new ADGroup();

        if(isset($_POST['adgroup']))
        {
            $transaction=NULL;
            try
            {
                $transaction = Yii::app()->db->beginTransaction();
                $model->company_id = Yii::app()->session['user']->company_id;
                $model->name = $_POST['adgroup']['name'];
                $model->default_bid = $_POST['adgroup']['default_bid'];
                $model->campaign_id = $campaignid;
                $model->status = ADGroup::Status_Pending;
                $model->is_delete = ADGroup::Delete_No;
                $criteria = array('keywords' => str_replace("\n", ADGroup::Criteria_Separator, $_POST['keywords']), 'placements' => str_replace("\n", ADGroup::Criteria_Separator, $_POST['placements']),);
                $model->criteria = json_encode($criteria);
                if($model->save())
                {
                    $aDLog = new ADChangeLog();
                    $aDLog->company_id = Yii::app()->session['user']->company_id;
                    $aDLog->object_type = "ADGroup";
                    $aDLog->object_id = $model->id;
                    $aDLog->title = "Add New AD Group for Company: " . Yii::app()->session['user']->company->name;
                    $aDLog->action = ADChangeLog::Action_AddNew;
                    $aDLog->status = ADChangeLog::Status_Pending;
                    $aDLog->priority = ADChangeLog::Priority_Normal;
                    $aDLog->create_time_utc = time();
                    $aDLog->create_user_id = Yii::app()->session['user']->id;
                    $content = "";
                    $content .= "Add New AD Group for Company id: " . Yii::app()->session['user']->company->id . ", name: " . Yii::app()->session['user']->company->name . "<br />";
                    $content .= "Group Name: {$model->name}.<br />";
                    $content .= "Group Max default CPC: " . sprintf("$%1\$.2f", $model->default_bid) . "<br />";
                    $content .= "Group Display Keywords: " . ($criteria['keywords'] ? $criteria['keywords'] : "") . "<br />";
                    $content .= "Group Placements: " . ($criteria['placements'] ? $criteria['placements'] : "") . "<br />";
                    $aDLog->content = $content;
                    $aDLog->save();

                    $transaction->commit();
                    $this->redirect($this->createAbsoluteUrl("marketing/advertisement/AD/create", array('adcampaignid' => $model->id, 'adgroupid' => $model->id, 'lead' => $lead,)));
                }
            }
            catch(Exception $ex)
            {
                if(isset($transaction)) $transaction->rollback();
                Yii::app()->user->setFlash('Error', "Fail to create new AD Group, Code: ".$ex->getCode().", Msg: ".$ex->getMessage());
            }
        }

        if(!isset($campaignid))
        {
            $this->render('chooseCampaign');
            exit();
        }

        $this->render('create', array(
            'model'=>$model,
            'lead'=>$lead,
        ));
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if(isset($_POST['adgroup']))
        {
            $transaction=NULL;
            try
            {
                $transaction = Yii::app()->db->beginTransaction();
                $oldModel = $this->loadModel($id);
                $oldCriteria = json_decode($oldModel->criteria);
                $model->default_bid = $_POST['adgroup']['default_bid'];
                $criteria = array('keywords' => str_replace("\n", ADGroup::Criteria_Separator, $_POST['keywords']), 'placements' => str_replace("\n", ADGroup::Criteria_Separator, $_POST['placements']),);
                $model->criteria = json_encode($criteria);
                if($model->save())
                {
                    $aDLog = new ADChangeLog();
                    $aDLog->company_id = Yii::app()->session['user']->company_id;
                    $aDLog->object_type = "ADGroup";
                    $aDLog->object_id = $model->id;
                    $aDLog->title = "UpDate AD Group for Company: " . Yii::app()->session['user']->company->name . ", Group Name: " . $model->name;
                    $aDLog->action = ADChangeLog::Action_Update;
                    $aDLog->status = ADChangeLog::Status_Pending;
                    $aDLog->priority = ADChangeLog::Priority_Normal;
                    $aDLog->create_time_utc = time();
                    $aDLog->create_user_id = Yii::app()->session['user']->id;
                    $content = "";
                    $content .= "UpDate AD Group for Company id: " . Yii::app()->session['user']->company->id . ", name: " . Yii::app()->session['user']->company->name . "<br />";
                    $content .= "Group Name: {$model->name}.<br />";
                    if($oldModel->default_bid != $model->default_bid) $content .= "Group Max default CPC From: " . sprintf("$%1\$.2f", $oldModel->default_bid) . ", To: " . sprintf("$%1\$.2f", $model->default_bid) . "<br />";
                    if($oldCriteria->keywords != $criteria->keywords) $content .= "Group Display Keywords: " . $oldCriteria->keywords . ", To: " . $criteria->keywords . "<br />";
                    if($oldCriteria->placements != $criteria->placements) $content .= "Group Placements: " . $oldCriteria->placements . ", To: " . $criteria->placements . "<br />";
                    $aDLog->content = $content;

                    $transaction->commit();
                    $this->redirect($this->createAbsoluteUrl("marketing/advertisement/ADGroup/view", array('id' => $model->id)));
                }
            }
            catch(Exception $ex)
            {
                if(isset($transaction)) $transaction->rollback();
                Yii::app()->user->setFlash('Error', "Fail to update new AD Group, Code: ".$ex->getCode().", Msg: ".$ex->getMessage());
            }
        }

        $this->render('update', array(
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

    protected function getADGroupPerformance($adgroupid=null, $advertisementid=null, $start='', $end='')
    {
        $performanceList = array();

        $whereSQL = " ";
        $groupBySQL = " group by gara.date";

        if(isset($advertisementid) && $advertisementid)
        {
            $whereSQL .= " and t.id = :advertisement_id ";
            $groupBySQL .= " , t.id ";
        }
        $performanceSQL = "select t.id, gaa.id, sum(gara.clicks) as clicks, sum(gara.impressions) as impr, sum(gara.charge_amount) as cost, gara.date, gara.month, gara.year, gara.week, gara.month_of_year
                            from lt_ad_advertise t
                            left join lt_ad_advertise_variation aav on aav.ad_advertise_id = t.id
                            left join lt_google_adwords_ad gaa on gaa.lt_ad_advertise_variation_id = aav.id
                            inner join lt_ad_google_adwords_report_ad gara on gara.id = gaa.id and gara.date >= :startdate and gara.date <= :enddate
                            where t.company_id = :company_id and t.ad_group_id = :ad_group_id
                            $whereSQL $groupBySQL";
        $command = Yii::app()->db->createCommand($performanceSQL);
        $command->bindValue(":company_id", Yii::app()->session['user']->company_id, PDO::PARAM_INT);
        $command->bindValue(":ad_group_id", $adgroupid, PDO::PARAM_INT);
        $command->bindValue(":startdate", $start, PDO::PARAM_STR);
        $command->bindValue(":enddate", $end, PDO::PARAM_STR);
        if(isset($advertisementid) && $advertisementid)
        {
            $command->bindValue(":advertisement_id", $advertisementid, PDO::PARAM_INT);
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

    public function actionGetPerformanceData($adgroupid=null, $advertisementid=null, $start='', $end='')
    {
        if(!$end) $end = date("Y-m-d");
        if(!$start) $start = date("Y-m-d", strtotime(date("Y-m-d")) - 60 * 60 * 24 * 14);

        if(isset($_POST['advertisementid'])) $advertisementid = $_POST['advertisementid'];
        if(isset($_POST['adgroupid'])) $adgroupid = $_POST['adgroupid'];
        if(isset($_POST['start'])) $start = $_POST['start'];
        if(isset($_POST['end'])) $end = $_POST['end'];

        if(!isset($adgroupid))
        {
            $result = array('status'=>'fail', 'data'=>"Invalid AD information!");
            echo json_encode($result);
            exit();
        }

        $performanceList = $this->getADGroupPerformance($adgroupid, $advertisementid, $start, $end);

        echo json_encode($performanceList);
        exit();
    }

    public function actionUpdateGroupStatus()
    {
        $status = isset($_POST['status']) ? $_POST['status'] : null;
        $appliedList = isset($_POST['idList']) ? $_POST['idList'] : null;;
        $successList = array();
        if(!array_key_exists($status, ADGroup::getStatusOptions()))
        {
            $result = array('status'=>'fail', 'msg'=>"Invalid AD Group Status!");
            echo json_encode($result);
            exit();
        }
        foreach($appliedList as $id)
        {
            $transaction=NULL;
            try
            {
                $transaction = Yii::app()->db->beginTransaction();
                $adGroup = ADGroup::model()->findByPk($id, "company_id=:company_id", array(':company_id' => Yii::app()->session['user']->company_id));
                if($adGroup != null)
                {
                    $oldStatus = $adGroup->status;
                    $adGroup->status = $status;
                    if($adGroup->save())
                    {
                        $successList[] = $adGroup->id;

                        $aDLog = new ADChangeLog();
                        $aDLog->company_id = Yii::app()->session['user']->company_id;
                        $aDLog->object_type = "ADGroup";
                        $aDLog->object_id = $adGroup->id;
                        $aDLog->title = "UpDate AD Group for Company: " . Yii::app()->session['user']->company->name . ", Group Name: " . $adGroup->name;
                        $aDLog->action = ADChangeLog::Action_Update;
                        $aDLog->status = ADChangeLog::Status_Pending;
                        $aDLog->priority = ADChangeLog::Priority_Normal;
                        $aDLog->create_time_utc = time();
                        $aDLog->create_user_id = Yii::app()->session['user']->id;
                        $content = "";
                        $content .= "UpDate AD Group for Company id: " . Yii::app()->session['user']->company->id . ", name: " . Yii::app()->session['user']->company->name . "<br />";
                        $content .= "AD Group Name: {$adGroup->name}.<br />";
                        $content .= "AD Group Status Changed From: " . ADGroup::getStatusText($oldStatus) . ", To: " . ADGroup::getStatusText($status) . "<br />";
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
                            left join lt_google_adwords_ad_group gaag on gaag.id = t.ad_group_id
                            left join lt_ad_group ag on ag.id = gaag.lt_ad_group_id
                            where ag.company_id = :company_id and ag.id = :group_id";
        $command = Yii::app()->db->createCommand($placementSQL);
        $command->bindValue(":company_id", Yii::app()->session['user']->company_id, PDO::PARAM_INT);
        $command->bindValue(":group_id", $id, PDO::PARAM_INT);
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

        $performances = array();

        $this->render("geoGraphic", array(
            'model'=>$model,
            'performances'=>$performances,
        ));
    }

    public function actionDestinationURLReport($id)
    {
        $this->layout='//layouts/column2';
        $model = $this->loadModel($id);

        $performanceSQL = "SELECT t.click_type, t.criteria_parameters, t.device, t.effective_destination_url,
                            t.clicks, t.impressions as impr, t.charge_amount as cost
                            FROM lt_ad_google_adwords_report_destination_url t
                            left join lt_google_adwords_ad_group gaag on gaag.id = t.ad_group_id
                            left join lt_ad_group ag on ag.id = gaag.lt_ad_group_id
                            where ag.company_id = :company_id and ag.id = :group_id";
        $command = Yii::app()->db->createCommand($performanceSQL);
        $command->bindValue(":company_id", Yii::app()->session['user']->company_id, PDO::PARAM_INT);
        $command->bindValue(":group_id", $id, PDO::PARAM_INT);
        $performances = $command->queryAll();

        $this->render("destinationURLReport", array(
            'model'=>$model,
            'performances'=>$performances,
        ));
    }

    public function actionGetPerformanceStatistic($adgroupid=null, $advertisementid=null, $start='', $end='')
    {
        if(!$end) $end = date("Y-m-d");
        if(!$start) $start = date("Y-m-d", strtotime(date("Y-m-d")) - 60 * 60 * 24 * 14);

        if(isset($_POST['advertisementid'])) $advertisementid = $_POST['advertisementid'];
        if(isset($_POST['adgroupid'])) $adgroupid = $_POST['adgroupid'];
        if(isset($_POST['start'])) $start = $_POST['start'];
        if(isset($_POST['end'])) $end = $_POST['end'];

        if(!isset($adgroupid))
        {
            $result = array('status'=>'fail', 'data'=>"Invalid AD Group!");
            echo json_encode($result);
            exit();
        }

        $performanceSQL = "SELECT ag.id, ag.name, ag.default_bid, ag.status, sum(t.clicks) as clicks, sum(t.impressions) as impr, sum(t.charge_amount) as cost
                            FROM lt_ad_google_adwords_report_ad_group t
                            left join lt_google_adwords_ad_group aag on aag.id = t.ad_group_id
                            left join lt_ad_group ag on aag.lt_ad_group_id = ag.id
                            where ag.company_id = :company_id and ag.id = :id and t.date >= :startdate and t.date <= :enddate ";
        $command = Yii::app()->db->createCommand($performanceSQL);
        $command->bindValue(":company_id", Yii::app()->session['user']->company_id, PDO::PARAM_INT);
        $command->bindValue(":id", $adgroupid, PDO::PARAM_INT);
        $command->bindValue(":startdate", $start, PDO::PARAM_STR);
        $command->bindValue(":enddate", $end, PDO::PARAM_STR);
        $result = $command->queryRow();
        $performance = array('clicks'=>null, 'impr'=>null, 'cost'=>null);
        if(!empty($result)) $performance = array('clicks'=>$result['clicks'], 'impr'=>$result['impr'], 'cost'=>$result['cost']);

        //get ad performance if have
        $adPerformanceSQL = "SELECT t.id, t.name, aav.width, aav.height, aav.code, aav.type,
                                sum(gara.clicks) as clicks, sum(gara.impressions) as impr, sum(gara.charge_amount) as cost
                                FROM lt_ad_advertise t
                                left join lt_ad_advertise_variation aav on aav.ad_advertise_id = t.id
                                left join lt_google_adwords_ad gaa on gaa.lt_ad_advertise_variation_id = aav.id
                                left join lt_ad_google_adwords_report_ad gara on gara.id = gaa.id and gara.date >= :startdate and gara.date <= :enddate
                                where t.company_id = :company_id and t.ad_group_id = :id
                                group by t.id
                                order by t.id desc";
        $command = Yii::app()->db->createCommand($adPerformanceSQL);
        $command->bindValue(":company_id", Yii::app()->session['user']->company_id, PDO::PARAM_INT);
        $command->bindValue(":id", $adgroupid, PDO::PARAM_INT);
        $command->bindValue(":startdate", $start, PDO::PARAM_STR);
        $command->bindValue(":enddate", $end, PDO::PARAM_STR);
        $adPerformance = $command->queryAll();

        $performanceList = $this->getADGroupPerformance($adgroupid, $advertisementid, $start, $end);

        $result = array('status'=>'success', 'all'=>$performance, 'ad'=>$adPerformance, 'chart'=>$performanceList);
        echo json_encode($result);
    }

    public function actionGetIndexPerformance($adcampaignid=null, $start='', $end='')
    {
        if(!$end) $end = date("Y-m-d");
        if(!$start) $start = date("Y-m-d", strtotime(date("Y-m-d")) - 60 * 60 * 24 * 14);

        if(isset($_POST['start'])) $start = $_POST['start'];
        if(isset($_POST['end'])) $end = $_POST['end'];
        if(isset($_POST['adcampaignid'])) $adcampaignid = (int)$_POST['adcampaignid'];

        $whereSQL = "";
        if(isset($adcampaignid) && $adcampaignid)
        {
            $whereSQL .= " and t.campaign_id = :campaign_id ";
        }
        $performanceSQL = "select t.id, t.name, t.default_bid, t.status, sum(garag.clicks) as clicks, sum(garag.impressions) as impr, sum(garag.charge_amount) as cost
                            from lt_ad_group t
                            left join lt_google_adwords_ad_group gaag on gaag.lt_ad_group_id = t.id
                            left join lt_ad_google_adwords_report_ad_group garag on garag.ad_group_id = gaag.id and garag.date >= :startdate and garag.date <= :enddate
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
            $command->bindValue(":campaign_id", $adcampaignid, PDO::PARAM_INT);
        }
        $adGroupPerformance = $command->queryAll();
        if(!isset($adGroupPerformance) || empty($adGroupPerformance)) $adGroupPerformance = array();

        $result = array('status'=>'success', 'all'=>$adGroupPerformance);
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
        $model=ADGroup::model()->findByPk($id, "company_id=:company_id" ,array(':company_id' => Yii::app()->session['user']->company_id));
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
            'postOnly + delete, updateGroupStatus, getPerformanceData, getPerformanceStatistic, getIndexPerformance', // we only allow deletion via POST request
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
                'actions'=>array('index', 'create', 'update', 'view', 'getPerformanceData', 'updateGroupStatus', 'automaticPlacementReport', 'geoGraphicReport', 'destinationURLReport', 'getPerformanceStatistic', 'getIndexPerformance'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
}