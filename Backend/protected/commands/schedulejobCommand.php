<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-12-2
 * Time: 2:54pm
 */

Yii::import('application.vendor.*');
require_once 'eBay/eBayTradingAPI.php';
require_once 'eBay/eBayShoppingAPI.php';
require_once 'LogFile.php';
require_once 'Wish/WishAPI.php';

class schedulejobCommand extends CConsoleCommand
{
    private $maxThreads = 4 + 2;//7 means existing threads

    public function run($args)
    {
        $count = `ps -aef | grep 'yiic.php schedulejob run' | wc -l`;
        if($count >= $this->maxThreads) {
            echo "Currently there are ".($this->maxThreads - 2)." threads running, waiting for next time\n";
            exit();
        }
        echo "Current running threads: \n";
        echo `ps -aef | grep 'yiic.php schedulejob run' `;
        echo "count: $count\n";

        preg_match("/mysql:host\=([0-9.]+);/i", Yii::app()->db->connectionString, $result);
        $str = "mysqladmin  -u".Yii::app()->db->username." -p".Yii::app()->db->password." -h".$result[1]." status";
        echo $thread = `$str`;
        preg_match("/Threads:\s+([0-9]+)\s+/i", $thread, $result);
        if(!isset($result[1]) )
        {
            echo "can not get database connection thread count, exit\n";
            exit();
        }
        else if($result[1] >= 400)
        {
            echo "Database connection thread count {$result[1]} is too large, exit\n";
            exit();
        }

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
            $criteria->order="next_execute_time_utc asc, id desc";
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
            case Store::PLATFORM_WISH:
                $result = $this->processWishScheduleJob($scheduleJob);
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
                while(!$transaction)
                {
                    try
                    {
                        $transaction= Yii::app()->db->beginTransaction();
                    }
                    catch(Exception $ex)
                    {
                        echo "fail to initial transaction, code: {$ex->getCode()}, message: {$ex->getMessage()}.\n";
                        sleep(5);
                    }
                }
                $scheduleJob->last_execute_status = !$result ? ScheduleJob::LAST_EXECUTE_STATUS_ERROR : ScheduleJob::LAST_EXECUTE_STATUS_SUCCESS;
                $scheduleJob->last_finish_time_utc = time();
                if($scheduleJob->type == ScheduleJob::TYPE_ONCE)
                    $scheduleJob->is_active = ScheduleJob::ACTIVE_NO;
                else
                    if($result) $scheduleJob->next_execute_time_utc = $scheduleJob->getNextExecuteTime();
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
            CASE ScheduleJob::ACTION_EBAYSHOPPINGAPIGETMULTIPLEITEMS:
                return $this->eBayGetMultipleItems($scheduleJob);
                break;
            case ScheduleJob::ACTION_EBAYGETMYEBAYSELLING:
                return $this->eBayGetMyeBaySelling($scheduleJob);
                break;
            default:
                echo "Unknow action: {$scheduleJob->action}. Exit!\n";
                return false;
                break;
        }
    }

    protected function processWishScheduleJob($scheduleJob)
    {
        if(empty($scheduleJob)) return false;
        switch($scheduleJob->action)
        {
            case ScheduleJob::ACTION_WISHGETALLPRODUCTS:
                return $this->wishGetAllProducts($scheduleJob);
                break;
            default:
            echo "Unknow action: {$scheduleJob->action}. Exit!\n";
            return false;
            break;
        }
    }

    protected function wishGetAllProducts($scheduleJob)
    {
        $logFile = new LogFile(Yii::app()->params['wish']['logPath'], 'GetSellerList.'.date("Ymd.his", time()).'.log');
        $logFile->saveOutputToFile();

        if(intval($scheduleJob->params) <=0)
        {
            echo "Input parameter(s) error for Wish GetAllProducts, exit!\n";
            return false;
        }

        $store = Store::model()->find("id=:id and platform=:platform and is_active=:is_active", array(":id"=>(int)$scheduleJob->params, ':platform'=>Store::PLATFORM_WISH, ':is_active'=>Store::ACTIVE_YES));
        if(empty($store))
        {
            echo "store doesn't exist or is not active, exit!\n";
            return false;
        }

        WishAPI::GetAllProducts($store->id);

        $store->last_listing_sync_time_utc = time();
        $store->update_time_utc = time();
        $store->update_user_id = 0;
        $store->save();

        echo "end schedule job, platform: ".$scheduleJob->getPlatformText($scheduleJob->platform).", action: ".$scheduleJob->getActionText($scheduleJob->action)."\n\n";
        return true;
    }

    protected function eBayGetMyeBaySelling($scheduleJob)
    {
        $logFile = new LogFile(Yii::app()->params['ebay']['logPath'], 'GetSellerList.'.date("Ymd.his", time()).'.log');
        //$logFile->saveOutputToFile();

        echo "start schedule job, platform: ".$scheduleJob->getPlatformText($scheduleJob->platform).", action: ".$scheduleJob->getActionText($scheduleJob->action)."\n";

        if(intval($scheduleJob->params) <=0)
        {
            echo "Input parameter(s) error for eBay GetMyeBaySelling, exit!\n";
            return false;
        }

        $store = Store::model()->findByPk((int)$scheduleJob->params);

        eBayTradingAPI::GetMyeBaySellingV3Thread($store->id);

        $store->last_listing_sync_time_utc = time();
        $store->update_time_utc = time();
        $store->update_user_id = 0;
        $store->save();

        echo "end schedule job, platform: ".$scheduleJob->getPlatformText($scheduleJob->platform).", action: ".$scheduleJob->getActionText($scheduleJob->action)."\n\n";
        return true;
    }

    protected function eBayGetSellerList($scheduleJob)
    {
        $logFile = new LogFile(Yii::app()->params['ebay']['logPath'], 'GetSellerList.'.date("Ymd.his", time()).'.log');
        //$logFile->saveOutputToFile();

        echo "start schedule job, platform: ".$scheduleJob->getPlatformText($scheduleJob->platform).", action: ".$scheduleJob->getActionText($scheduleJob->action)."\n";

        if(intval($scheduleJob->params) <=0)
        {
            echo "Input parameter(s) error for eBay GetSellerList, exit!\n";
            return false;
        }

        $store = Store::model()->findByPk((int)$scheduleJob->params);

        eBayTradingAPI::GetSellerList($store->id);
        eBayTradingAPI::GetMyeBaySelling($store->id);

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

    protected function eBayGetMultipleItems($scheduleJob)
    {
        $logFile = new LogFile(Yii::app()->params['ebay']['logPath'], 'GetMultipleItems.'.date("Ymd.his", time()).'.log');
        $logFile->saveOutputToFile();
        echo "start schedule job, platform: ".$scheduleJob->getPlatformText($scheduleJob->platform).", action: ".$scheduleJob->getActionText($scheduleJob->action)."\n";

        $offset = 0;
        $limit = 20;
        $changeList = array();

        while(true)
        {
            $CDbCriteria = new CDbCriteria();
            $CDbCriteria->condition = "update_time_utc <= :update_time_utc";
            $CDbCriteria->params = array(':update_time_utc' => time() - 60 * 60 * 4);
            $CDbCriteria->offset = $offset;
            $CDbCriteria->limit = $limit;
            $CDbCriteria->order = "id desc";
            $updateList = eBayItemShoppingApi::model()->findAll($CDbCriteria);
            if(empty($updateList))
            {
                break;
            }
            else
            {
                $idList = array();
                foreach($updateList as $item) $idList[] = $item->ebay_listing_id;
                $temp = eBayShoppingAPI::GetItem($idList);
                $changeList = array_merge($changeList, $temp);
            }
        }

        //process change list
        if(isset($changeList['idList']) && !empty($changeList['idList'])) $this->eBayTargetAndTrack($changeList);

        echo "end schedule job, platform: ".$scheduleJob->getPlatformText($scheduleJob->platform).", action: ".$scheduleJob->getActionText($scheduleJob->action)."\n\n";
        return true;
    }

    protected function eBayTargetAndTrack($changeList)
    {
        $whereSQL = "";
        foreach($changeList['idList'] as $id)
        {
            if(empty($whereSQL))
                $whereSQL = " target_ebay_item_id like '%$id%' ";
            else
                $whereSQL .= " or target_ebay_item_id like '%$id%' ";
        }
        $sql = "select * from {{ebay_target_and_track}}
                where is_active=".eBayTargetAndTrack::ACTIVE_YES." and ($whereSQL)";
        $eBayTargetAndTrackList = eBayTargetAndTrack::model()->findAllBySql($sql);

        if(empty($eBayTargetAndTrackList)) return true;

        foreach($eBayTargetAndTrackList as $tt)
        {
            try
            {
                $notify = "";
                $targetList = explode(',', $tt->target_ebay_item_id);
                $trackList = explode(',', $tt->tracking_ebay_listing_id);
                if(empty($targetList) || empty($trackList))
                {
                    $notify = "Target & Track plan: ".$tt->name." information is not correct, please ".CHtml::link("update", array('/eBay/eBayTargetAndTrack/update', 'id'=>$tt->id))." it.<br />";
                }
                else
                {
                    //current price changed
                    $updateParam = json_decode($tt->update_param);
                    if($updateParam->price->notification_only)
                    {
                        foreach($targetList as $target)
                        {
                            if(!isset($changeList['CurrentPrice->Value'][$target]) || empty($changeList['CurrentPrice->Value'][$target])) continue;
                            $notify .= sprintf("eBay Item <a href=\"http://www.ebay.com/itm/%s\" target=\"_blank\" >%s</a> current price has updated, before: %s, now: %s<br />", $target, $target, sprintf("%1\$.2f", $changeList['CurrentPrice->Value'][$target]['before']), sprintf("%1\$.2f", $changeList['CurrentPrice->Value'][$target]['after']));
                        }
                        $notify .= "please check your item to update price accordingly if needed<br />Including: ";
                        foreach($trackList as $track)
                        {
                            $notify .= CHtml::link(CHtml::encode($track), array('/eBay/eBayListing/view/', 'id' => $track)) . ",&nbsp;";
                        }
                        $notify .= "<br />";
                    }
                    else
                    {
                        $sql = "select group_concat(ebay_listing_id) as appliedList from {{ebay_listing}} where id in ({$tt->tracking_ebay_listing_id}) and company_id = :company_id";
                        $command = Yii::app()->db->createCommand($sql);
                        $command->bindValue(":company_id", $tt->company_id, PDO::PARAM_INT);
                        $result = $command->queryRow();
                        if(empty($result) || !isset($result['appliedList'])) continue;

                        $params = array('applied_listings' => $result['appliedList'], 'update_rules' => array('action' => $updateParam->price->action, 'type' => $updateParam->price->type, 'value' => $updateParam->price->value, 'reference' => '',),);
                        if(count($targetList) == 1)
                        {
                            $params['update_rules']['reference'] = $changeList['CurrentPrice->Value'][$targetList[0]]['after'];
                        }
                        else
                        {
                            if($updateParam->price->target == 'target')
                            {
                                $notify = "Target & Track plan information: ".$tt->name." is not correct, please ".CHtml::link("update", array('/eBay/eBayTargetAndTrack/update', 'id'=>$tt->id))." it.<br />";
                            }
                            else
                            {
                                $total = 0;
                                $highest = 0;
                                $lowest = 0;
                                foreach($changeList['CurrentPrice->Value'] as $key => $target)
                                {
                                    if(in_array($key, $targetList))
                                    {
                                        $total += $target['after'];
                                        if($target['after']>$highest) $highest = $target['after'];
                                        if($target['after']<$lowest) $lowest = $target['after'];
                                    }
                                }
                                if($updateParam->price->target == 'average')
                                    $params['update_rules']['reference'] = $total/count($targetList);
                                else if($updateParam->price->target == 'highest')
                                    $params['update_rules']['reference'] = $highest;
                                else if($updateParam->price->target == 'lowest')
                                    $params['update_rules']['reference'] = $lowest;
                                else
                                {
                                    $notify = "Target & Track plan: ".$tt->name." information is not correct, please ".CHtml::link("update", array('/eBay/eBayTargetAndTrack/update', 'id'=>$tt->id))." it.<br />";
                                }
                            }

                            if(empty($notify))
                            {
                                //setup instant job to revise item
                                $instantJob = new InstantJob();
                                $instantJob->action = InstantJob::ACTION_BULKUPDATEITEMS;
                                $instantJob->status = InstantJob::STATUS_WAIT;
                                $instantJob->platform = Store::PLATFORM_EBAY;
                                $instantJob->params = json_encode($params);
                                $instantJob->create_time_utc = time();
                                if($instantJob->save(false))
                                {
                                    $notify = "Target & Track plan: ".CHtml::link($tt->name, array('/eBay/eBayTargetAndTrack/update', 'id'=>$tt->id))." created updated job successfully, you will receive notification when the update job is done. ";
                                }
                                else
                                {
                                    $notify = "Fail to create job to update items in Target & Track plan: ".$tt->name;
                                }
                            }
                        }
                    }
                }

                if(!empty($notify))
                {
                    $notification = new Notification();
                    $notification->company_id = $tt->company_id;
                    $notification->content = $notify;
                    $notification->is_new = 1;
                    $notification->is_viewable = 1;
                    $notification->title = "Target & Tracking Notification";
                    $notification->type = Notification::type_notification;
                    $notification->create_time_utc = time();
                    $notification->update_time_utc = time();
                    $notification->save();
                }
            }
            catch(Exception $ex)
            {

            }
        }
    }
}
