<?php

class AdController extends Controller
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

    public function actionGetPerformanceStatistic($advertisementid=null, $advariationid=null, $start='', $end='')
    {
        if(!$end) $end = date("Y-m-d");
        if(!$start) $start = date("Y-m-d", strtotime(date("Y-m-d")) - 60 * 60 * 24 * 14);

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

        $performanceSQL = "select sum(gara.clicks) as clicks, sum(gara.impressions) as impr, sum(gara.charge_amount) as cost
                            from lt_ad_advertise_variation t
                            left join lt_google_adwords_ad gaa on gaa.lt_ad_advertise_variation_id = t.id
                            left join lt_ad_google_adwords_report_ad gara on gara.id = gaa.id and gara.date >= :startdate and gara.date <= :enddate
                            where t.ad_advertise_id = :ad_advertise_id";
        $command = Yii::app()->db->createCommand($performanceSQL);
        $command->bindValue(":ad_advertise_id", $advertisementid, PDO::PARAM_INT);
        $command->bindValue(":startdate", $start, PDO::PARAM_STR);
        $command->bindValue(":enddate", $end, PDO::PARAM_STR);
        $result = $command->queryRow();
        $performance = array('clicks'=>null, 'impr'=>null, 'cost'=>null);
        if(!empty($result)) $performance = array('clicks'=>$result['clicks'], 'impr'=>$result['impr'], 'cost'=>$result['cost']);

        //get ad variation performance if have
        $adPerformanceSQL = "select t.id, t.code, t.width, t.height, t.status, sum(gara.clicks) as clicks, sum(gara.impressions) as impr, sum(gara.charge_amount) as cost
                                from lt_ad_advertise_variation t
                                left join lt_google_adwords_ad gaa on gaa.lt_ad_advertise_variation_id = t.id
                                left join lt_ad_google_adwords_report_ad gara on gara.id = gaa.id and gara.date >= :startdate and gara.date <= :enddate
                                where t.ad_advertise_id = :ad_advertise_id
                                group by t.id
                                order by t.id desc";
        $command = Yii::app()->db->createCommand($adPerformanceSQL);
        $command->bindValue(":ad_advertise_id", $advertisementid, PDO::PARAM_INT);
        $command->bindValue(":startdate", $start, PDO::PARAM_STR);
        $command->bindValue(":enddate", $end, PDO::PARAM_STR);
        $adVariationPerformance = $command->queryAll();

        $performanceList = $this->getAdvertisementPerformance($advertisementid, $advariationid, $start, $end);

        $result = array('status'=>'success', 'all'=>$performance, 'advariation'=>$adVariationPerformance, 'chart'=>$performanceList);
        echo json_encode($result);
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
        $performanceSQL = "select sum(gara.clicks) as clicks, sum(gara.impressions) as impr, sum(gara.charge_amount) as cost,
                            gara.date, gara.month, gara.year, gara.week, gara.month_of_year
                            from lt_ad_advertise_variation t
                            left join lt_google_adwords_ad gaa on gaa.lt_ad_advertise_variation_id = t.id
                            inner join lt_ad_google_adwords_report_ad gara on gara.id = gaa.id and gara.date >= :startdate and gara.date <= :enddate
                            where t.ad_advertise_id = :ad_advertise_id
                            $whereSQL
                            $groupBySQL;";
        $command = Yii::app()->db->createCommand($performanceSQL);
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

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Department the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=ADAdvertise::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested Advertisement does not exist.');
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