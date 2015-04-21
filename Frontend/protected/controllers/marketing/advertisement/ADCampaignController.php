<?php

class ADCampaignController extends Controller
{
    public $layout='';

	public function actionIndex()
	{
        $this->layout='//layouts/column2';

        $campaignPerformanceSQL = "SELECT t.id, t.name, t.budget, t.status, sum(garc.clicks) as clicks, sum(garc.impressions) as impr, sum(garc.cost) / ".Yii::app()->params['google']['AdWords']['reportCurrencyUnit']." as cost
                                    FROM lt_ad_campaign t
                                    left join lt_google_adwords_campaign gac on gac.lt_ad_campaign_id = t.id
                                    left join lt_google_adwords_report_campaign garc on garc.campaign_id = gac.id
                                    where t.company_id = :company_id
                                    group by t.id
                                    order by t.id desc";
        $command = Yii::app()->db->createCommand($campaignPerformanceSQL);
        $command->bindValue(":company_id", Yii::app()->session['user']->company_id, PDO::PARAM_INT);
        $campaignPerformance = $command->queryAll();

		$this->render('index',array(
            'campaignPerformance'=>$campaignPerformance,
        ));
	}

    public function actionCreate()
    {
        $model = new ADCampaign();

        if(isset($_POST['campaign']))
        {
            $model->name = (string)$_POST['campaign']['name'];
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
                for($i=0;$i<count($_POST['schedule_option_value_day']);$i++)
                {
                    if(!isset($_POST['schedule_option_value_day'][$i]) || !isset($_POST['schedule_option_value_from_hour'][$i]) || !isset($_POST['schedule_option_value_from_minute'][$i]) || !isset($_POST['schedule_option_value_to_hour'][$i]) || !isset($_POST['schedule_option_value_to_minute'][$i])) continue;
                    $criteria['schedule'][] = array(
                        'day'=>$_POST['schedule_option_value_day'][$i],
                        'from_hour'=>$_POST['schedule_option_value_from_hour'][$i],
                        'from_minute'=>$_POST['schedule_option_value_from_minute'][$i],
                        'to_hour'=>$_POST['schedule_option_value_to_hour'][$i],
                        'to_minute'=>$_POST['schedule_option_value_to_minute'][$i],
                    );
                }
            }
            $model->criteria = json_encode($criteria);
            if($model->save())
            {
                $aDLog = new ADChangeLog();
                $aDLog->company_id = Yii::app()->session['user']->company_id;
                $aDLog->object_type = "ADCampaign";
                $aDLog->object_id = $model->id;
                $aDLog->title = "Add New AD Campaign for Company: ".Yii::app()->session['user']->company->name;
                $aDLog->action = ADChangeLog::Action_AddNew;
                $aDLog->status = ADChangeLog::Status_Pending;
                $aDLog->priority = ADChangeLog::Priority_Normal;
                $aDLog->create_time_utc = time();
                $aDLog->create_user_id = Yii::app()->session['user']->id;
                $content = "";
                $content .= "Add New AD Campaign for Company id: ".Yii::app()->session['user']->company->id.", name: ".Yii::app()->session['user']->company->name."<br />";
                $content .= "Campaign Name: {$model->name}.<br />";
                $content .= "Campaign Budget: ".sprintf("$%1\$.2f", $model->budget)."<br />";
                $content .= "Campaign Start Date: ".date('Y-m-d', $model->start_datetime)."<br />";
                if(isset($model->end_datetime)) $content .= "Campaign End Date: ".date('Y-m-d', $model->end_datetime)."<br />";
                $content .= "Campaign Language: ".($criteria['language'] ? $criteria['language'] : "All Languages")."<br />";
                $content .= "Campaign Location: ".($criteria['location'] ? $criteria['location'] : "All Countries and Regions")."<br />";
                if(isset($criteria['schedule']) && !empty($criteria['schedule']))
                {
                    $content .= "Campaign Time-zone: {$criteria['timezone']}<br />";
                    $content .= "Campaign Schedule:<br/>";
                    foreach($criteria['schedule'] as $schedule)
                        $content .= "Day: {$schedule['day']}, From: {$schedule['from_hour']}:{$schedule['from_minute']}, To: {$schedule['to_hour']}:{$schedule['to_minute']}<br />";
                }
                $aDLog->content = $content;
                $aDLog->save();

                $this->redirect($this->createAbsoluteUrl("marketing/advertisement/adgroup/create", array('adcampaignid'=>$model->id, 'lead' => true,)));
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

        $performanceSQL = "SELECT sum(t.clicks) as clicks, sum(t.impressions) as impr, sum(t.cost) / ".Yii::app()->params['google']['AdWords']['reportCurrencyUnit']." as cost
                            FROM lt_google_adwords_report_campaign t
                            left join lt_google_adwords_campaign gac on gac.id = t.campaign_id
                            left join lt_ad_campaign adc on adc.id = gac.lt_ad_campaign_id
                            where adc.id=:id";
        $command = Yii::app()->db->createCommand($performanceSQL);
        $command->bindValue(":id", $id, PDO::PARAM_INT);
        $result = $command->queryRow();
        $performance = array('clicks'=>null, 'impr'=>null, 'cost'=>null);
        if(!empty($result)) $performance = array('clicks'=>$result['clicks'], 'impr'=>$result['impr'], 'cost'=>$result['cost']);

        $adGroupPerformanceSQL = "SELECT t.id, t.name, t.default_bid, t.status, sum(garc.clicks) as clicks, sum(garc.impressions) as impr, sum(garc.cost / ".Yii::app()->params['google']['AdWords']['reportCurrencyUnit'].") as cost
                                    FROM lt_ad_group t
                                    left join lt_google_adwords_ad_group gac on gac.lt_ad_group_id = t.id
                                    left join lt_google_adwords_report_ad_group garc on garc.ad_group_id = gac.id
                                    where t.campaign_id = :campaign_id
                                    group by t.id";
        $command = Yii::app()->db->createCommand($adGroupPerformanceSQL);
        $command->bindValue(":campaign_id", $id, PDO::PARAM_INT);
        $result = $command->queryAll();
        $adGroupPerformance = $result;

        $this->render('view',array(
            'model'=>$model,
            'performance'=>$performance,
            'adGroupPerformance'=>$adGroupPerformance,
        ));
    }

    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);

        if(isset($_POST['campaign']))
        {
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
                for($i=0;$i<count($_POST['schedule_option_value_day']);$i++)
                {
                    if(!isset($_POST['schedule_option_value_day'][$i]) || !isset($_POST['schedule_option_value_from_hour'][$i]) || !isset($_POST['schedule_option_value_from_minute'][$i]) || !isset($_POST['schedule_option_value_to_hour'][$i]) || !isset($_POST['schedule_option_value_to_minute'][$i])) continue;
                    $criteria['schedule'][] = array(
                        'day'=>$_POST['schedule_option_value_day'][$i],
                        'from_hour'=>$_POST['schedule_option_value_from_hour'][$i],
                        'from_minute'=>$_POST['schedule_option_value_from_minute'][$i],
                        'to_hour'=>$_POST['schedule_option_value_to_hour'][$i],
                        'to_minute'=>$_POST['schedule_option_value_to_minute'][$i],
                    );
                }
            }
            $model->criteria = json_encode($criteria);
            if($model->save())
            {
                $aDLog = new ADChangeLog();
                $aDLog->company_id = Yii::app()->session['user']->company_id;
                $aDLog->object_type = "ADCampaign";
                $aDLog->object_id = $model->id;
                $aDLog->title = "UpDate AD Campaign for Company: ".Yii::app()->session['user']->company->name.", Campaign Name: ".$model->name;
                $aDLog->action = ADChangeLog::Action_Update;
                $aDLog->status = ADChangeLog::Status_Pending;
                $aDLog->priority = ADChangeLog::Priority_Normal;
                $aDLog->create_time_utc = time();
                $aDLog->create_user_id = Yii::app()->session['user']->id;
                $content = "";
                $content .= "UpDate AD Campaign for Company id: ".Yii::app()->session['user']->company->id.", name: ".Yii::app()->session['user']->company->name."<br />";
                $content .= "Campaign Name: {$model->name}.<br />";
                if($oldModel->budget != $model->budget)
                    $content .= "Campaign Budget Changed From: ".sprintf("$%1\$.2f", $oldModel->budget).", To: ".sprintf("$%1\$.2f", $model->budget)."<br />";
                if($oldModel->start_datetime != $model->start_datetime)
                    $content .= "Campaign Start Date Changed From: ".date('Y-m-d', $oldModel->start_datetime).", To: ".date('Y-m-d', $model->start_datetime)."<br />";
                if($oldModel->end_datetime != $model->end_datetime)
                    $content .= "Campaign End Date Changed From: ".(isset($oldModel->end_datetime) ? date('Y-m-d', $oldModel->end_datetime) : "NULL").", TO: ".(isset($model->end_datetime) ? date('Y-m-d', $model->end_datetime) : "NULL")."<br />";
                $oldCriteria = json_decode($oldModel->criteria);
                if((string)$oldCriteria->language != $criteria['language'])
                    $content .= "Campaign Language Changed From: ".((string)$oldCriteria->language ? (string)$oldCriteria->language : "All Languages").", To: ".($criteria['language'] ? $criteria['language'] : "All Languages")."<br />";
                if((string)$oldCriteria->location != $criteria['location'])
                    $content .= "Campaign Location Changed From: ".((string)$oldCriteria->location ? (string)$oldCriteria->location : "All Countries and Regions").", To: ".($criteria['location'] ? $criteria['location'] : "All Countries and Regions")."<br />";
                if(isset($criteria['schedule']) && !empty($criteria['schedule']))
                {
                    $content .= "Campaign Time-zone Changed To: {$criteria['timezone']}<br />";
                    $content .= "Campaign Schedule Changed To:<br />";
                    foreach($criteria['schedule'] as $schedule)
                        $content .= "Day: {$schedule['day']}, From: {$schedule['from_hour']}:{$schedule['from_minute']}, To: {$schedule['to_hour']}:{$schedule['to_minute']}<br />";
                }
                $aDLog->content = $content;
                $aDLog->save();

                $this->redirect($this->createAbsoluteUrl("marketing/advertisement/adcampaign/view", array('id' => $model->id)));
            }
        }

        $this->render('update',array(
            'model'=>$model,
        ));
    }

    protected function getCampaignPerformance($groupBy = ADCampaign::GroupBy_Day, $adgroupid=null)
    {
        $performanceList = array();

        $whereSQL = "";
        $groupBySQL = "";
        switch($groupBy)
        {
            case ADCampaign::GroupBy_Day:
                $period = 21;
                $groupBySQL = "group by garc.date
                            order by garc.date desc
                            limit 0, $period";
                $today = strtotime(date("Y-m-d", time()));
                for($i=$period;$i>0;$i--)
                {
                    $performanceList[date('Y-m-d', strtotime("-$i day"))] = array();
                }
                $performanceList[date('Y-m-d', time())] = array();
                break;
            case ADCampaign::GroupBy_Week:
                $period = 8;
                $groupBySQL = "group by garc.date
                            order by garc.date desc
                            limit 0, $period";
                $today = date('Y-m-d', strtotime("last Monday"));
                for($i=$period;$i>0;$i--)
                {
                    $performanceList[date('Y-m-d', strtotime($today) - ($i - 2) * 60 * 60 * 24 * 7)] = array();
                }
                break;
            case ADCampaign::GroupBy_Month:
                $period = 6;
                $groupBySQL = "group by garc.date
                            order by garc.date desc
                            limit 0, $period";
                for($i=$period-1;$i>0;$i--)
                {
                    $performanceList[date('Y-m-01', strtotime("-$i month"))] = array();
                }
                $performanceList[date('Y-m-01', time())] = array();
                break;
            default:
                return false;
                break;
        }
        if(isset($adgroupid) && $adgroupid)
        {
            $whereSQL .= " and ac.id = :group_id ";
        }
        $performanceSQL = "select sum(garc.clicks) as clicks, sum(garc.impressions) as impr, sum(garc.cost) / ".Yii::app()->params['google']['AdWords']['reportCurrencyUnit']." as cost, garc.date, garc.month, garc.year, garc.date, garc.week, garc.month_of_year, gac.id
                            from lt_google_adwords_report_ad_group garc
                            left join lt_google_adwords_ad_group gac on gac.id = garc.ad_group_id
                            left join lt_ad_group ac on ac.id = gac.lt_ad_group_id
                            where ac.company_id = :company_id $whereSQL $groupBySQL";
        $command = Yii::app()->db->createCommand($performanceSQL);
        $command->bindValue(":company_id", Yii::app()->session['user']->company_id, PDO::PARAM_INT);
        if(isset($adgroupid) && $adgroupid)
        {
            $command->bindValue(":group_id", $adgroupid, PDO::PARAM_INT);
        }
        $performances = $command->queryAll();

        if(isset($performances) && !empty($performances))
        {
            foreach($performances as $performance)
            {
                $key = '';
                switch($groupBy)
                {
                    case ADCampaign::GroupBy_Day:
                        $key = $performance['date'];
                        break;
                    case ADCampaign::GroupBy_Week:
                        $key = $performance['week'];
                        break;
                    case ADCampaign::GroupBy_Month:
                        $key = $performance['month'];
                        break;
                }
                if(isset($performanceList[$key])) $performanceList[$key] = array(
                    'clicks'=> $performance['clicks'],
                    'impr'=> $performance['impr'],
                    'ctr'=> isset($performance['impr']) && $performance['impr'] ? sprintf("%1\$.2f%", $performance['clicks'] / $performance['impr'] * 100) : "0",
                    'cpc'=> isset($performance['clicks']) && $performance['clicks'] ? sprintf("%1\$.2f", $performance['cost'] / $performance['clicks']) : "0",
                    'cost'=> sprintf("%1\$.2f", $performance['cost']),
                );
            }
        }
        foreach($performanceList as $key => $performance)
        {
            if(empty($performance))
                $performanceList[$key] = array(
                    'clicks'=> "0",
                    'impr'=> "0",
                    'ctr'=> "0",
                    'cpc'=> "0",
                    'cost'=> "0",
                );
        }

        return $performanceList;
    }

    public function actionGetPerformanceData()
    {
        $groupBy = ADCampaign::GroupBy_Day;
        $adgroupid = '';

        if(isset($_POST['groupBy'])) $groupBy = $_POST['groupBy'];
        if(isset($_POST['adgroupid'])) $adgroupid = $_POST['adgroupid'];

        $performanceList = $this->getCampaignPerformance($groupBy, $adgroupid);

        echo json_encode($performanceList);
        exit();
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
            'postOnly + delete, getPerformanceData', // we only allow deletion via POST request
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
                'actions'=>array('index', 'create', 'view', 'update', 'getPerformanceData'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
}