<?php

class HomeController extends Controller
{
    public function actionIndex()
	{
        $performanceSQL = "SELECT sum(garc.clicks) as clicks, sum(garc.impressions) as impr, sum(garc.cost) / ".Yii::app()->params['google']['AdWords']['reportCurrencyUnit']." as cost
                            FROM lt_ad_campaign t
                            left join lt_google_adwords_campaign gac on gac.lt_ad_campaign_id = t.id
                            left join lt_google_adwords_report_campaign garc on garc.campaign_id = gac.id
                            where t.company_id = :company_id";
        $command = Yii::app()->db->createCommand($performanceSQL);
        $command->bindValue(":company_id", Yii::app()->session['user']->company_id, PDO::PARAM_INT);
        $performance = $command->queryRow();

        $campaignPerformanceSQL = "SELECT t.id, t.name, t.budget, t.status, sum(garc.clicks) as clicks, sum(garc.impressions) as impr, sum(garc.cost) / ".Yii::app()->params['google']['AdWords']['reportCurrencyUnit']." as cost
                                    FROM lt_ad_campaign t
                                    left join lt_google_adwords_campaign gac on gac.lt_ad_campaign_id = t.id
                                    left join lt_google_adwords_report_campaign garc on garc.campaign_id = gac.id
                                    where t.company_id = :company_id and t.status in (".ADCampaign::Status_Eligible.", ".ADCampaign::Stauts_Ended.")
                                    group by t.id
                                    order by t.id desc";
        $command = Yii::app()->db->createCommand($campaignPerformanceSQL);
        $command->bindValue(":company_id", Yii::app()->session['user']->company_id, PDO::PARAM_INT);
        $campaignPerformance = $command->queryAll();

        $adGroupPerformanceSQL = "SELECT ag.id, ag.name, ag.default_bid, ag.status, sum(t.clicks) as clicks, sum(t.impressions) as impr, sum(t.cost) / ".Yii::app()->params['google']['AdWords']['reportCurrencyUnit']." as cost
                                    FROM lt_ad_group ag
                                    left join lt_google_adwords_ad_group aag on aag.id = t.ad_group_id
                                    left join lt_google_adwords_report_ad_group t on aag.lt_ad_group_id = ag.id
                                    where ag.company_id = :company_id and ag.status = ".ADGroup::Status_Enabled."
                                    group by ag.id";
        $command = Yii::app()->db->createCommand($adGroupPerformanceSQL);
        $command->bindValue(":company_id", Yii::app()->session['user']->company_id, PDO::PARAM_INT);
        $adGroupPerformance = $command->queryAll();


		$this->render('index', array(
            'performance'=>$performance,
            'campaignPerformance'=>$campaignPerformance,
            'adGroupPerformance'=>$adGroupPerformance,
        ));
	}

    private function getAccountPerformance($groupBy = ADCampaign::GroupBy_Day, $adcampaignid=null)
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

        if(isset($adcampaignid) && $adcampaignid)
        {
            $whereSQL .= " and ac.id = :campaign_id ";
        }
        $performanceSQL = "select sum(garc.clicks) as clicks, sum(garc.impressions) as impr, sum(garc.cost) / ".Yii::app()->params['google']['AdWords']['reportCurrencyUnit']." as cost, garc.date, garc.month, garc.year, garc.date, garc.week, garc.month_of_year, gac.id
                            from lt_google_adwords_report_campaign garc
                            left join lt_google_adwords_campaign gac on gac.id = garc.campaign_id
                            left join lt_ad_campaign ac on ac.id = gac.lt_ad_campaign_id
                            where ac.company_id = :company_id $whereSQL $groupBySQL";
        $command = Yii::app()->db->createCommand($performanceSQL);
        $command->bindValue(":company_id", Yii::app()->session['user']->company_id, PDO::PARAM_INT);
        if(isset($adcampaignid) && $adcampaignid)
        {
            $command->bindValue(":campaign_id", $adcampaignid, PDO::PARAM_INT);
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
        $adcampaignid = '';

        if(isset($_POST['groupBy'])) $groupBy = $_POST['groupBy'];
        if(isset($_POST['adcampaignid'])) $adcampaignid = $_POST['adcampaignid'];

        $performanceList = $this->getAccountPerformance($groupBy, $adcampaignid);

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
                'actions'=>array('index', 'getPerformanceData'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
}