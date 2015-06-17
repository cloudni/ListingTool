<?php

class AdgroupController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

    public function actionView($id)
    {
        $model = $this->loadModel($id);

        $this->render('view', array(
            "model"=>$model,
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
                            where ag.id = :id and t.date >= :startdate and t.date <= :enddate ";
        $command = Yii::app()->db->createCommand($performanceSQL);
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
                                where t.ad_group_id = :id
                                group by t.id
                                order by t.id desc";
        $command = Yii::app()->db->createCommand($adPerformanceSQL);
        $command->bindValue(":id", $adgroupid, PDO::PARAM_INT);
        $command->bindValue(":startdate", $start, PDO::PARAM_STR);
        $command->bindValue(":enddate", $end, PDO::PARAM_STR);
        $adPerformance = $command->queryAll();

        $performanceList = $this->getADGroupPerformance($adgroupid, $advertisementid, $start, $end);

        $result = array('status'=>'success', 'all'=>$performance, 'ad'=>$adPerformance, 'chart'=>$performanceList);
        echo json_encode($result);
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
                            where t.ad_group_id = :ad_group_id
                            $whereSQL $groupBySQL";
        $command = Yii::app()->db->createCommand($performanceSQL);
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

    public function actionAutomaticPlacementReport($id)
    {
        $model = $this->loadModel($id);

        $placementSQL = "SELECT t.domain, t.clicks, t.impressions as impr, t.charge_amount as cost
                            FROM lt_ad_google_adwords_report_automatic_placements t
                            left join lt_google_adwords_ad_group gaag on gaag.id = t.ad_group_id
                            left join lt_ad_group ag on ag.id = gaag.lt_ad_group_id
                            where ag.id = :group_id";
        $command = Yii::app()->db->createCommand($placementSQL);
        $command->bindValue(":group_id", $id, PDO::PARAM_INT);
        $placements = $command->queryAll();

        $this->render("automaticPlacement", array(
            'model'=>$model,
            'placements'=>$placements,
        ));
    }

    public function actionGeoGraphicReport($id, $start='', $end='')
    {
        $model = $this->loadModel($id);

        if(!$end) $end = date("Y-m-d");
        if(!$start) $start = date("Y-m-d", strtotime(date("Y-m-d")) - 60 * 60 * 24 * 7);

        $sql="SELECT sum(garg.clicks) as clicks, sum(garg.impressions) as impressions, sum(garg.charge_amount) as cost, garg.location_type,
                garg.date, garg.month, garg.year,
                garg.city_criteria_id, garg.region_criteria_id, garg.country_criteria_id
                from lt_ad_group t
                left join lt_google_adwords_ad_group gac on gac.lt_ad_group_id = t.id
                left join lt_ad_google_adwords_report_geo garg on garg.ad_group_id = gac.id
                where t.id = $id and garg.date >= '$start' and garg.date <= '$end'
                group by garg.date, garg.city_criteria_id";
        $command = Yii::app()->db->createCommand($sql);
        $geos = $command->queryAll();

        $this->render("geoGraphicReport", array(
            'model'=>$model,
            'geos'=>$geos,
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
        $model=ADGroup::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested AD Group does not exist.');
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