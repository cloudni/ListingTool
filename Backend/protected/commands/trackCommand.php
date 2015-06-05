<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/6/6
 * Time: 0:21
 */

Yii::import('application.vendor.eBay.*');
require_once 'eBayTradingAPI.php';
require_once 'reference.php';

class trackCommand extends CConsoleCommand
{
    public function run($args)
    {
        $eBayEntityType = eBayEntityType::model()->find('entity_model=:entity_model', array(':entity_model'=>'eBayListing'));
        $eBayAttributeSet = eBayAttributeSet::model()->find(
            'entity_type_id=:entity_type_id',
            array(
                ':entity_type_id'=>$eBayEntityType->id,
            )
        );

        $listingStatusAttribute = $eBayAttributeSet->getEntityAttribute("SellingStatus->ListingStatus");

        $select = "SELECT t.*
                            FROM `lt_ebay_listing` `t`
                            left join lt_ebay_entity_varchar as sstatus on sstatus.ebay_entity_id = t.id and sstatus.ebay_entity_attribute_id = {$listingStatusAttribute->id}
                            where t.company_id=3 and (t.store_id = 25 or t.store_id = 26)
                            and sstatus.value = '".eBayListingStatusCodeType::Active."' ; ";
        $command = Yii::app()->db->createCommand($select);
        $listings = $command->queryAll();

        $ij = InstantJob::model()->findByPk(13);

        foreach($listings as $listing)
        {
            if(!isset($listing["site_id"])) continue;
            $replace = $ij->params;
            $replace = str_replace("ebay_listing_id", $listing["ebay_listing_id"], $replace);
            $replace = str_replace("ebay_user_id", 3, $replace);
            $replace = str_replace("ebay_store_id", $listing["store_id"], $replace);
            $replace = str_replace("ebay_site_id", $listing["site_id"], $replace);
            $inputs = json_decode($replace);

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
            //$resultStr .= "Bulk update items ended!\n";
            //$resultStr .=  "Total processed: {$result['Total']}, Successed: ".count($result['Success']).", Warning: ".count($result['Warning']).", Failed: ".count($result['Failure']).", Unknow status: ".count($result['UnknownStatus'])."\n";
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

            echo $resultStr;die();
        }
    }
}