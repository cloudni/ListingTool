<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-12-2
 * Time: 2:54pm
 */

Yii::import('application.vendor.*');
require_once 'eBay/eBayTradingAPI.php';
require_once 'LogFile.php';

class schedulejobCommand extends CConsoleCommand
{
    public function run($args)
    {
        $transaction = null;
        try
        {
            $transaction= Yii::app()->db->beginTransaction();
            $criteria=new CDbCriteria;
            $criteria->condition = "last_execute_status!=:last_execute_status and next_execute_time_utc<=:next_execute_time_utc and is_active=:is_active";
            $criteria->params=array(
                ':last_execute_status'=>ScheduleJob::LAST_EXECUTE_STATUS_EXECUTE,
                ':next_execute_time_utc'=>time(),
                ':is_active'=>ScheduleJob::ACTIVE_YES,
            );
            $criteria->order="next_execute_time_utc asc";
            $scheduleJob = ScheduleJob::model()->find($criteria);

            if(empty($scheduleJob))
            {
                echo "no schedule job, exit.".date("Y-m-d h:i:sa")."\n";
                return;
            }
            echo "schedule job detected, platform: ".$scheduleJob->getPlatformText($scheduleJob->platform).", action: ".$scheduleJob->getActionText($scheduleJob->action).' '.date("Y-m-d h:i:sa")."\n";

            $scheduleJob->last_execute_status = ScheduleJob::LAST_EXECUTE_STATUS_EXECUTE;
            $scheduleJob->last_execute_time_utc = time();
            $scheduleJob->update();
            $transaction->commit();
        }
        catch(Exception $ex)
        {
            if(isset($transaction)) $transaction->rollback();
            echo "get schedule job error, code: {$ex->getCode()}, message: {$ex->getMessage()}.\n";
            return false;
        }

        $result = false;
        switch($scheduleJob->platform)
        {
            case Store::PLATFORM_EBAY:
                $result = $this->processeBayScheduleJob($scheduleJob);
                break;
            case Store::PLATFORM_AMAZON:
                break;
            default:
                echo "Unknow platform: {$scheduleJob->platform}! exit.\n";
                break;
        }

        $updateJob = false;
        while(!$updateJob)
        {
            $transaction = null;
            try
            {
                $transaction= Yii::app()->db->beginTransaction();
                $scheduleJob->last_execute_status = !$result ? ScheduleJob::LAST_EXECUTE_STATUS_ERROR : ScheduleJob::LAST_EXECUTE_STATUS_SUCCESS;
                $scheduleJob->last_finish_time_utc = time();
                if($scheduleJob->type == ScheduleJob::TYPE_ONCE)
                    $scheduleJob->is_active = ScheduleJob::ACTIVE_NO;
                else
                    $scheduleJob->next_execute_time_utc = $scheduleJob->getNextExecuteTime();
                $scheduleJob->update();

                $transaction->commit();
                return true;
            }
            catch(Exception $ex)
            {
                if(isset($transaction)) $transaction->rollback();
                echo "fail to update schedule job status to end, code: {$ex->getCode()}, message: {$ex->getMessage()}.\n";
            }
        }
    }

    protected function processeBayScheduleJob($scheduleJob)
    {
        if(empty($scheduleJob)) return false;

        switch($scheduleJob->action)
        {
            case ScheduleJob::ACTION_EBAYGETSELLERLIST:
                return $this->eBayGetSellerList($scheduleJob);
                break;
            case ScheduleJob::ACTION_EBAYGETCATEGORIES:
                return $this->eBayGetCategories($scheduleJob);
                break;
            case ScheduleJob::ACTION_EBAYGETEBAYDETAILS:
                return $this->eBayGeteBayDetails($scheduleJob);
                break;
            case ScheduleJob::ACTION_EBAYGETCATEGORYFEATURES:
                return $this->eBayGetCategoryFeature($scheduleJob);
                break;
            case ScheduleJob::ACTION_EBAYGETSELLERDASHBOARD:
                return $this->eBayGetSellerDashboard($scheduleJob);
                break;
            case ScheduleJob::ACTION_EBAYGETUSER:
                return $this->eBayGetUser($scheduleJob);
                break;
            default:
                echo "Unknow action: {$scheduleJob->action}. Exit!\n";
                return false;
                break;
        }
    }

    protected function eBayGetSellerList($scheduleJob)
    {
        $logFile = new LogFile(Yii::app()->params['ebay']['logPath'], 'GetSellerList.'.date("Ymd.his", time()).'.log');
        $logFile->saveOutputToFile();

        echo "start schedule job, platform: ".$scheduleJob->getPlatformText($scheduleJob->platform).", action: ".$scheduleJob->getActionText($scheduleJob->action)."\n";

        if(intval($scheduleJob->params) <=0)
        {
            echo "Input parameter(s) error for eBay GetSellerList, exit!\n";
            return false;
        }

        $store = Store::model()->findByPk((int)$scheduleJob->params);

        eBayTradingAPI::GetSellerList($store->id);

        echo "end schedule job, platform: ".$scheduleJob->getPlatformText($scheduleJob->platform).", action: ".$scheduleJob->getActionText($scheduleJob->action)."\n\n";
        return true;
    }

    protected function eBayGetCategories($scheduleJob)
    {
        $logFile = new LogFile(Yii::app()->params['ebay']['logPath'], 'GetCategories.'.date("Ymd.his", time()).'.log');
        $logFile->saveOutputToFile();

        echo "start schedule job, platform: ".$scheduleJob->getPlatformText($scheduleJob->platform).", action: ".$scheduleJob->getActionText($scheduleJob->action)."\n";

        $sites = eBaySiteName::geteBaySiteNameOptions();

        if(empty($sites))
        {
            echo "fail to get eBay sites information.\n";
            return false;
        }

        foreach($sites as $site)
        {
            try
            {
                $params=array('CategorySiteID'=>$site, 'CategoryParent'=>'', 'LevelLimit'=>4, 'ViewAllNodes'=>true, 'DetailLevel'=>eBayDetailLevelCodeType::ReturnAll);
                eBayTradingAPI::GetCategories($params);
            }
            catch(Exception $ex)
            {
                echo "fail to get categories for site: $site, code: {$ex->getCode()}, message: {$ex->getMessage()}.\n";
                continue;
            }
        }

        echo "end schedule job, platform: ".$scheduleJob->getPlatformText($scheduleJob->platform).", action: ".$scheduleJob->getActionText($scheduleJob->action)."\n\n";
        return true;
    }

    protected function eBayGeteBayDetails($scheduleJob)
    {
        $logFile = new LogFile(Yii::app()->params['ebay']['logPath'], 'GeteBayDetails.'.date("Ymd.his", time()).'.log');
        $logFile->saveOutputToFile();

        echo "start schedule job, platform: ".$scheduleJob->getPlatformText($scheduleJob->platform).", action: ".$scheduleJob->getActionText($scheduleJob->action)."\n";

        $sites = eBaySiteName::geteBaySiteNameOptions();
        foreach($sites as $site)
        {
            try
            {
                eBayTradingAPI::GeteBayDetails($site, 3);
            }
            catch(Exception $ex)
            {
                echo "fail to get eBay details for site: $site, code: {$ex->getCode()}, message: {$ex->getMessage()}.\n";
                continue;
            }
        }

        echo "end schedule job, platform: ".$scheduleJob->getPlatformText($scheduleJob->platform).", action: ".$scheduleJob->getActionText($scheduleJob->action)."\n\n";
        return true;
    }

    protected function eBayGetCategoryFeature($scheduleJob)
    {
        $logFile = new LogFile(Yii::app()->params['ebay']['logPath'], 'GetCategoryFeature.'.date("Ymd.his", time()).'.log');
        $logFile->saveOutputToFile();

        echo "start schedule job, platform: ".$scheduleJob->getPlatformText($scheduleJob->platform).", action: ".$scheduleJob->getActionText($scheduleJob->action)."\n";

        $sites = eBaySiteName::geteBaySiteNameOptions();
        foreach($sites as $site)
        {
            try
            {
                eBayTradingAPI::GetCategoryFeatures($param=array('site_id'=>$site, 'CategoryID'=>'', 'ViewAllNodes'=>true, 'DetailLevel'=>eBayDetailLevelCodeType::ReturnAll, 'LevelLimit'=>4), 3);
            }
            catch(Exception $ex)
            {
                echo "fail to get eBay category feature for site: $site, code: {$ex->getCode()}, message: {$ex->getMessage()}.\n";
                continue;
            }
        }

        echo "end schedule job, platform: ".$scheduleJob->getPlatformText($scheduleJob->platform).", action: ".$scheduleJob->getActionText($scheduleJob->action)."\n\n";
        return true;
    }

    protected function eBayGetSellerDashboard($scheduleJob)
    {
        $logFile = new LogFile(Yii::app()->params['ebay']['logPath'], 'GetSellerDashboard.'.date("Ymd.his", time()).'.log');
        $logFile->saveOutputToFile();

        echo "start schedule job, platform: ".$scheduleJob->getPlatformText($scheduleJob->platform).", action: ".$scheduleJob->getActionText($scheduleJob->action)."\n";

        $stores = Store::model()->findAll("platform=:platform and is_active=:is_active", array(':platform'=>Store::PLATFORM_EBAY, ':is_active'=>Store::ACTIVE_YES));
        foreach($stores as $store)
        {
            try
            {
                eBayTradingAPI::GetSellerDashboard($store->id);
            }
            catch(Exception $ex)
            {
                echo "fail to get eBay seller dashboard for site: {$store->id}, code: {$ex->getCode()}, message: {$ex->getMessage()}.\n";
                continue;
            }
        }

        echo "end schedule job, platform: ".$scheduleJob->getPlatformText($scheduleJob->platform).", action: ".$scheduleJob->getActionText($scheduleJob->action)."\n\n";
        return true;
    }

    protected function eBayGetUser($scheduleJob)
    {
        $logFile = new LogFile(Yii::app()->params['ebay']['logPath'], 'GetUser.'.date("Ymd.his", time()).'.log');
        $logFile->saveOutputToFile();

        echo "start schedule job, platform: ".$scheduleJob->getPlatformText($scheduleJob->platform).", action: ".$scheduleJob->getActionText($scheduleJob->action)."\n";

        $stores = Store::model()->findAll("platform=:platform and is_active=:is_active", array(':platform'=>Store::PLATFORM_EBAY, ':is_active'=>Store::ACTIVE_YES));
        foreach($stores as $store)
        {
            try
            {
                eBayTradingAPI::GetUser($store->id);
            }
            catch(Exception $ex)
            {
                echo "fail to get eBay User for site: {$store->id}, code: {$ex->getCode()}, message: {$ex->getMessage()}.\n";
                continue;
            }
        }

        echo "end schedule job, platform: ".$scheduleJob->getPlatformText($scheduleJob->platform).", action: ".$scheduleJob->getActionText($scheduleJob->action)."\n\n";
        return true;
    }
}
