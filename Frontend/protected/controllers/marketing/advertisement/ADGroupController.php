<?php

class ADGroupController extends Controller
{
    public $layout='';

	public function actionIndex($adcampaignid=null)
	{
        $this->layout='//layouts/column2';

        $campaign = null;
        if(isset($adcampaignid))
        {
            $campaign = ADCampaign::model()->findByPk($adcampaignid, "company_id=:company_id" ,array(':company_id' => Yii::app()->session['user']->company_id));
            if($campaign===null)
                throw new CHttpException(404,'The requested page does not exist.');
        }

        $whereSQL = "";
        if(isset($campaign))
        {
            $whereSQL .= " and ag.campaign_id = :campaign_id ";
        }
        $adGroupPerformanceSQL = "SELECT ag.id, ag.name, ag.default_bid, ag.status, sum(t.clicks) as clicks, sum(t.impressions) as impr, sum(t.cost) / ".Yii::app()->params['google']['AdWords']['reportCurrencyUnit']." as cost
                                    FROM lt_ad_group ag
                                    left join lt_google_adwords_ad_group aag on aag.lt_ad_group_id = ag.id
                                    left join lt_google_adwords_report_ad_group t on t.ad_group_id = aag.id
                                    where ag.company_id = :company_id
                                    $whereSQL
                                    group by ag.id";
        $command = Yii::app()->db->createCommand($adGroupPerformanceSQL);
        $command->bindValue(":company_id", Yii::app()->session['user']->company_id, PDO::PARAM_INT);
        if(isset($campaign))
        {
            $command->bindValue(":campaign_id", $campaign->id, PDO::PARAM_INT);
        }
        $adGroupPerformance = $command->queryAll();

        $campaignList = ADCampaign::model()->findAll("company_id=:company_id" ,array(':company_id' => Yii::app()->session['user']->company_id));

		$this->render('index', array(
            'adCampaign'=>(isset($campaign) ? $campaign : null),
            'adGroupPerformance'=>$adGroupPerformance,
            'campaignList'=>$campaignList,
        ));
	}

    public function actionCreate($campaignid=null, $lead=false)
    {
        $model = new ADGroup();

        if(isset($_POST['adgroup']))
        {
            $model->company_id = Yii::app()->session['user']->company_id;
            $model->name = $_POST['adgroup']['name'];
            $model->default_bid = $_POST['adgroup']['default_bid'];
            $model->campaign_id = $campaignid;
            $model->status = ADGroup::Status_Enabled;
            $model->is_delete = ADGroup::Delete_No;
            $criteria = array(
                'keywords'=>str_replace("\n", ADGroup::Criteria_Separator,$_POST['keywords']),
                'placements'=>str_replace("\n", ADGroup::Criteria_Separator,$_POST['placements']),
            );
            $model->criteria = json_encode($criteria);
            if($model->save())
            {
                $this->redirect($this->createAbsoluteUrl("marketing/advertisement/AD/create", array('adcampaignid'=>$model->id, 'adgroupid'=>$model->id, 'lead' => $lead,)));
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
            $model->default_bid = $_POST['adgroup']['default_bid'];
            $criteria = array(
                'keywords'=>str_replace("\n", ADGroup::Criteria_Separator,$_POST['keywords']),
                'placements'=>str_replace("\n", ADGroup::Criteria_Separator,$_POST['placements']),
            );
            $model->criteria = json_encode($criteria);
            if($model->save())
            {
                $this->redirect($this->createAbsoluteUrl("marketing/advertisement/ADGroup/view", array('id'=>$model->id)));
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

        $performanceSQL = "SELECT ag.id, ag.name, ag.default_bid, ag.status, sum(t.clicks) as clicks, sum(t.impressions) as impr, sum(t.cost) / ".Yii::app()->params['google']['AdWords']['reportCurrencyUnit']." as cost
                            FROM lt_google_adwords_report_ad_group t
                            left join lt_google_adwords_ad_group aag on aag.id = t.ad_group_id
                            left join lt_ad_group ag on aag.lt_ad_group_id = ag.id
                            where ag.id = :id";
        $command = Yii::app()->db->createCommand($performanceSQL);
        $command->bindValue(":id", $id, PDO::PARAM_INT);
        $result = $command->queryRow();
        $performance = array('clicks'=>null, 'impr'=>null, 'cost'=>null);
        if(!empty($result)) $performance = array('clicks'=>$result['clicks'], 'impr'=>$result['impr'], 'cost'=>$result['cost']);

        //get ad performance if have
        $adPerformanceSQL = "SELECT t.id, t.name, aav.width, aav.height, aav.code, aav.type,
                                sum(gara.clicks) as clicks, sum(gara.impressions) as impr, sum(gara.cost) / ".Yii::app()->params['google']['AdWords']['reportCurrencyUnit']." as cost
                                FROM lt_ad_advertise t
                                left join lt_ad_advertise_variation aav on aav.ad_advertise_id = t.id
                                left join lt_google_adwords_ad gaa on gaa.lt_ad_advertise_variation_id = aav.id
                                left join lt_google_adwords_report_ad gara on gara.ad_id = gaa.id
                                where t.ad_group_id = :id
                                group by t.id
                                order by t.id desc";
        $command = Yii::app()->db->createCommand($adPerformanceSQL);
        $command->bindValue(":id", $id, PDO::PARAM_INT);
        $adPerformance = $command->queryAll();

        $this->render('view',array(
            'model'=>$model,
            'performance'=>$performance,
            'adPerformance'=>$adPerformance,
        ));
    }

    protected function getADGroupPerformance($groupBy = ADGroup::GroupBy_Day, $advertisementid=null)
    {
        $performanceList = array();

        $whereSQL = "";
        $groupBySQL = "";
        switch($groupBy)
        {
            case ADGroup::GroupBy_Day:
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
            case ADGroup::GroupBy_Week:
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
            case ADGroup::GroupBy_Month:
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
        if(isset($advertisementid) && $advertisementid)
        {
            $whereSQL .= " and aa.id = :advertisement_id ";
        }
        $performanceSQL = "select sum(garc.clicks) as clicks, sum(garc.impressions) as impr, sum(garc.cost) / 1000000 as cost, garc.date, garc.month, garc.year, garc.date, garc.week, garc.month_of_year, gac.id, gac.lt_ad_advertise_variation_id
                                from lt_google_adwords_report_ad garc
                                left join lt_google_adwords_ad gac on gac.id = garc.ad_id
                                left join lt_ad_advertise_variation aav on aav.id = gac.lt_ad_advertise_variation_id
                                left join lt_ad_advertise aa on aa.id = aav.ad_advertise_id
                                where aa.company_id = :company_id $whereSQL $groupBySQL";
        $command = Yii::app()->db->createCommand($performanceSQL);
        $command->bindValue(":company_id", Yii::app()->session['user']->company_id, PDO::PARAM_INT);
        if(isset($advertisementid) && $advertisementid)
        {
            $command->bindValue(":advertisement_id", $advertisementid, PDO::PARAM_INT);
        }
        $performances = $command->queryAll();

        if(isset($performances) && !empty($performances))
        {
            foreach($performances as $performance)
            {
                $key = '';
                switch($groupBy)
                {
                    case ADGroup::GroupBy_Day:
                        $key = $performance['date'];
                        break;
                    case ADGroup::GroupBy_Week:
                        $key = $performance['week'];
                        break;
                    case ADGroup::GroupBy_Month:
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
        $advertisementid = '';

        if(isset($_POST['groupBy'])) $groupBy = $_POST['groupBy'];
        if(isset($_POST['advertisementId'])) $advertisementid = $_POST['advertisementId'];

        $performanceList = $this->getADGroupPerformance($groupBy, $advertisementid);

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
            $adGroup = ADGroup::model()->findByPk($id, "company_id=:company_id" ,array(':company_id' => Yii::app()->session['user']->company_id));
            if($adGroup!=null)
            {
                $adGroup->status = $status;
                if($adGroup->save()) $successList[] = $adGroup->id;
            }
        }

        $result = array('status'=>'success', 'data'=>$successList);
        echo json_encode($result);
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
            'postOnly + delete, getPerformanceData, updateGroupStatus', // we only allow deletion via POST request
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
                'actions'=>array('index', 'create', 'update', 'view', 'getPerformanceData', 'updateGroupStatus'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
}