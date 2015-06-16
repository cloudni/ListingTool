<?php

class HomeController extends Controller
{
	public function actionIndex()
	{
        $company = null;
        if(!empty($_POST['user']))
        {
            $user = User::model()->find("username=:username", array(':username'=>$_POST['user']));
            if(!empty($user)) $company = $user->company;
        }

		$this->render('index',
            array(
                'company'=>$company,
            ));
	}

    public function actionGetPerformanceStatistic($start='', $end='')
    {
        if(!$end) $end = date("Y-m-d");
        if(!$start) $start = date("Y-m-d", strtotime(date("Y-m-d")) - 60 * 60 * 24 * 14);
        $company_id = 1;

        if(isset($_POST['start'])) $start = $_POST['start'];
        if(isset($_POST['end'])) $end = $_POST['end'];
        if(isset($_POST['company_id'])) $company_id = $_POST['company_id'];

        if(!$company_id)
        {
            $result = array('status'=>'error');
            echo json_encode($result);
            exit();
        }

        $performanceSQL = "select sum(gara.clicks) as clicks, sum(gara.impressions) as impr, sum(gara.charge_amount) as cost
                            from lt_ad_campaign t
                            left join lt_google_adwords_campaign gac on gac.lt_ad_campaign_id = t.id
                            left join lt_ad_google_adwords_report_campaign gara on gara.campaign_id = gac.id and gara.date >= :startdate and gara.date <= :enddate
                            where t.company_id = :company_id; ";
        $command = Yii::app()->db->createCommand($performanceSQL);
        $command->bindValue(":company_id", $company_id, PDO::PARAM_INT);
        $command->bindValue(":startdate", $start, PDO::PARAM_STR);
        $command->bindValue(":enddate", $end, PDO::PARAM_STR);
        $result = $command->queryRow();
        $performance = array('clicks'=>null, 'impr'=>null, 'cost'=>null);
        if(!empty($result)) $performance = array('clicks'=>$result['clicks'], 'impr'=>$result['impr'], 'cost'=>$result['cost']);

        $performanceSQL = "select t.id, t.name, t.budget, t.status, sum(gara.clicks) as clicks, sum(gara.impressions) as impr, sum(gara.charge_amount) as cost
                            from lt_ad_campaign t
                            left join lt_google_adwords_campaign gac on gac.lt_ad_campaign_id = t.id
                            left join lt_ad_google_adwords_report_campaign gara on gara.campaign_id = gac.id and gara.date >= :startdate and gara.date <= :enddate
                            where t.company_id = :company_id
                            group by t.id
                            order by t.id desc; ";
        $command = Yii::app()->db->createCommand($performanceSQL);
        $command->bindValue(":company_id", $company_id, PDO::PARAM_INT);
        $command->bindValue(":startdate", $start, PDO::PARAM_STR);
        $command->bindValue(":enddate", $end, PDO::PARAM_STR);
        $campaignPerformance = $command->queryAll();

        $performanceList = $this->getAccountPerformance($company_id, null, $start, $end);

        $result = array('status'=>'success', 'all'=>$performance, 'adcampaign'=>$campaignPerformance, 'chart'=>$performanceList);
        echo json_encode($result);
    }

    protected function getAccountPerformance($company_id, $adcampaignid=null, $start='', $end='')
    {
        $performanceList = array();

        $whereSQL = "";
        if(isset($adcampaignid) && $adcampaignid)
        {
            $whereSQL .= " and t.id = :campaign_id ";
        }
        $performanceSQL = "select sum(gara.clicks) as clicks, sum(gara.impressions) as impr, sum(gara.charge_amount) as cost,
                            gara.date, gara.month, gara.year, gara.week, gara.month_of_year
                            from lt_ad_campaign t
                            left join lt_google_adwords_campaign gac on gac.lt_ad_campaign_id = t.id
                            inner join lt_ad_google_adwords_report_campaign gara on gara.campaign_id = gac.id and gara.date >= :startdate and gara.date <= :enddate
                            where t.company_id = :company_id
                            group by gara.date";
        $command = Yii::app()->db->createCommand($performanceSQL);
        $command->bindValue(":company_id", $company_id, PDO::PARAM_INT);
        $command->bindValue(":startdate", $start, PDO::PARAM_STR);
        $command->bindValue(":enddate", $end, PDO::PARAM_STR);
        if(isset($adcampaignid) && $adcampaignid)
        {
            $command->bindValue(":campaign_id", $adcampaignid);
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

    public function actionGetPerformanceData($company_id=null, $adcampaignid=null, $start='', $end='')
    {
        if(!$end) $end = date("Y-m-d");
        if(!$start) $start = date("Y-m-d", strtotime(date("Y-m-d")) - 60 * 60 * 24 * 14);

        if(isset($_POST['start'])) $start = $_POST['start'];
        if(isset($_POST['end'])) $end = $_POST['end'];
        if(isset($_POST['adcampaignid'])) $adcampaignid = $_POST['adcampaignid'];
        if(isset($_POST['company_id'])) $company_id = $_POST['company_id'];

        $performanceList = $this->getAccountPerformance($company_id, $adcampaignid, $start, $end);

        echo json_encode($performanceList);
        exit();
    }

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
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
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('index','getPerformanceStatistic', 'getPerformanceData'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
}