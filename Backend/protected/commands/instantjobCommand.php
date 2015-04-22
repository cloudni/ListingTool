<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-12-9
 * Time: 10:50pm
 */

Yii::import('application.vendor.eBay.*');
require_once 'eBayTradingAPI.php';

class instantjobCommand extends CConsoleCommand
{
    public function run($args)
    {
        $transaction = null;
        try
        {
            $transaction= Yii::app()->db->beginTransaction();
            $criteria=new CDbCriteria;
            $criteria->condition = "status=:status";
            $criteria->params=array(':status'=>InstantJob::STATUS_WAIT);
            $criteria->order="create_time_utc asc";
            $instantJob = InstantJob::model()->find($criteria);

            if(empty($instantJob))
            {
                echo "no instant job, exit.".date("Y-m-d h:i:sa")."\n";
                return;
            }

            $instantJob->status = InstantJob::STATUS_EXECUTE;
            $instantJob->execute_time_utc = time();
            $instantJob->update();
            $transaction->commit();
        }
        catch(Exception $ex)
        {
            if(isset($transaction)) $transaction->rollback();
            echo "get instant job error, code: {$ex->getCode()}, message: {$ex->getMessage()}.\n";
            return false;
        }

        switch($instantJob->platform)
        {
            case Store::PLATFORM_EBAY:
                $this->processeBayInstantJob($instantJob);
                break;
            case Store::PLATFORM_AMAZON:
                break;
            default:
                echo "Unknow platform: {$instantJob->platform}! exit.\n";
                return;
                break;
        }

    }

    protected function processeBayInstantJob($instantJob)
    {
        if(empty($instantJob)) return false;

        switch($instantJob->action)
        {
            case InstantJob::ACTION_BULKUPDATEITEMS:
                $this->eBayBulkUpdateItems($instantJob);
                break;
            case InstantJob::ACTION_EBAYGETSELLERLIST:
                $this->eBayGetSellerList($instantJob);
                break;
            default:
                echo "Unknow action: {$instantJob->action}. Exit!\n";
                return false;
                break;
        }
    }

    protected function eBayBulkUpdateItems($instantJob)
    {
        echo "start process instant job, platform: ".$instantJob->getPlatformText($instantJob->platform).", action: ".$instantJob->getActionText($instantJob->action)."\n";

        try
        {
            $inputs = json_decode($instantJob->params);
            if(!isset($inputs->applied_listings))
            {
                echo "find error in parameters, exit\n";
                return false;
            }
            if(!isset($inputs->company_id))
            {
                echo "find error in parameters, exit\n";
                return false;
            }
            $params['applied_listings'] = $inputs->applied_listings;
            $params['company_id'] = $inputs->company_id;
            $params['update_rules'] = array();
            if(isset($inputs->update_rules->quantity))
                $params['update_rules']['quantity'] = $inputs->update_rules->quantity;
            if(isset($inputs->update_rules->price))
            {
                $params['update_rules']['price'] = array(
                    'action'=>$inputs->update_rules->price->action,
                    'value'=>$inputs->update_rules->price->value,
                    'type'=>$inputs->update_rules->price->type,
                );
            }
            if(isset($inputs->update_rules->description))
            {
                $params['update_rules']['description'] = array(
                    'action'=>$inputs->update_rules->description->action,
                    'tag'=>$inputs->update_rules->description->tag,
                    'value'=>$inputs->update_rules->description->value,
                    'position'=>$inputs->update_rules->description->position,
                );
            }
            if(isset($inputs->update_rules->excludeShipLocation))
            {
                $params['update_rules']['excludeShipLocation'] = $inputs->update_rules->excludeShipLocation;
            }

            $result = eBayTradingAPI::ReviseListing($params, false);

            $resultStr = "";
            $resultStr .= "Bulk update items ended!\n";
            $resultStr .=  "Total processed: {$result['Total']}, Successed: ".count($result['Success']).", Warning: ".count($result['Warning']).", Failed: ".count($result['Failure']).", Unknow status: ".count($result['UnknownStatus'])."\n";
            if(!empty($result['Success']))
            {
                $resultStr .=  "Successed: ";
                foreach($result['Success'] as $row)
                {
                    $resultStr .=  $row['listingId'].", ";
                }
                $resultStr .=  "\n";
            }
            if(!empty($result['Warning']))
            {
                $resultStr .=  "Warning: ";
                foreach($result['Warning'] as $row)
                {
                    $resultStr .=  $row['listingId']."\n";
                    foreach($row['Msg'] as $msg)
                    {
                        $resultStr .=  $msg."\n";
                    }
                }
                echo "\n";
            }
            if(!empty($result['Failure']))
            {
                $resultStr .=  "Failure: ";
                foreach($result['Failure'] as $row)
                {
                    $resultStr .=  $row['listingId'].", status: ".$row['Status']."\n";
                    foreach($row['Msg'] as $msg)
                    {
                        $resultStr .=  $msg."\n";
                    }
                }
                $resultStr .=  "\n";
            }
            if(!empty($result['UnknownStatus']))
            {
                $resultStr .=  "Unknown Status: ";
                foreach($result['UnknownStatus'] as $row)
                {
                    $resultStr .=  $row['listingId'].", ";
                }
                $resultStr .=  "\n";
            }

            echo $resultStr;
            echo "instant job finished!\n";

            $transaction = null;
            try
            {
                $transaction= Yii::app()->db->beginTransaction();
                $instantJob->status = InstantJob::STATUS_END;
                $instantJob->finish_time_utc = time();
                $instantJob->update();

                $notification = new Notification();
                $notification->title = "Bulk update eBay listings finished.";
                $notification->content = $resultStr;
                $notification->type = Notification::type_notification;
                $notification->is_new = true;
                $notification->company_id = (int)$params['company_id'];
                $notification->save(false);

                $transaction->commit();
                return true;
            }
            catch(Exception $ex)
            {
                if(isset($transaction)) $transaction->rollback();
                echo "fail to update instant job status to end, code: {$ex->getCode()}, message: {$ex->getMessage()}.\n";
                return false;
            }
        }
        catch(Exception $ex)
        {
            echo "instant job caught exception, code: {$ex->getCode()}, message: {$ex->getMessage()}.\n";
            $instantJob->status = InstantJob::STATUS_ERROR;
            $instantJob->update();
            return false;
        }
    }

    protected function eBayGetSellerList($instantJob)
    {
        echo "start process instant job, platform: ".$instantJob->getPlatformText($instantJob->platform).", action: ".$instantJob->getActionText($instantJob->action)."\n";

        if(intval($instantJob->params) <=0)
        {
            echo "Input parameter(s) error, exit!\n";
            return false;
        }

        $store = Store::model()->findByPk((int)$instantJob->params);

        $result = eBayTradingAPI::GetSellerList($store->id);

        $transaction = null;
        try
        {
            $transaction= Yii::app()->db->beginTransaction();
            $instantJob->status = empty($result) ? InstantJob::STATUS_END : InstantJob::STATUS_ERROR;
            $instantJob->finish_time_utc = time();
            $instantJob->update();

            $store->last_listing_sync_time_utc = time();
            $store->update();

            $notification = new Notification();
            $notification->title = empty($result) ? "Sync eBay listings Succeeded." : "Sync eBay listings Failed.";
            $notification->content = empty($result) ? "Sync eBay listings Succeeded." : "Error Code: {$result['ErrorCode']}.\nError Message: {$result['ShortMessage']}";
            $notification->type = Notification::type_notification;
            $notification->is_new = true;
            $notification->company_id = $store->company_id;
            $notification->save(false);

            $transaction->commit();
            return true;
        }
        catch(Exception $ex)
        {
            if(isset($transaction)) $transaction->rollback();
            echo "fail to update instant job status to end, code: {$ex->getCode()}, message: {$ex->getMessage()}.\n";
            return false;
        }
    }
} 