<?php

class AdcampaignController extends Controller
{
	public function actionIndex()
	{
        $dataProvider=new CActiveDataProvider(
            'ADCampaign',
            array
            (
                'sort'=>array(
                    'attributes'=>array(
                        'id', 'start_datetime', 'end_datetime', 'budget', 'status'
                    ),
                ),
                'pagination'=>array(
                    'pageSize'=>45,
                ),
            )
        );

		$this->render('index', array(
            "dataProvider"=>$dataProvider,
        ));
	}

    public function actionView($id)
    {
        $model = $this->loadModel($id);
        //$this->layout='//layouts/column2';

        $this->render('view', array(
            "model"=>$model,
        ));
        //$this->layout='';
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $this->layout='//layouts/column2';

        $this->render('update', array(
            "model"=>$model,
        ));
        $this->layout='';
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
                            where t.id = :campaignid
                            $whereSQL $groupBySQL
                            order by garag.date desc";
        $command = Yii::app()->db->createCommand($performanceSQL);
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

    public function actionAutomaticPlacementReport($id)
    {
        $model = $this->loadModel($id);

        $placementSQL = "SELECT t.domain, t.clicks, t.impressions as impr, t.charge_amount as cost
                            FROM lt_ad_google_adwords_report_automatic_placements t
                            left join lt_google_adwords_campaign gaag on gaag.id = t.campaign_id
                            left join lt_ad_campaign ag on ag.id = gaag.lt_ad_campaign_id
                            where ag.id = :campaign_id";
        $command = Yii::app()->db->createCommand($placementSQL);
        $command->bindValue(":campaign_id", $id, PDO::PARAM_INT);
        $placements = $command->queryAll();

        $this->render("automaticPlacement", array(
            'model'=>$model,
            'placements'=>$placements,
        ));
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
        $model=ADCampaign::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested AD Campaign does not exist.');
        return $model;
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