<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-10-30
 * Time: 8:57pm
 */

Yii::import('application.vendor.*');
require_once("reference.php");
require_once("eBayService.php");
Yii::import('application.components.*');
require_once("ExceptionHandler/ExceptionCode.php");

class eBayTradingAPI
{
    /*
     * input $store_id, indicate which store to sync listing
     * input $parmas, all fields that could be included in the call request
     * array(
            'AdminEndedItemsOnly'=>false, //Specifies whether to return only items that were administratively ended based on a policy violation.
            'CategoryID'=>0, //The category ID for the items retrieved. If you specify CategoryID in a GetSellerList call, the response contains only items in the category you specify.
            'EndTimeFrom'=>'', //Specifies the earliest (oldest) date to use in a date range filter based on item end time. Specify either an end-time range or a start-time range filter in every call request. Each of the time ranges must be a value less than 120 days.
            'EndTimeTo'=>'', //Specifies the latest (most recent) date to use in a date range filter based on item end time. Must be specified if EndTimeFrom is specified.
            'GranularityLevel'=>'', //Specifies the subset of item and user fields to return.
            'IncludeVariations'=>'', //If true, the Variations node is returned for all multi-variation listings in the response.
            'IncludeWatchCount'=>'', //Specifies whether to include WatchCount in Item nodes returned. WatchCount is only returned with DetailLevel ReturnAll.
            'MotorsDealerUsers'=>array(), //Specifies the list of Motors Dealer sellers for which a special set of metrics can be requested. Applies to eBay Motors Pro applications only.
            'Pagination'=>array('EntriesPerPage'=>20, 'PageNumber'=>0), //Contains the data controlling the pagination of the returned values.
            'SKUArray'=>array(), //Container for a set of SKUs.
            'Sort'=>0, //Specifies the order in which returned items are sorted (based on the end dates of the item listings)
            'StartTimeFrom'=>'', //Specifies the earliest (oldest) date to use in a date range filter based on item start time.Each of the time ranges must be a value less than 120 days.
            'StartTimeTo'=>'', //Specifies the latest (most recent) date to use in a date range filter based on item start time. Must be specified if StartTimeFrom is specified.
            'UserID'=>'', //Specifies the seller whose items will be returned. UserID is an optional input. If not specified, retrieves listings for the user identified by the authentication token passed in the request.
            'DetailLevel'=>'ReturnAll', //Detail levels are instructions that define standard subsets of data to return for particular data components (e.g., each Item, Transaction, or User) within the response payload
            'ErrorLanguage'=>'en_US', //Use ErrorLanguage to return error strings for the call in a different language from the language commonly associated with the site that the requesting user is registered with
            'Version'=>'', //The version number of the API code that you are programming against
            'WarningLevel'=>'High', //Controls whether or not to return warnings when the application passes unrecognized or deprecated elements in a request.
        );
     * output null
     */
    public static function GetSellerList(
        $store_id,
        $params = array(
            'AdminEndedItemsOnly'=>false,
            'CategoryID'=>0,
            'EndTimeFrom'=>'',
            'EndTimeTo'=>'',
            'GranularityLevel'=>eBayGranularityLevelCodeType::Fine,
            'IncludeVariations'=>true,
            'IncludeWatchCount'=>true,
            'MotorsDealerUsers'=>array(),
            'Pagination'=>array('EntriesPerPage'=>50, 'PageNumber'=>1),
            'SKUArray'=>array(),
            'Sort'=>0,
            'StartTimeFrom'=>'',
            'StartTimeTo'=>'',
            'UserID'=>'',
            //'DetailLevel'=>eBayDetailLevelCodeType::ReturnAll,
            'ErrorLanguage'=>eBayErrorLanguageType::en_US,
            'Version'=>'',
            'WarningLevel'=>eBayWarningLevelCodeType::Low,
        )
    )
    {
        if(empty($params['StartTimeFrom'])) $params['StartTimeFrom'] = date('c', time()-60*60*24*3);
        if(empty($params['StartTimeTo'])) $params['StartTimeTo'] = date('c', time());
        $store = Store::model()->findByPk($store_id);
        if(empty($store)) return false;

        $site_id=!isset($store->ebay_site_code) ? eBaySiteIdCodeType::US : $store->ebay_site_code;

        $eBayEntityType = eBayEntityType::model()->find('entity_model=:entity_model', array(':entity_model'=>'eBayListing'));
        if(empty($eBayEntityType)) return false;

        $eBayService = new eBayService();
        $eBayService->post_data = $eBayService->getRequestAuthHead($store->ebay_token, "GetSellerList").eBayTradingAPI::GetSellerListXML($params).$eBayService->getRequestAuthFoot("GetSellerList");
        $eBayService->api_url = $store->eBayApiKey->api_url;
        $eBayService->createHTTPHead($site_id, $store->eBayApiKey->compatibility_level, $store->eBayApiKey->dev_id, $store->eBayApiKey->app_id, $store->eBayApiKey->cert_id, "GetSellerList");
        echo "start to call GetSellerList for store id: $store_id, site id: $site_id\n";

        try
        {
            $result = $eBayService->request();

            if(empty($result))
            {
                echo "service call failed with no return.\n";
                return false;
            }

            if((string)$result->Ack===eBayAckCodeType::Success)
            {
                /*process seller information */
                eBayTradingAPI::processeBaySeller($store, $result->Seller);

                //change all active item's status to ended. in case any update leak
                $eBayAttributeSet = eBayAttributeSet::model()->find(
                    'entity_type_id=:entity_type_id and is_active=:is_active',
                    array(
                        ':entity_type_id'=>$eBayEntityType->id,
                        ':is_active'=>true,
                    )
                );
                if(empty($eBayAttributeSet)) return false;
                $statusAttribute = $eBayAttributeSet->getEntityAttribute('SellingStatus->ListingStatus');
                $clearSQL = "update lt_ebay_entity_varchar t
                                set `value` = :value
                                where t.id in (select * from (
                                SELECT t.id FROM lt_ebay_entity_varchar t
                                left join lt_ebay_listing el on el.id = t.ebay_entity_id
                                left join lt_store s on s.id = el.store_id
                                where ebay_entity_attribute_id = :ebay_entity_attribute_id and s.id = :store_id and t.value = :active_value) as inside ); ";
                $command = Yii::app()->db->createCommand($clearSQL);
                $command->bindValue(":value", eBayListingStatusCodeType::Ended, PDO::PARAM_STR);
                $command->bindValue(":ebay_entity_attribute_id", $statusAttribute->id, PDO::PARAM_INT);
                $command->bindValue(":store_id", $store_id, PDO::PARAM_INT);
                $command->bindValue(":active_value", eBayListingStatusCodeType::Active, PDO::PARAM_STR);
                $command->execute();

                $HasMoreItems = (bool)$result->HasMoreItems;
                $Pagination = array(
                    'TotalNumberOfPages'=>(int)$result->PaginationResult->TotalNumberOfPages,
                    'TotalNumberOfEntries'=>(int)$result->PaginationResult->TotalNumberOfEntries,
                );
                echo "GetSellerList call succeeded! HasMoreItems: $HasMoreItems, TotalNumberOfPages: {$Pagination['TotalNumberOfPages']}, TotalNumberOfEntries: {$Pagination['TotalNumberOfEntries']}, EntriesPerPage: {$params['Pagination']['EntriesPerPage']}\n";
                echo "current process page: {$params['Pagination']['PageNumber']}\n\n";

                if(!empty($result->ItemArray->Item))
                {
                    $itemList = (array)$result->ItemArray;
                    if(!empty($itemList))
                    {
                        if(is_array($itemList['Item']))
                        {
                            foreach($itemList['Item'] as $key=>$item)
                            {
                                eBayTradingAPI::processeBayListingV2($store, $item, $eBayEntityType);
                            }
                        }
                        else
                        {
                            eBayTradingAPI::processeBayListingV2($store, $itemList['Item'], $eBayEntityType);
                        }
                    }
                }

                while($HasMoreItems && $params['Pagination']['PageNumber'] < $Pagination['TotalNumberOfPages'])
                {
                    $params['Pagination']['PageNumber']++;
                    echo "current process page: {$params['Pagination']['PageNumber']}\n\n";
                    $eBayService->post_data = $eBayService->getRequestAuthHead($store->ebay_token, "GetSellerList").eBayTradingAPI::GetSellerListXML($params).$eBayService->getRequestAuthFoot("GetSellerList");
                    $result = $eBayService->request();
                    if(empty($result))
                    {
                        echo "service call failed with no return.\n";
                        return false;
                    }

                    if(!empty($result->Ack) && (string)$result->Ack===eBayAckCodeType::Success)
                    {
                        $HasMoreItems = (bool)$result->HasMoreItems;
                        if(!empty($result->ItemArray->Item))
                        {
                            $itemList = (array)$result->ItemArray;
                            if(!empty($itemList))
                            {
                                if(is_array($itemList['Item']))
                                {
                                    foreach($itemList['Item'] as $key=>$item)
                                    {
                                        eBayTradingAPI::processeBayListingV2($store, $item, $eBayEntityType);
                                    }
                                }
                                else
                                {
                                    eBayTradingAPI::processeBayListingV2($store, $itemList['Item'], $eBayEntityType);
                                }
                            }
                        }
                    }
                    else
                    {
                        $Version = (string)$result->Version;
                        $Timestamp = (string)$result->Timestamp;
                        $Errors = array(
                            'ErrorClassification'=>(string)$result->Errors->ErrorClassification,
                            'ErrorCode'=>(string)$result->Errors->ErrorCode,
                            'ShortMessage'=>(string)$result->Errors->ShortMessage,
                            'LongMessage'=>(string)$result->Errors->LongMessage,
                            'SeverityCode'=>(string)$result->Errors->SeverityCode,
                        );
                        var_dump($Version, $Timestamp, $Errors, $result);
                        return $Errors;
                    }
                }
            }
            else
            {
                $Version = (string)$result->Version;
                $Timestamp = (string)$result->Timestamp;
                $Errors = array(
                    'ErrorClassification'=>(string)$result->Errors->ErrorClassification,
                    'ErrorCode'=>(string)$result->Errors->ErrorCode,
                    'ShortMessage'=>(string)$result->Errors->ShortMessage,
                    'LongMessage'=>(string)$result->Errors->LongMessage,
                    'SeverityCode'=>(string)$result->Errors->SeverityCode,
                );
                var_dump($Version, $Timestamp, $Errors, $result);
                return $Errors;
            }
        }
        catch(Exception $ex)
        {
            var_dump($ex);
            return array(
                'ErrorCode'=>$ex->getCode(),
                'ShortMessage'=>$ex->getMessage(),
            );
        }

        return;
    }

    /*
    * process seller listing and save into database
    */
    protected static function processeBayListingV2($store=null, $item=null, $eBayEntityType=null)
    {
        if(empty($store) || empty($item) || empty($eBayEntityType)) return false;

        echo(date("Y-m-d H:i:s", time())."start to process eBay item: ".(string)$item->ItemID)."\n";

        $eBayListing = eBayListing::model()->find('ebay_listing_id=:ebay_listing_id and company_id=:company_id', array(':ebay_listing_id'=>(string)$item->ItemID, ':company_id'=>$store->company_id));
        $eBayAttributeSet = eBayAttributeSet::model()->find(
            'entity_type_id=:entity_type_id and is_active=:is_active',
            array(
                ':entity_type_id'=>$eBayEntityType->id,
                ':is_active'=>true,
            )
        );
        if(empty($eBayAttributeSet)) return false;

        $transaction=NULL;
        try
        {
            $transaction= Yii::app()->db->beginTransaction();
            //save or update eBay Listing main object
            if(empty($eBayListing))
            {
                $eBayListing = new eBayListing();
                $eBayListing->store_id = $store->id;
                $eBayListing->company_id = $store->company_id;
                $eBayListing->ebay_listing_id = (string)$item->ItemID;
                $eBayListing->site_id = (int)eBaySiteName::geteBaySiteNameCode((string)$item->Site);
                $eBayListing->ebay_entity_type_id = $eBayEntityType->id;
                $eBayListing->ebay_attribute_set_id = $eBayAttributeSet->id;
                $eBayListing->is_active = true;
                if(!$eBayListing->save(false))
                {
                    echo("insert eBay item ".(string)$item->ItemID." failed!\n"."item process finished\n");
                    $transaction->rollback();
                    return false;
                }
                echo("insert eBay item ".(string)$item->ItemID." succeeded!\n");
            }
            else
            {
                $eBayListing->store_id = $store->id;
                $eBayListing->company_id = $store->company_id;
                $eBayListing->ebay_listing_id = (string)$item->ItemID;
                $eBayListing->site_id = (int)eBaySiteName::geteBaySiteNameCode((string)$item->Site);
                $eBayListing->ebay_entity_type_id = $eBayEntityType->id;
                $eBayListing->ebay_attribute_set_id = $eBayAttributeSet->id;
                if(!$eBayListing->save(false))
                {
                    echo("update eBay item ".(string)$item->ItemID." failed!\n"."item process finished\n");
                    $transaction->rollback();
                    return false;
                }
                echo("update eBay item ".(string)$item->ItemID." succeeded!\n");

                //clear all item's attribute value record
                self::clearAlleBayEntityAttributeValue($eBayListing);
                echo "all attribute value have been cleared.\n";
            }
            $transaction->commit();$transaction = null;

            //useing GetItem to retreive item description
            /*if(isset($item->SellingStatus->ListingStatus) && (string)$item->SellingStatus->ListingStatus == eBayListingStatusCodeType::Active)
                return eBayTradingAPI::GetItem($eBayListing);*/

            $transaction= Yii::app()->db->beginTransaction();
            //start to process attribute by attribute
            echo("start to process eBay item ".(string)$item->ItemID." attribute:\n");
            eBayTradingAPI::processeBayEntityAttributesRC($eBayListing, $eBayAttributeSet, $item);
            $transaction->commit();
            echo("eBay item: ".(string)$item->ItemID." attribute process finished!\n".date("Y-m-d H:i:s", time())."item process finished\n\n");
        }
        catch(Exception $ex)
        {
            if(isset($transaction)) $transaction->rollback();
            echo("eBay item: ".(string)$item->ItemID." attribute process failed!\n".date("Y-m-d H:i:s", time())."{$ex->getCode()} {$ex->getmessage()}\nitem process terminated!\n\n");
        }
    }

    /*
     * process eBay attribute recursively
     */
    protected static function processeBayEntityAttributesRC($eBayEntity=null, $eBayAttributeSet=null, $eBayItem=null, $parentEntityAttribute=null, $parentValueId=0, $indentation='|--')
    {
        $eBayItem = (array)$eBayItem;
        foreach($eBayItem as $key=>$field)
        {
            if(gettype($field) != 'string' && gettype($field) != 'array' && gettype($field) != 'object')
            {
                echo($indentation."unknown attribute, key: $key, type: ".gettype($field)."\n");
                continue;
            }

            //save or update attribute
            $criteria = new CDbCriteria;
            $criteria->join = 'left join {{ebay_attribute}} ea on ea.id = t.attribute_id';
            $criteria->condition = 't.attribute_set_id=:attribute_set_id and t.parent_id=:parent_id and ea.code=:code';
            $criteria->params = array(
                ':attribute_set_id'=>$eBayAttributeSet->id,
                ':parent_id'=>!isset($parentEntityAttribute) ? 0 : $parentEntityAttribute->id,
                ':code'=>$key,
            );
            $currenteBayEntityAttribute = eBayEntityAttribute::model()->find($criteria);
            if(empty($currenteBayEntityAttribute))
            {
                echo("----eBay attribute $key does not exist!".var_dump($key, $field)."\n");
                continue;
            }


            if(gettype($field) == 'array')
            {
                $objectSubField = false;
                foreach($field as $subField)
                {
                    if(gettype($subField) == 'object')
                    {
                        $objectSubField = true;
                        if(Yii::app()->params['ebay']['echoAttributeDetail'])
                        {
                            echo($indentation."$key, type:".gettype($field).". ");
                            echo "Entity Attribute id: ".$currenteBayEntityAttribute->id.". ";
                            echo "\n";
                        }
                        $valueId = eBayTradingAPI::SaveAttributeValue($eBayEntity, $currenteBayEntityAttribute, $subField, $parentEntityAttribute, $parentValueId);
                        eBayTradingAPI::processeBayEntityAttributesRC($eBayEntity, $eBayAttributeSet, $subField, $currenteBayEntityAttribute, $valueId, $indentation.'|--');
                    }
                    else
                    {
                        break;
                    }
                }
                if(!$objectSubField)
                {
                    if(Yii::app()->params['ebay']['echoAttributeDetail'])
                    {
                        echo($indentation."$key, type:".gettype($field).". ");
                        echo "Entity Attribute id: ".$currenteBayEntityAttribute->id.". ";
                        echo "\n";
                    }
                    eBayTradingAPI::SaveAttributeValue($eBayEntity, $currenteBayEntityAttribute, $field, $parentEntityAttribute, $parentValueId);
                }
            }
            else
            {
                if(Yii::app()->params['ebay']['echoAttributeDetail'])
                {
                    echo($indentation."$key, type:".gettype($field).". ");
                    echo "Entity Attribute id: ".$currenteBayEntityAttribute->id.". ";
                    echo "\n";
                }
                $valueId = eBayTradingAPI::SaveAttributeValue($eBayEntity, $currenteBayEntityAttribute, $field, $parentEntityAttribute, $parentValueId);
                if(gettype($field) == 'object')
                {
                    eBayTradingAPI::processeBayEntityAttributesRC($eBayEntity, $eBayAttributeSet, $field, $currenteBayEntityAttribute, $valueId, $indentation.'|--');
                }
            }
        }
    }

    /*
     * clear out all eBay listing attrbute value before update
     */
    protected static function clearAlleBayEntityAttributeValue($eBayEntity)
    {
        $clearSQL = "update {{{$eBayEntity->eBayEntityType->value_table}_varchar}} set
                        `ebay_attribute_id` = null,
                        `ebay_entity_attribute_id` = null,
                        `parent_value_id` = null,
                        `parent_value_type` = null,
                        `parent_value_entity_attribute_id` = null
                        where `ebay_entity_type_id`=:ebay_entity_type_id and `ebay_entity_id`=:ebay_entity_id; ";
        $command = Yii::app()->db->createCommand($clearSQL);
        $command->bindValue(":ebay_entity_type_id", $eBayEntity->ebay_entity_type_id, PDO::PARAM_INT);
        $command->bindValue(":ebay_entity_id", $eBayEntity->id, PDO::PARAM_INT);
        $result = $command->execute();

        $clearSQL = "update {{{$eBayEntity->eBayEntityType->value_table}_text}} set
                        `ebay_attribute_id` = null,
                        `ebay_entity_attribute_id` = null,
                        `parent_value_id` = null,
                        `parent_value_type` = null,
                        `parent_value_entity_attribute_id` = null
                        where `ebay_entity_type_id`=:ebay_entity_type_id and `ebay_entity_id`=:ebay_entity_id; ";
        $command = Yii::app()->db->createCommand($clearSQL);
        $command->bindValue(":ebay_entity_type_id", $eBayEntity->ebay_entity_type_id, PDO::PARAM_INT);
        $command->bindValue(":ebay_entity_id", $eBayEntity->id, PDO::PARAM_INT);
        $result = $command->execute();

        $clearSQL = "update {{{$eBayEntity->eBayEntityType->value_table}_int}} set
                        `ebay_attribute_id` = null,
                        `ebay_entity_attribute_id` = null,
                        `parent_value_id` = null,
                        `parent_value_type` = null,
                        `parent_value_entity_attribute_id` = null
                        where `ebay_entity_type_id`=:ebay_entity_type_id and `ebay_entity_id`=:ebay_entity_id; ";
        $command = Yii::app()->db->createCommand($clearSQL);
        $command->bindValue(":ebay_entity_type_id", $eBayEntity->ebay_entity_type_id, PDO::PARAM_INT);
        $command->bindValue(":ebay_entity_id", $eBayEntity->id, PDO::PARAM_INT);
        $result = $command->execute();

        $clearSQL = "update {{{$eBayEntity->eBayEntityType->value_table}_decimal}} set
                        `ebay_attribute_id` = null,
                        `ebay_entity_attribute_id` = null,
                        `parent_value_id` = null,
                        `parent_value_type` = null,
                        `parent_value_entity_attribute_id` = null
                        where `ebay_entity_type_id`=:ebay_entity_type_id and `ebay_entity_id`=:ebay_entity_id; ";
        $command = Yii::app()->db->createCommand($clearSQL);
        $command->bindValue(":ebay_entity_type_id", $eBayEntity->ebay_entity_type_id, PDO::PARAM_INT);
        $command->bindValue(":ebay_entity_id", $eBayEntity->id, PDO::PARAM_INT);
        $result = $command->execute();

        $clearSQL = "update {{{$eBayEntity->eBayEntityType->value_table}_datetime}} set
                        `ebay_attribute_id` = null,
                        `ebay_entity_attribute_id` = null,
                        `parent_value_id` = null,
                        `parent_value_type` = null,
                        `parent_value_entity_attribute_id` = null
                        where `ebay_entity_type_id`=:ebay_entity_type_id and `ebay_entity_id`=:ebay_entity_id; ";
        $command = Yii::app()->db->createCommand($clearSQL);
        $command->bindValue(":ebay_entity_type_id", $eBayEntity->ebay_entity_type_id, PDO::PARAM_INT);
        $command->bindValue(":ebay_entity_id", $eBayEntity->id, PDO::PARAM_INT);
        $result = $command->execute();

        $clearSQL = "update {{{$eBayEntity->eBayEntityType->value_table}_container}} set
                        `ebay_attribute_id` = null,
                        `ebay_entity_attribute_id` = null,
                        `parent_value_id` = null,
                        `parent_value_type` = null,
                        `parent_value_entity_attribute_id` = null
                        where `ebay_entity_type_id`=:ebay_entity_type_id and `ebay_entity_id`=:ebay_entity_id; ";
        $command = Yii::app()->db->createCommand($clearSQL);
        $command->bindValue(":ebay_entity_type_id", $eBayEntity->ebay_entity_type_id, PDO::PARAM_INT);
        $command->bindValue(":ebay_entity_id", $eBayEntity->id, PDO::PARAM_INT);
        $result = $command->execute();

        $clearSQL = "update {{{$eBayEntity->eBayEntityType->value_table}_boolean}} set
                        `ebay_attribute_id` = null,
                        `ebay_entity_attribute_id` = null,
                        `parent_value_id` = null,
                        `parent_value_type` = null,
                        `parent_value_entity_attribute_id` = null
                        where `ebay_entity_type_id`=:ebay_entity_type_id and `ebay_entity_id`=:ebay_entity_id; ";
        $command = Yii::app()->db->createCommand($clearSQL);
        $command->bindValue(":ebay_entity_type_id", $eBayEntity->ebay_entity_type_id, PDO::PARAM_INT);
        $command->bindValue(":ebay_entity_id", $eBayEntity->id, PDO::PARAM_INT);
        $result = $command->execute();
    }

    /*
     * save eBay entity attribute value into database
     */
    protected static function SaveAttributeValue($eBayEntity, $eBayEntityAttribute, $field, $parentEntityAttribute=null, $parentValueId=0)
    {
        //get attribute value type
        switch($eBayEntityAttribute->eBayAttribute->backend_type)
        {
            case eBayAttribute::BACKEND_TYPE_INT:
                $valueType = 'int';
                break;
            case eBayAttribute::BACKEND_TYPE_DECIMAL:
                $valueType = 'decimal';
                break;
            case eBayAttribute::BACKEND_TYPE_VARCHAR:
                $valueType = 'varchar';
                break;
            case eBayAttribute::BACKEND_TYPE_TEXT:
                $valueType = 'text';
                break;
            case eBayAttribute::BACKEND_TYPE_DATETIME:
                $valueType = 'datetime';
                break;
            case eBayAttribute::BACKEND_TYPE_BOOLEAN:
                $valueType = 'boolean';
                break;
            case eBayAttribute::BACKEND_TYPE_CONTAINER:
                $valueType = 'container';
                break;
            default:
                echo "unknown attribute value type:".$eBayEntityAttribute->eBayAttribute->backend_type.". ";
                return false;
                break;
        }

        //find if any cleared attribute value records exist
        $query = "select *
                    from {{{$eBayEntity->eBayEntityType->value_table}_{$valueType}}} valuetable
                    where `ebay_attribute_id` is null and `ebay_entity_attribute_id` is null and
                    `parent_value_id` is null and `parent_value_type` is null and `parent_value_entity_attribute_id` is null
                    and`ebay_entity_type_id`=:ebay_entity_type_id and `ebay_entity_id`=:ebay_entity_id;";
        $command = Yii::app()->db->createCommand($query);
        $command->bindValue(":ebay_entity_type_id", $eBayEntity->ebay_entity_type_id, PDO::PARAM_INT);
        $command->bindValue(":ebay_entity_id", $eBayEntity->id, PDO::PARAM_INT);
        $cleared = $command->queryAll();

        $fieldCount = (gettype($field) == 'array' ? count($field) : 1);
        $maxCount = $fieldCount > count($cleared) ? $fieldCount : count($cleared);
        for($i=0;$i<$maxCount;$i++)
        {
            //update
            if(isset($cleared[$i]) && $i < $fieldCount)
            {
                $update ="update {{{$eBayEntity->eBayEntityType->value_table}_{$valueType}}} set
                    `ebay_attribute_id` = :ebay_attribute_id,
                    `ebay_entity_attribute_id` = :ebay_entity_attribute_id,
                    `parent_value_id` = :parent_value_id,
                    `parent_value_type` = :parent_value_type,
                    `parent_value_entity_attribute_id` = :parent_value_entity_attribute_id,
                    `value`=:value where id=:id; ";
                $command = Yii::app()->db->createCommand($update);
                switch($eBayEntityAttribute->eBayAttribute->backend_type)
                {
                    case eBayAttribute::BACKEND_TYPE_INT://int
                        $command->bindValue(":value", (int)(gettype($field) == 'array' ? $field[$i] : $field), PDO::PARAM_INT);
                        break;
                    case eBayAttribute::BACKEND_TYPE_DECIMAL://decimal
                        $command->bindValue(":value", (float)(gettype($field) == 'array' ? $field[$i] : $field));
                        break;
                    case eBayAttribute::BACKEND_TYPE_VARCHAR://varchar
                        $command->bindValue(":value", (string)(gettype($field) == 'array' ? $field[$i] : $field));
                        break;
                    case eBayAttribute::BACKEND_TYPE_TEXT://text
                        $command->bindValue(":value", (string)(gettype($field) == 'array' ? $field[$i] : $field));
                        break;
                    case eBayAttribute::BACKEND_TYPE_DATETIME://datetime
                        $command->bindValue(":value", strtotime((string)(gettype($field) == 'array' ? $field[$i] : $field)), PDO::PARAM_INT);
                        break;
                    case eBayAttribute::BACKEND_TYPE_BOOLEAN://boolean
                        $command->bindValue(":value", ((string)(gettype($field) == 'array' ? $field[$i] : $field) == 'false') ? false : true, PDO::PARAM_INT);
                        break;
                    case eBayAttribute::BACKEND_TYPE_CONTAINER://container
                        $command->bindValue(":value", '', PDO::PARAM_STR);
                        break;
                    default:
                        echo "unknown attribute value type:".$eBayEntityAttribute->eBayAttribute->backend_type.". ";
                        continue;
                        break;
                }
                $command->bindValue(":ebay_attribute_id", $eBayEntityAttribute->eBayAttribute->id, PDO::PARAM_INT);
                $command->bindValue(":ebay_entity_attribute_id", $eBayEntityAttribute->id, PDO::PARAM_INT);
                if($parentValueId && isset($parentEntityAttribute))
                {
                    $command->bindValue(":parent_value_id", $parentValueId, PDO::PARAM_INT);
                    $command->bindValue(":parent_value_type", $parentEntityAttribute->eBayAttribute->backend_type, PDO::PARAM_INT);
                    $command->bindValue(":parent_value_entity_attribute_id", $parentEntityAttribute->id, PDO::PARAM_INT);
                }
                else
                {
                    $command->bindValue(":parent_value_id", 0, PDO::PARAM_INT);
                    $command->bindValue(":parent_value_type", 0, PDO::PARAM_INT);
                    $command->bindValue(":parent_value_entity_attribute_id", 0, PDO::PARAM_INT);
                }
                $command->bindValue(":id", $cleared[$i]['id'], PDO::PARAM_INT);
                $command->execute();
                //echo(" update entity value type:{$valueType}, id: ".$cleared[$i]['id'].", value: ".(string)(gettype($field) == 'array' ? $field[$i] : $field).". ");
                if(gettype($field) != 'array')  return $cleared[$i]['id'];
            }
            //insert
            elseif(!isset($cleared[$i]) && $i < $fieldCount)
            {
                $insert = "INSERT INTO {{{$eBayEntity->eBayEntityType->value_table}_{$valueType}}}
                            (`ebay_entity_type_id`, `ebay_attribute_id`, `ebay_entity_attribute_id`, `value`, `ebay_entity_id`, `parent_value_id`, `parent_value_type`, `parent_value_entity_attribute_id`)
                            VALUES
                            (:ebay_entity_type_id, :ebay_attribute_id, :ebay_entity_attribute_id, :value, :ebay_entity_id, :parent_value_id, :parent_value_type, :parent_value_entity_attribute_id);";
                $command = Yii::app()->db->createCommand($insert);
                $command->bindValue(":ebay_entity_type_id", $eBayEntity->ebay_entity_type_id, PDO::PARAM_INT);
                $command->bindValue(":ebay_attribute_id", $eBayEntityAttribute->eBayAttribute->id, PDO::PARAM_INT);
                $command->bindValue(":ebay_entity_attribute_id", $eBayEntityAttribute->id, PDO::PARAM_INT);
                $command->bindValue(":ebay_entity_id", $eBayEntity->id, PDO::PARAM_INT);
                switch($eBayEntityAttribute->eBayAttribute->backend_type)
                {
                    case 1://int
                        $command->bindValue(":value", (int)(gettype($field) == 'array' ? $field[$i] : $field), PDO::PARAM_INT);
                        break;
                    case 2://decimal
                        $command->bindValue(":value", (float)(gettype($field) == 'array' ? $field[$i] : $field));
                        break;
                    case 3://varchar
                        $command->bindValue(":value", (string)(gettype($field) == 'array' ? $field[$i] : $field), PDO::PARAM_STR);
                        break;
                    case 4://text
                        $command->bindValue(":value", (string)(gettype($field) == 'array' ? $field[$i] : $field), PDO::PARAM_STR);
                        break;
                    case 5://datetime
                        $command->bindValue(":value", strtotime((string)(gettype($field) == 'array' ? $field[$i] : $field)), PDO::PARAM_INT);
                        break;
                    case 6://boolean
                        $command->bindValue(":value", ((string)(gettype($field) == 'array' ? $field[$i] : $field) == 'false') ? false : true, PDO::PARAM_INT);
                        break;
                    case 7://container
                        $command->bindValue(":value", '', PDO::PARAM_STR);
                        break;
                    default:
                        echo "unknown attribute value type:".$eBayEntityAttribute->eBayAttribute->backend_type.". ";
                        continue;
                        break;
                }
                if($parentValueId && isset($parentEntityAttribute))
                {
                    $command->bindValue(":parent_value_id", $parentValueId, PDO::PARAM_INT);
                    $command->bindValue(":parent_value_type", $parentEntityAttribute->eBayAttribute->backend_type, PDO::PARAM_INT);
                    $command->bindValue(":parent_value_entity_attribute_id", $parentEntityAttribute->id, PDO::PARAM_INT);
                }
                else
                {
                    $command->bindValue(":parent_value_id", 0, PDO::PARAM_INT);
                    $command->bindValue(":parent_value_type", 0, PDO::PARAM_INT);
                    $command->bindValue(":parent_value_entity_attribute_id", 0, PDO::PARAM_INT);
                }
                $command->execute();
                $valueId=Yii::app()->db->getLastInsertID();
                //echo(" insert entity value type:{$valueType}, id: ".$valueId.", value: ".(string)(gettype($field) == 'array' ? $field[$i] : $field).". ");
                if(gettype($field) != 'array')  return $valueId;
            }
            else
            {
                break;
            }
        }

        return 0;
    }

    /*
     * generate XML for GetSellerList call
     */
    protected static function GetSellerListXML($params)
    {
        $xml = '';

        if(empty($params)) return $xml;

        if(isset($params['AdminEndedItemsOnly']) && $params['AdminEndedItemsOnly'])
            $xml .= eBayService::createXMLElement('AdminEndedItemsOnly',$params['AdminEndedItemsOnly'] ? "true" : "false");
        if(isset($params['CategoryID']) && $params['CategoryID'])
            $xml .= eBayService::createXMLElement('CategoryID',$params['CategoryID']);
        if(isset($params['EndTimeFrom']) && $params['EndTimeFrom'] && isset($params['EndTimeTo']) && $params['EndTimeTo'])
        {
            $xml .= eBayService::createXMLElement('EndTimeFrom',$params['EndTimeFrom']);
            $xml .= eBayService::createXMLElement('EndTimeTo',$params['EndTimeTo']);
        }
        elseif(isset($params['StartTimeFrom']) && $params['StartTimeFrom'] && isset($params['StartTimeTo']) && $params['StartTimeTo'])
        {
            $xml .= eBayService::createXMLElement('StartTimeFrom',$params['StartTimeFrom']);
            $xml .= eBayService::createXMLElement('StartTimeTo',$params['StartTimeTo']);
        }
        if(isset($params['GranularityLevel']) && $params['GranularityLevel'])
        {
            $xml .= eBayService::createXMLElement('GranularityLevel',$params['GranularityLevel']);
        }
        else
        {
            $xml .= eBayService::createXMLElement('GranularityLevel',eBayGranularityLevelCodeType::Fine);
        }
        if(isset($params['IncludeVariations']) && $params['IncludeVariations'])
        {
            $xml .= eBayService::createXMLElement('IncludeVariations',$params['IncludeVariations']);
        }
        else
        {
            $xml .= eBayService::createXMLElement('IncludeVariations',"true");
        }
        if(isset($params['IncludeWatchCount']) && $params['IncludeWatchCount'])
        {
            $xml .= eBayService::createXMLElement('IncludeWatchCount',$params['IncludeWatchCount']);
        }
        else
        {
            $xml .= eBayService::createXMLElement('IncludeWatchCount',"true");
        }
        if(isset($params['MotorsDealerUsers']) && !empty($params['MotorsDealerUsers']))
        {
            $Users = "";
            foreach($params['MotorsDealerUsers'] as $user)
            {
                $Users .= eBayService::createXMLElement('UserID',$user);
            }
            $xml .= eBayService::createXMLElement('MotorsDealerUsers',$Users);
        }
        if(isset($params['Pagination']) && !empty($params['Pagination']))
        {
            $EntriesPerPage = eBayService::createXMLElement("EntriesPerPage", $params["Pagination"]["EntriesPerPage"]);
            $PageNumber = eBayService::createXMLElement("PageNumber", $params["Pagination"]["PageNumber"]);
            $xml .= eBayService::createXMLElement('Pagination',$EntriesPerPage.$PageNumber);
        }
        else
        {
            $EntriesPerPage = eBayService::createXMLElement("EntriesPerPage", 20);
            $PageNumber = eBayService::createXMLElement("PageNumber", 0);
            $xml .= eBayService::createXMLElement('Pagination',$EntriesPerPage.$PageNumber);
        }
        if(isset($params['SKUArray']) && !empty($params['SKUArray']))
        {
            $skus = "";
            foreach($params['SKUArray'] as $sku)
            {
                $skus .= eBayService::createXMLElement('SKU',$sku);
            }
            $xml .= eBayService::createXMLElement('SKUArray',$skus);
        }
        if(isset($params['Sort']) && $params['Sort'])
        {
            $xml .= eBayService::createXMLElement('Sort',$params['Sort']);
        }
        else
        {
            $xml .= eBayService::createXMLElement('Sort',"0");
        }
        if(isset($params['UserID']) && $params['UserID'])
            $xml .= eBayService::createXMLElement('UserID',$params['UserID']);
        if(isset($params['DetailLevel']) && $params['DetailLevel'])
        {
            $xml .= eBayService::createXMLElement('DetailLevel',$params['DetailLevel']);
        }
        else
        {
            $xml .= eBayService::createXMLElement('DetailLevel',eBayDetailLevelCodeType::ReturnAll);
        }
        if(isset($params['ErrorLanguage']) && $params['ErrorLanguage'])
        {
            $xml .= eBayService::createXMLElement('ErrorLanguage',$params['ErrorLanguage']);
        }
        else
        {
            $xml .= eBayService::createXMLElement('ErrorLanguage',eBayErrorLanguageType::en_US);
        }
        if(isset($params['WarningLevel']) && $params['WarningLevel'])
        {
            $xml .= eBayService::createXMLElement('WarningLevel',$params['WarningLevel']);
        }
        else
        {
            $xml .= eBayService::createXMLElement('WarningLevel',eBayWarningLevelCodeType::Low);
        }
        if(isset($params['Version']) && $params['Version'])
            $xml .= eBayService::createXMLElement('Version',$params['Version']);

        return $xml;
    }

    public static function GetCategories($params=array('CategorySiteID'=>0, 'CategoryParent'=>'', 'LevelLimit'=>4, 'ViewAllNodes'=>true, 'DetailLevel'=>eBayDetailLevelCodeType::ReturnAll))
    {
        $store = Store::model()->findByPk(1);
        if(empty($store))
        {
            echo "fail to get eBay auth token to retrieve categories.\n";
            return false;
        }

        $eBayEntityType = eBayEntityType::model()->find('entity_model=:entity_model', array(':entity_model'=>'eBayCategory'));
        if(empty($eBayEntityType))
        {
            echo "fail to get eBay category entity type.\n";
            return false;
        }

        $eBayAttributeSet = eBayAttributeSet::model()->find(
            'entity_type_id=:entity_type_id and is_active=:is_active',
            array(
                ':entity_type_id'=>$eBayEntityType->id,
                ':is_active'=>true,
            )
        );
        if(empty($eBayAttributeSet))
        {
            echo "fail to get eBay category entity attribute set object.\n";
            return false;
        }

        $eBayService = new eBayService();
        $eBayService->post_data = $eBayService->getRequestAuthHead($store->ebay_token, "GetCategories").eBayTradingAPI::GetCategoriesXML($params).$eBayService->getRequestAuthFoot("GetCategories");
        $eBayService->api_url = $store->eBayApiKey->api_url;
        $eBayService->createHTTPHead(($params['CategorySiteID'] == eBaySiteIdCodeType::eBayMotors ? 0 : $params['CategorySiteID']), $store->eBayApiKey->compatibility_level, $store->eBayApiKey->dev_id, $store->eBayApiKey->app_id, $store->eBayApiKey->cert_id, "GetCategories");
        echo "start to fetch eBay categories for site: {$params['CategorySiteID']}.\n";
        try
        {
            $result = $eBayService->request();
            if(empty($result) || !$result)
            {
                echo "fail to call eBay API, result is false.\n";
                return false;
            }
            else
            {
                if((string)$result->Ack===eBayAckCodeType::Success)
                {
                    $CategoryArray = (array)$result->CategoryArray;
                    if(gettype($CategoryArray['Category']) == 'array')
                    {
                        foreach($CategoryArray['Category'] as $category)
                            eBayTradingAPI::processeBayCategory($params['CategorySiteID'], $category, $eBayEntityType, $eBayAttributeSet);
                    }
                    elseif(gettype($CategoryArray['Category']) == 'object')
                    {
                        eBayTradingAPI::processeBayCategory($params['CategorySiteID'], $CategoryArray['Category'], $eBayEntityType, $eBayAttributeSet);
                    }
                }
                else
                {
                    $Version = (string)$result->Version;
                    $Timestamp = (string)$result->Timestamp;
                    $Errors = array(
                        'ErrorClassification'=>(string)$result->Errors->ErrorClassification,
                        'ErrorCode'=>(string)$result->Errors->ErrorCode,
                        'ShortMessage'=>(string)$result->Errors->ShortMessage,
                        'LongMessage'=>(string)$result->Errors->LongMessage,
                        'SeverityCode'=>(string)$result->Errors->SeverityCode,
                    );
                    var_dump($Version, $Timestamp, $Errors, $result);
                    echo "eBay API call returned error.\n";
                    return false;
                }
                echo "finish to fetch eBay categories for site: {$params['CategorySiteID']}.!\n\n";
            }
        }
        catch(Exception $ex)
        {
            var_dump($ex);
            return false;
        }

        return true;
    }

    protected static function processeBayCategory($site_id=null, $category=null, $eBayEntityType=null, $eBayAttributeSet=null)
    {
        if(!isset($site_id) || empty($category) || empty($eBayEntityType) || empty($eBayAttributeSet)) return false;

        $transaction = NULL;
        try
        {
            $category = (array)$category;
            $transaction= Yii::app()->db->beginTransaction();
            $eBayCategory = eBayCategory::model()->find(
                'CategoryID=:CategoryID and CategorySiteID=:CategorySiteID',
                array(
                    ':CategoryID'=>(string)$category['CategoryID'],
                    ':CategorySiteID'=>$site_id,
                )
            );

            if(empty($eBayCategory))
            {
                $eBayCategory = new eBayCategory();
                $eBayCategory->create_time_utc = time();
            }

            echo "category id: {$category['CategoryID']}, name: {$category['CategoryName']}. ";
            if(isset($category['AutoPayEnabled'])) $eBayCategory->AutoPayEnabled = (string)$category['AutoPayEnabled'] == 'true' ? 1 : 0;
            if(isset($category['B2BVATEnabled'])) $eBayCategory->B2BVATEnabled = (string)$category['B2BVATEnabled'] == 'true' ? 1 : 0;
            if(isset($category['BestOfferEnabled'])) $eBayCategory->BestOfferEnabled = (string)$category['BestOfferEnabled'] == 'true' ? 1 : 0;
            if(isset($category['CategoryID'])) $eBayCategory->CategoryID = (string)$category['CategoryID'];

            if(isset($category['CategoryLevel'])) $eBayCategory->CategoryLevel = (int)$category['CategoryLevel'];
            if(isset($category['CategoryName'])) $eBayCategory->CategoryName = (string)$category['CategoryName'];
            if(isset($category['CategoryParentID'])) $eBayCategory->CategoryParentID = (string)$category['CategoryParentID'];
            if(isset($category['Expired'])) $eBayCategory->Expired = (string)$category['Expired'] == 'true' ? 1 : 0;
            if(isset($category['LeafCategory'])) $eBayCategory->LeafCategory = (string)$category['LeafCategory'] == 'true' ? 1 : 0;
            if(isset($category['LSD'])) $eBayCategory->LSD = (string)$category['LSD'] == 'true' ? 1 : 0;
            if(isset($category['ORPA'])) $eBayCategory->ORPA = (string)$category['ORPA'] == 'true' ? 1 : 0;
            if(isset($category['ORRA'])) $eBayCategory->ORRA = (string)$category['ORRA'] == 'true' ? 1 : 0;
            if(isset($category['Virtual'])) $eBayCategory->Virtual = (string)$category['Virtual'] == 'true' ? 1 : 0;
            $eBayCategory->ebay_entity_type_id=$eBayEntityType->id;
            $eBayCategory->ebay_attribute_set_id=$eBayAttributeSet->id;
            $eBayCategory->CategorySiteID = $site_id;
            $eBayCategory->update_time_utc = time();
            if($eBayCategory->save())
            {
                echo "done!\n";
                $transaction->commit();
            }
            else
            {
                echo "failed.\n";
                $transaction->rollback();
            }
        }
        catch(Exception $ex)
        {
            if(isset($transaction)) $transaction->rollback();
            echo("Exception code: ".$ex->getCode().", ".$ex->getMessage());
            return false;
        }

        return true;
    }

    /*
     * generate XML for GetCategories call
     */
    protected static function GetCategoriesXML($params=array('CategorySiteID'=>0, 'CategoryParent'=>'', 'LevelLimit'=>0, 'ViewAllNodes'=>true, 'DetailLevel'=>eBayDetailLevelCodeType::ReturnAll))
    {
        $xml = "";
        if(!isset($params['CategorySiteID'])) $params['CategorySiteID'] = 0;
        $xml .= eBayService::createXMLElement('CategorySiteID',$params['CategorySiteID']);
        if(!isset($params['ViewAllNodes'])) $params['ViewAllNodes'] = true;
        $xml .= eBayService::createXMLElement('ViewAllNodes',($params['ViewAllNodes'] ? 'true' : 'false'));
        if(!isset($params['LevelLimit'])) $params['LevelLimit'] = 4;
        $xml .= eBayService::createXMLElement('LevelLimit',$params['LevelLimit']);
        if(!isset($params['DetailLevel'])) $params['DetailLevel'] = eBayDetailLevelCodeType::ReturnAll;
        $xml .= eBayService::createXMLElement('DetailLevel',$params['DetailLevel']);

        return $xml;
    }

    public static function ReviseListing($params=array('applied_listings'=>array(), 'update_rules'=>array()), $VerifyOnly=true)
    {
        if(empty($params) || empty($params['applied_listings']) || empty($params['update_rules']))
            throw new Exception(ExceptionError::getExceptionErrorText(ExceptionError::NonInputErrorCode), ExceptionError::NonInputErrorCode);

        $resultStatus = array(
            'Total'=>0,
            eBayAckCodeType::Success=>array(),
            eBayAckCodeType::Warning=>array(),
            eBayAckCodeType::Failure=>array(),
            'UnknownStatus'=>array(),
            'params'=>$params,
        );
        foreach($params['applied_listings'] as $listingId)
        {
            $resultStatus['Total']++;
            try
            {
                $eBayListing = eBayListing::model()->findByAttributes(array('ebay_listing_id'=>$listingId, 'company_id'=>$params['company_id']));
                if(empty($eBayListing))
                {
                    $resultStatus['Failure'][$listingId]=array(
                        'listingId'=>$listingId,
                        'Status'=>'Failure',
                        'Msg'=>array('Can not find eBay Listing!'),
                    );
                    continue;
                }

                $input = array('ItemID'=>$listingId);

                //update description
                if(!empty($params['update_rules']['description']))
                {
                    //update item description if needed
                    eBayTradingAPI::GetItem($eBayListing);

                    if($params['update_rules']['description']['action'] == 'add')
                    {
                        $input['Description'] = eBayService::createXMLElement($params['update_rules']['description']['tag'],$params['update_rules']['description']['value']);
                        $input['DescriptionReviseMode'] = $params['update_rules']['description']['position'] == 'prepend' ? eBayDescriptionReviseMode::Prepend : eBayDescriptionReviseMode::Append;
                    }
                    else
                    {
                        $input['Description'] = preg_replace("/<{$params['update_rules']['description']['tag']}(.*?)>(.*?)<\/{$params['update_rules']['description']['tag']}>/msi", "", $eBayListing->getEntityAttributeValue('Description'));
                        $input['DescriptionReviseMode'] = eBayDescriptionReviseMode::Replace;
                    }
                }

                //update exclude ship locations
                if(!empty($params['update_rules']['excludeShipLocation']))
                {
                    $input['ExcludeShipToLocation'] = $params['update_rules']['excludeShipLocation'];
                }

                $Variations = $eBayListing->getEntityAttributeValueByCodeWithAllChildren('Variations');
                if(isset($params['update_rules']['quantity']) || isset($params['update_rules']['price']))
                {
                    if(isset($Variations) && !empty($Variations))
                    {
                        $input['Variations'] = array();
                        foreach($Variations['Variation'] as $Variation)
                        {
                            if(!isset($Variation["SKU"]) || !isset($Variation['StartPrice']) || !isset($Variation['StartPrice']["Value"])) continue;
                            $temp = array();
                            $temp['SKU'] = $Variation["SKU"];
                            if(isset($params['update_rules']['quantity']) && !empty($params['update_rules']['quantity']))
                            {
                                $temp['Quantity'] = $params['update_rules']['quantity'];
                            }
                            if(isset($params['update_rules']['price']) && !empty($params['update_rules']['price']))
                            {
                                switch($params['update_rules']['price']['action'])
                                {
                                    case 'Set':
                                        if($params['update_rules']['price']['type'] == 'amount') $temp['StartPrice'] = $params['update_rules']['price']['value'];
                                        else
                                            $temp['StartPrice'] = $Variation['StartPrice']["Value"] * $params['update_rules']['price']['value'] / 100;
                                        break;
                                    case 'plus':
                                        if($params['update_rules']['price']['type'] == 'amount') $temp['StartPrice'] = $Variation['StartPrice']["Value"] + $params['update_rules']['price']['value'];
                                        else
                                            $temp['StartPrice'] = $Variation['StartPrice']["Value"] * (100 + $params['update_rules']['price']['value']) / 100;
                                        break;
                                    case 'minus':
                                        if($params['update_rules']['price']['type'] == 'amount') $temp['StartPrice'] = $Variation['StartPrice']["Value"] - $params['update_rules']['price']['value'];
                                        else
                                            $temp['StartPrice'] = $Variation['StartPrice']["Value"] * (100 - $params['update_rules']['price']['value']) / 100;
                                        break;
                                    case 'times':
                                        if($params['update_rules']['price']['type'] == 'amount') $temp['StartPrice'] = $Variation['StartPrice']["Value"] * $params['update_rules']['price']['value'];
                                        else
                                            $temp['StartPrice'] = $Variation['StartPrice']["Value"] * $params['update_rules']['price']['value'] / 100;
                                        break;
                                    case 'divide':
                                        if($params['update_rules']['price']['type'] == 'amount') $temp['StartPrice'] = $Variation['StartPrice']["Value"] / $params['update_rules']['price']['value'];
                                        else
                                            $temp['StartPrice'] = $Variation['StartPrice']["Value"] / $params['update_rules']['price']['value'] / 100;
                                        break;
                                }
                            }

                            $input['Variations'][] = $temp;
                        }
                        $result = eBayTradingAPI::ReviseFixedPriceItem($eBayListing, $input, $VerifyOnly);
                        $resultStatus[$result['Status']][$listingId] = $result;
                    }
                    else
                    {
                        $StartPrice = null;
                        if(isset($params['update_rules']['price']['reference'])) $StartPrice = $params['update_rules']['price']['reference'];
                        else
                            $StartPrice = $eBayListing->getEntityAttributeValue('StartPrice->Value');

                        if(!isset($StartPrice))
                        {
                            $resultStatus['Failure'][$listingId] = array('listingId' => $listingId, 'Status' => 'Failure', 'Msg' => array('Can not find eBay Listing detail values!'),);
                            continue;
                        }

                        //set price update rule
                        if(isset($params['update_rules']['price']) && !empty($params['update_rules']['price']))
                        {
                            switch($params['update_rules']['price']['action'])
                            {
                                case 'Set':
                                    if($params['update_rules']['price']['type'] == 'amount') $input['StartPrice'] = $params['update_rules']['price']['value'];
                                    else
                                        $input['StartPrice'] = $StartPrice * $params['update_rules']['price']['value'] / 100;
                                    break;
                                case 'plus':
                                    if($params['update_rules']['price']['type'] == 'amount') $input['StartPrice'] = $StartPrice + $params['update_rules']['price']['value'];
                                    else
                                        $input['StartPrice'] = $StartPrice * (100 + $params['update_rules']['price']['value']) / 100;
                                    break;
                                case 'minus':
                                    if($params['update_rules']['price']['type'] == 'amount') $input['StartPrice'] = $StartPrice - $params['update_rules']['price']['value'];
                                    else
                                        $input['StartPrice'] = $StartPrice * (100 - $params['update_rules']['price']['value']) / 100;
                                    break;
                                case 'times':
                                    if($params['update_rules']['price']['type'] == 'amount') $input['StartPrice'] = $StartPrice * $params['update_rules']['price']['value'];
                                    else
                                        $input['StartPrice'] = $StartPrice * $params['update_rules']['price']['value'] / 100;
                                    break;
                                case 'divide':
                                    if($params['update_rules']['price']['type'] == 'amount') $input['StartPrice'] = $StartPrice / $params['update_rules']['price']['value'];
                                    else
                                        $input['StartPrice'] = $StartPrice / $params['update_rules']['price']['value'] / 100;
                                    break;
                            }
                        }

                        //set quantity update rule
                        if(isset($params['update_rules']['quantity']) && !empty($params['update_rules']['quantity']))
                        {
                            $input['Quantity'] = $params['update_rules']['quantity'];
                        }

                        $result = eBayTradingAPI::ReviseItem($eBayListing, $input, $VerifyOnly);
                        $resultStatus[$result['Status']][$listingId] = $result;
                    }
                }
                else
                {
                    if(isset($Variations) && !empty($Variations))
                    {
                        $result = eBayTradingAPI::ReviseFixedPriceItem($eBayListing, $input, $VerifyOnly);
                        $resultStatus[$result['Status']][$listingId] = $result;
                    }
                    else
                    {
                        $result = eBayTradingAPI::ReviseItem($eBayListing, $input, $VerifyOnly);
                        $resultStatus[$result['Status']][$listingId] = $result;
                    }
                }
            }
            catch(Exception $ex)
            {
                $resultStatus[eBayAckCodeType::Failure][$listingId]=array(
                    'listingId'=>$listingId,
                    'Status'=>'Failure',
                    'Msg'=>array(sprintf("Excpetion happened, code: %s, type: %s, message: %s", $ex->getCode(), gettype($ex), $ex->getMessage())),
                );
            }
        }

        return $resultStatus;
    }

    protected static function ReviseFixedPriceItem($eBayListing=null, $params=NULL, $verifyOnly=false)
    {
        if(!isset($params) || !isset($eBayListing)) return false;
        $params['VerifyOnly'] = $verifyOnly;

        $eBayService = new eBayService();
        $eBayService->post_data = $eBayService->getRequestAuthHead($eBayListing->Store->ebay_token, "ReviseFixedPriceItem").self::ReviseFixedPriceItemXML($params, $eBayListing).$eBayService->getRequestAuthFoot("ReviseFixedPriceItem");
        $eBayService->api_url = $eBayListing->Store->eBayApiKey->api_url;
        $eBayService->createHTTPHead($eBayListing->site_id, $eBayListing->Store->eBayApiKey->compatibility_level, $eBayListing->Store->eBayApiKey->dev_id, $eBayListing->Store->eBayApiKey->app_id, $eBayListing->Store->eBayApiKey->cert_id, "ReviseFixedPriceItem");

        $result = $eBayService->request();
        if(empty($result)) return array(
            'listingId'=>$eBayListing->ebay_listing_id,
            'Status'=>eBayAckCodeType::Failure,
            'Msg'=>array('Fail to call eBay API.'),
        );

        if((string)$result->Ack===eBayAckCodeType::Success)
        {
            $msg = array(
                'listingId'=>$eBayListing->ebay_listing_id,
                'Status'=>eBayAckCodeType::Success,
                'Msg'=>array(),
            );
            $fees = (array)$result->Fees;
            foreach($fees['Fee'] as $fee)
            {
                if((double)$fee->Fee > 0)
                    $msg['Msg'][] = sprintf("Fee: %s, Amount: %2\$.2f", (string)$fee->Name, (double)$fee->Fee);
            }
        }
        elseif((string)$result->Ack===eBayAckCodeType::Warning)
        {
            $msg = array(
                'listingId'=>$eBayListing->ebay_listing_id,
                'Status'=>eBayAckCodeType::Warning,
                'Msg'=>array(),
            );
            $temp = (array)$result;
            if(gettype($temp["Errors"]) == 'array')
            {
                foreach($temp["Errors"] as $error)
                {
                    $msg['Msg'][] = "Warning: ".(string)$error->ShortMessage;
                }
            }
            else
            {
                $msg['Msg'][] = "Warning: ".(string)$temp["Errors"]->ShortMessage;
            }
            $fees = (array)$result->Fees;
            foreach($fees['Fee'] as $fee)
            {
                if((double)$fee->Fee > 0)
                    $msg['Msg'][] = sprintf("Fee: %s, Amount: %2\$.2f", (string)$fee->Name, (double)$fee->Fee);
            }
        }
        elseif((string)$result->Ack===eBayAckCodeType::Failure || (string)$result->Ack===eBayAckCodeType::PartialFailure)
        {
            $msg = array(
                'listingId'=>$eBayListing->ebay_listing_id,
                'Status'=>eBayAckCodeType::Failure,
                'Msg'=>array(),
            );
            $temp = (array)$result;
            if(gettype($temp["Errors"]) == 'array')
            {
                foreach($temp["Errors"] as $error)
                {
                    $msg['Msg'][] = "Error: ".(string)$error->ShortMessage;
                }
            }
            else
            {
                $msg['Msg'][] = "Error: ".(string)$temp["Errors"]->ShortMessage;
            }
        }
        else
        {
            $msg = array(
                'listingId'=>$eBayListing->ebay_listing_id,
                'Status'=>'UnknownStatus',
                'Msg'=>array('Return Status: '.(string)$result->Ack),
            );
        }

        return $msg;
    }

    protected static function ReviseFixedPriceItemXML($params=array(), $eBayListing=null)
    {
        if(empty($params)) return false;
        $xml = "";
        $xml .= eBayService::createXMLElement('ItemID',$params['ItemID']);
        $VariationXML = "";
        if(isset($params['Variations']))
        {
            foreach($params['Variations'] as $variation)
            {
                $temp = eBayService::createXMLElement('SKU', $variation['SKU']);
                if(isset($variation['StartPrice'])) $temp .= eBayService::createXMLElement('StartPrice', $variation['StartPrice']);
                if(isset($variation['Quantity'])) $temp .= eBayService::createXMLElement('Quantity', $variation['Quantity']);
                $VariationXML .= eBayService::createXMLElement('Variation', $temp);
            }
            $xml .= eBayService::createXMLElement('Variations', $VariationXML);
        }
        if(isset($params['Description']) && isset($params['DescriptionReviseMode']))
        {
            $xml .= eBayService::createXMLElement('Description', "<![CDATA[".$params['Description']."]]>");
            $xml .= eBayService::createXMLElement('DescriptionReviseMode', $params['DescriptionReviseMode']);
        }
        if(isset($params['ExcludeShipToLocation']))
        {
            if(!isset($eBayListing) || empty($eBayListing))
                $eBayListing = eBayListing::model()->find("ebay_listing_id=:ebay_listing_id", array(":ebay_listing_id"=>$params['ItemID']));
            if(isset($eBayListing) && !empty($eBayListing))
            {
                $ShippingDetails = $eBayListing->getEntityAttributeValueByCodeWithAllChildren("ShippingDetails");
                if(!empty($ShippingDetails))
                {
                    $ShippingDetails['ExcludeShipToLocation'] = $params['ExcludeShipToLocation'];
                    $xml .= self::createXMLElementByValueRC("", "ShippingDetails", $ShippingDetails);
                }
            }
        }

        $xml = eBayService::createXMLElement('Item',$xml);
        //standard input
        $xml .= eBayService::createXMLElement('VerifyOnly',$params['VerifyOnly'] ? 'true' : 'false');
        $xml .= eBayService::createXMLElement('ErrorLanguage',eBayErrorLanguageType::en_US);
        $xml .= eBayService::createXMLElement('WarningLevel',eBayWarningLevelCodeType::High);
        return $xml;
    }

    protected static function ReviseItem($eBayListing=null, $params=NULL, $verifyOnly=false)
    {
        if(!isset($params) || !isset($eBayListing)) return false;
        $params['VerifyOnly'] = $verifyOnly;

        $eBayService = new eBayService();
        $eBayService->post_data = $eBayService->getRequestAuthHead($eBayListing->Store->ebay_token, "ReviseItem").self::ReviseItemXML($params, $eBayListing).$eBayService->getRequestAuthFoot("ReviseItem");
        $eBayService->api_url = $eBayListing->Store->eBayApiKey->api_url;
        $eBayService->createHTTPHead($eBayListing->site_id, $eBayListing->Store->eBayApiKey->compatibility_level, $eBayListing->Store->eBayApiKey->dev_id, $eBayListing->Store->eBayApiKey->app_id, $eBayListing->Store->eBayApiKey->cert_id, "ReviseItem");

        $result = $eBayService->request();
        if(empty($result)) return array(
            'listingId'=>$eBayListing->ebay_listing_id,
            'Status'=>eBayAckCodeType::Failure,
            'Msg'=>array('Fail to call eBay API.'),
        );

        if((string)$result->Ack===eBayAckCodeType::Success)
        {
            $msg = array(
                'listingId'=>$eBayListing->ebay_listing_id,
                'Status'=>eBayAckCodeType::Success,
                'Msg'=>array(),
            );
            $fees = (array)$result->Fees;
            foreach($fees['Fee'] as $fee)
            {
                if((double)$fee->Fee > 0)
                    $msg['Msg'][] = sprintf("Fee: %s, Amount: %2\$.2f", (string)$fee->Name, (double)$fee->Fee);
            }
        }
        elseif((string)$result->Ack===eBayAckCodeType::Warning)
        {
            $msg = array(
                'listingId'=>$eBayListing->ebay_listing_id,
                'Status'=>eBayAckCodeType::Warning,
                'Msg'=>array(),
            );
            $temp = (array)$result;
            if(gettype($temp["Errors"]) == 'array')
            {
                foreach($temp["Errors"] as $error)
                {
                    $msg['Msg'][] = "Warning: ".(string)$error->ShortMessage;
                }
            }
            else
            {
                $msg['Msg'][] = "Warning: ".(string)$temp["Errors"]->ShortMessage;
            }
            $fees = (array)$result->Fees;
            foreach($fees['Fee'] as $fee)
            {
                if((double)$fee->Fee > 0)
                    $msg['Msg'][] = sprintf("Fee: %s, Amount: %2\$.2f", (string)$fee->Name, (double)$fee->Fee);
            }
        }
        elseif((string)$result->Ack===eBayAckCodeType::Failure || (string)$result->Ack===eBayAckCodeType::PartialFailure)
        {
            $msg = array(
                'listingId'=>$eBayListing->ebay_listing_id,
                'Status'=>eBayAckCodeType::Failure,
                'Msg'=>array(),
            );
            $temp = (array)$result;
            if(gettype($temp["Errors"]) == 'array')
            {
                foreach($temp["Errors"] as $error)
                {
                    $msg['Msg'][] = "Error: ".(string)$error->ShortMessage;
                }
            }
            else
            {
                $msg['Msg'][] = "Error: ".(string)$temp["Errors"]->ShortMessage;
            }
        }
        else
        {
            $msg = array(
                'listingId'=>$eBayListing->ebay_listing_id,
                'Status'=>'UnknownStatus',
                'Msg'=>array('Return Status: '.(string)$result->Ack),
            );
        }

        return $msg;
    }

    protected static function ReviseItemXML($params=array(), $eBayListing=null)
    {
        if(empty($params)) return false;
        $xml = "";
        $xml .= eBayService::createXMLElement('ItemID',$params['ItemID']);
        if(isset($params['StartPrice'])) $xml .= eBayService::createXMLElement('StartPrice',$params['StartPrice']);
        if(isset($params['Quantity'])) $xml .= eBayService::createXMLElement('Quantity',$params['Quantity']);
        if(isset($params['Description']) && isset($params['DescriptionReviseMode']))
        {
            $xml .= eBayService::createXMLElement('Description', "<![CDATA[".$params['Description']."]]>");
            $xml .= eBayService::createXMLElement('DescriptionReviseMode', $params['DescriptionReviseMode']);
        }
        if(isset($params['ExcludeShipToLocation']))
        {
            if(!isset($eBayListing) || empty($eBayListing))
                $eBayListing = eBayListing::model()->find("ebay_listing_id=:ebay_listing_id", array(":ebay_listing_id"=>$params['ItemID']));
            if(isset($eBayListing) && !empty($eBayListing))
            {
                $ShippingDetails = $eBayListing->getEntityAttributeValueByCodeWithAllChildren("ShippingDetails");
                if(!empty($ShippingDetails))
                {
                    $ShippingDetails['ExcludeShipToLocation'] = $params['ExcludeShipToLocation'];
                    $xml .= self::createXMLElementByValueRC("", "ShippingDetails", $ShippingDetails);
                }
            }
        }
        $xml = eBayService::createXMLElement('Item',$xml);

        $xml .= eBayService::createXMLElement('VerifyOnly',$params['VerifyOnly'] ? 'true' : 'false');
        $xml .= eBayService::createXMLElement('ErrorLanguage',eBayErrorLanguageType::en_US);
        $xml .= eBayService::createXMLElement('WarningLevel',eBayWarningLevelCodeType::High);

        return $xml;
    }

    protected static function createXMLElementByValueRC($xml, $key, $value)
    {
        if(is_array($value) && array_key_exists("currencyID", $value))
        {
            $xml .= "<$key currencyID=\"" . $value['currencyID'] . "\">" . sprintf("%1\$.2f", $value['Value']) . "</$key>";
        }
        else if(is_array($value) && (array_key_exists("measurementSystem", $value) || array_key_exists("unit", $value)))
        {
            $xml .= "<$key ".(array_key_exists("measurementSystem", $value) ? "measurementSystem=\"".$value['measurementSystem']."\"" : '')." ".(array_key_exists("unit", $value) ? "unit=\"".$value['unit']."\"" : '').">" . $value['Value'] . "</$key>";
        }
        else if(is_array($value) && count(array_intersect_key($value,range(0,count($value)-1))) == count($value))
        {
            foreach($value as $val)
            {
                $xml = self::createXMLElementByValueRC($xml, $key, $val);
            }
        }
        else
        {
            $xml .= "<" . $key . ">";
            if(is_array($value))
            {
                foreach($value as $index => $val)
                {
                    $xml = self::createXMLElementByValueRC($xml, $index, $val);
                }
            }
            else
            {
                $xml .= $value;
            }
            $xml .= "</" . $key . ">";
        }

        return $xml;
    }

    public static function GetItem($eBayListing=null)
    {
        if(!isset($eBayListing) || empty($eBayListing)) return false;
        $params=array('ItemID'=>$eBayListing->ebay_listing_id, 'DetailLevel'=>eBayDetailLevelCodeType::ReturnAll);

        $store = Store::model()->findByPk($eBayListing->store_id);
        if(empty($store)) return false;

        $eBayEntityType = eBayEntityType::model()->find('entity_model=:entity_model', array(':entity_model'=>'eBayListing'));
        if(empty($eBayEntityType)) return false;

        $eBayAttributeSet = eBayAttributeSet::model()->find(
            'entity_type_id=:entity_type_id and is_active=:is_active',
            array(
                ':entity_type_id'=>$eBayEntityType->id,
                ':is_active'=>eBayAttributeSet::ACTIVE_YES,
            )
        );
        if(empty($eBayAttributeSet)) return false;

        $eBayService = new eBayService();
        $eBayService->post_data = $eBayService->getRequestAuthHead($eBayListing->Store->ebay_token, "GetItem").self::GetItemXML($params).$eBayService->getRequestAuthFoot("GetItem");
        $eBayService->api_url = $eBayListing->Store->eBayApiKey->api_url;
        $eBayService->createHTTPHead($eBayListing->site_id, $eBayListing->Store->eBayApiKey->compatibility_level, $eBayListing->Store->eBayApiKey->dev_id, $eBayListing->Store->eBayApiKey->app_id, $eBayListing->Store->eBayApiKey->cert_id, "GetItem");

        try
        {
            $result = $eBayService->request();

            if(empty($result) || !$result)
            {
                echo "eBay service call failed!\n";
                return false;
            }

            if((string)$result->Ack===eBayAckCodeType::Success)
            {
                $transaction = null;
                try
                {
                    $item = $result->Item;

                    $transaction= Yii::app()->db->beginTransaction();
                    $eBayListing->site_id = eBaySiteName::geteBaySiteNameCode((string)$item->Site);
                    if($eBayListing->isNewRecord)
                    {
                        $eBayListing->create_time_utc = time();
                        $eBayListing->update_time_utc = time();
                        $eBayListing->create_user_id = 0;
                        $eBayListing->update_user_id = 0;
                    }
                    else
                    {
                        $eBayListing->update_time_utc = time();
                        $eBayListing->update_user_id = 0;
                    }
                    $eBayListing->save();
                    $transaction->commit();

                    $transaction= Yii::app()->db->beginTransaction();
                    //clear all item's attribute value record
                    self::clearAlleBayEntityAttributeValue($eBayListing);
                    echo "all attribute value have been cleared.\n";

                    //start to process attribute by attribute
                    echo("start to process eBay item ".(string)$item->ItemID." attribute:\n");
                    eBayTradingAPI::processeBayEntityAttributesRC($eBayListing, $eBayAttributeSet, $item);
                    $transaction->commit();
                    echo("eBay item: ".(string)$item->ItemID." attribute process finished!\n".date("Y-m-d H:i:s", time())."item process finished\n\n");
                    return true;
                }
                catch(Exception $ex)
                {
                    if(isset($transaction)) $transaction->rollback();
                    echo("eBay item: ".(string)$item->ItemID." attribute process failed!\n".date("Y-m-d H:i:s", time())."{$ex->getCode()} {$ex->getmessage()}\nitem process terminated!\n\n");
                    return false;
                }
            }
            else
            {
                var_dump($result);
                return false;
            }
        }
        catch(Exception $ex)
        {
            echo "Exception detected, code: ".$ex->getCode().", msg: ".$ex->getMessage()."\n";
            return false;
        }
    }

    protected static function GetItemXML($params=array())
    {
        if(empty($params)) return false;
        $xml = "";
        if(isset($params['ItemID'])) $xml .= eBayService::createXMLElement('ItemID',$params['ItemID']);
        if(!isset($params['DetailLevel'])) $params['DetailLevel'] = eBayDetailLevelCodeType::ReturnAll;
        $xml .= eBayService::createXMLElement('DetailLevel',$params['DetailLevel']);

        return $xml;
    }

    public static function GetSessionID($eBayAPIKeyId=0)
    {
        if(!$eBayAPIKeyId) return false;

        $eBayAPIKeyId = eBayApiKey::model()->findByPk($eBayAPIKeyId);
        if(empty($eBayAPIKeyId)) return false;

        $eBayService = new eBayService();
        $eBayService->post_data = $eBayService->getRequestAuthHead(NULL, "GetSessionID").self::GetSessionIDXML($eBayAPIKeyId->runame).$eBayService->getRequestAuthFoot("GetSessionID");
        $eBayService->api_url = $eBayAPIKeyId->api_url;
        $eBayService->createHTTPHead(eBaySiteIdCodeType::US, 893, $eBayAPIKeyId->dev_id, $eBayAPIKeyId->app_id, $eBayAPIKeyId->cert_id, "GetSessionID");

        try
        {
            $result = $eBayService->request();
            if(empty($result)) return false;
            if((string)$result->Ack===eBayAckCodeType::Success)
            {
                return (string)$result->SessionID;
            }
            else
            {
                return false;
            }
        }
        catch(Exception $ex)
        {
            return false;
        }
    }

    protected static function GetSessionIDXML($RuName="")
    {
        if(!$RuName) return false;
        $xml = "";
        $xml .= eBayService::createXMLElement('RuName',$RuName);

        return $xml;
    }

    public static function FetchToken($store=null)
    {
        if(!isset($store) || empty($store)) return false;
        $sessionId = Yii::app()->session['store_'.$store->id.'_ebay_session_id'];
        if(!isset($sessionId) || empty($sessionId)) return false;

        $eBayService = new eBayService();
        $eBayService->post_data = $eBayService->getRequestAuthHeadAPIKey($store->eBayApiKey->dev_id, $store->eBayApiKey->app_id, $store->eBayApiKey->cert_id, "FetchToken").self::FetchTokenXML($sessionId).$eBayService->getRequestAuthFoot("FetchToken");
        $eBayService->api_url = $store->eBayApiKey->api_url;
        $eBayService->createHTTPHead(eBaySiteIdCodeType::US, 899, $store->eBayApiKey->dev_id, $store->eBayApiKey->app_id, $store->eBayApiKey->cert_id, "FetchToken");

        try
        {
            $result = $eBayService->request();
            if(empty($result)) return false;
            if((string)$result->Ack===eBayAckCodeType::Success)
            {
                return array('eBayAuthToken'=>(string)$result->eBayAuthToken, 'HardExpirationTime'=>(string)$result->HardExpirationTime);
            }
            else
            {
                return false;
            }
        }
        catch(Exception $ex)
        {
            return false;
        }
    }

    protected static function FetchTokenXML($sessionId="")
    {
        if(empty($sessionId)) return false;
        $xml = "";
        $xml .= eBayService::createXMLElement('SessionID',$sessionId);

        return $xml;
    }

    public static function GeteBayDetails($siteId=eBaySiteIdCodeType::US, $eBayAPIKeyId=2)
    {
        $eBayAPIKeyId = eBayApiKey::model()->findByPk($eBayAPIKeyId);
        if(empty($eBayAPIKeyId))
        {
            echo "eBay API key does not found!\n";
            return false;
        }

        $store = Store::model()->find("ebay_api_key_id=:ebay_api_key_id", array(':ebay_api_key_id'=>$eBayAPIKeyId->id));
        if(empty($store) || $store->is_active != Store::ACTIVE_YES || empty($store->ebay_token))
        {
            echo "store does not found!\n";
            return false;
        }

        $eBayService = new eBayService();
        $eBayService->post_data = $eBayService->getRequestAuthHead($store->ebay_token, "GeteBayDetails").self::GeteBayDetailsXML().$eBayService->getRequestAuthFoot("GeteBayDetails");
        $eBayService->api_url = $eBayAPIKeyId->api_url;
        $eBayService->createHTTPHead($siteId, 893, $eBayAPIKeyId->dev_id, $eBayAPIKeyId->app_id, $eBayAPIKeyId->cert_id, "GeteBayDetails");

        try
        {
            $result = $eBayService->request();
            if(empty($result) || !$result)
            {
                echo "eBay service call failed!\n";
                return false;
            }

            if((string)$result->Ack===eBayAckCodeType::Success)
            {
                $transaction=NULL;
                try
                {
                    $transaction= Yii::app()->db->beginTransaction();
                    $eBayEntityType = eBayEntityType::model()->find('entity_model=:entity_model', array(':entity_model'=>'eBayDetail'));
                    if(empty($eBayEntityType))
                    {
                        echo "eBay entity type for eBay detail does not found!\n";
                        return false;
                    }

                    $eBayAttributeSet = eBayAttributeSet::model()->find(
                        'entity_type_id=:entity_type_id and is_active=:is_active',
                        array(
                            ':entity_type_id'=>$eBayEntityType->id,
                            ':is_active'=>true,
                        )
                    );
                    if(empty($eBayAttributeSet))
                    {
                        echo "eBay Attribute Set for eBay detail does not found!\n";
                        return false;
                    }

                    $eBayDetail = eBayDetail::model()->find("site_id=:site_id", array(":site_id"=>$siteId));
                    if(empty($eBayDetail))
                    {
                        $eBayDetail = new eBayDetail();
                        $eBayDetail->name = "eBay Detail of Site ".eBaySiteIdCodeType::getSiteIdCodeTypeText($siteId);
                        $eBayDetail->site_id = $siteId;
                        $eBayDetail->ebay_entity_type_id = $eBayEntityType->id;
                        $eBayDetail->ebay_attribute_set_id = $eBayAttributeSet->id;
                        if(!$eBayDetail->save(false))
                        {
                            echo "fail to save eBay detail entity.\n";
                            if(isset($transaction)) $transaction->rollback();
                            return false;
                        }
                    }
                    else
                    {
                        $eBayDetail->save(false);
                    }
                    //clear all item's attribute value record
                    self::clearAlleBayEntityAttributeValue($eBayDetail);
                    echo "all attribute value have been cleared.\n";
                    $transaction->commit();$transaction=null;

                    $transaction= Yii::app()->db->beginTransaction();
                    echo("start to process eBay detail for site ".$siteId." attribute:\n");
                    eBayTradingAPI::processeBayEntityAttributesRC($eBayDetail, $eBayAttributeSet, (array)$result);
                    $transaction->commit();
                    echo("eBay detail for site ".$siteId." attribute process finished!\n".date("Y-m-d H:i:s", time())."item process finished\n\n");
                    return true;
                }
                catch(Exception $ex)
                {
                    if(isset($transaction)) $transaction->rollback();
                    echo "Exception detected, code: ".$ex->getCode().", msg: ".$ex->getMessage()."\n";
                    return false;
                }
            }
            else
            {
                var_dump($result);
                return false;
            }
        }
        catch(Exception $ex)
        {
            echo "Exception detected, code: ".$ex->getCode().", msg: ".$ex->getMessage()."\n";
            return false;
        }
    }

    protected static function GeteBayDetailsXML()
    {
        $xml = "";
        $xml .= eBayService::createXMLElement('ErrorLanguage',eBayErrorLanguageType::en_US);
        $xml .= eBayService::createXMLElement('WarningLevel',eBayWarningLevelCodeType::High);

        return $xml;
    }

    public static function GetCategoryFeatures($param=array('site_id'=>eBaySiteIdCodeType::US, 'CategoryID'=>'', 'ViewAllNodes'=>true, 'DetailLevel'=>eBayDetailLevelCodeType::ReturnAll, 'LevelLimit'=>4), $eBayAPIKeyId=2)
    {
        $eBayAPIKeyId = eBayApiKey::model()->findByPk($eBayAPIKeyId);
        if(empty($eBayAPIKeyId))
        {
            echo "eBay API key does not found!\n";
            return false;
        }

        $store = Store::model()->find("ebay_api_key_id=:ebay_api_key_id", array(':ebay_api_key_id'=>$eBayAPIKeyId->id));
        if(empty($store) || $store->is_active != Store::ACTIVE_YES || empty($store->ebay_token))
        {
            echo "store does not found!\n";
            return false;
        }

        $eBayService = new eBayService();
        $eBayService->post_data = $eBayService->getRequestAuthHead($store->ebay_token, "GetCategoryFeatures").self::GetCategoryFeaturesXML($param).$eBayService->getRequestAuthFoot("GetCategoryFeatures");
        $eBayService->api_url = $eBayAPIKeyId->api_url;
        $eBayService->createHTTPHead($param['site_id'], 893, $eBayAPIKeyId->dev_id, $eBayAPIKeyId->app_id, $eBayAPIKeyId->cert_id, "GetCategoryFeatures");

        try
        {
            $result = $eBayService->request();

            if(empty($result) || !$result)
            {
                echo "eBay service call failed!\n";
                return false;
            }

            if((string)$result->Ack===eBayAckCodeType::Success)
            {
                self::processeBayCategoryFeatureDefinitionAndDefault($param, (array)$result);

                //var_dump($temp);die();
                foreach($result->Category as $category)
                {
                    self::processeBayCategoryFeature($param, $category);
                }

                return true;
            }
            else
            {
                var_dump($result);
                return false;
            }
        }
        catch(Exception $ex)
        {
            echo "Exception detected, code: ".$ex->getCode().", msg: ".$ex->getMessage()."\n";
            return false;
        }
    }

    protected static function GetCategoryFeaturesXML($param=array('ViewAllNodes'=>true, 'DetailLevel'=>eBayDetailLevelCodeType::ReturnAll, 'LevelLimit'=>4))
    {
        if(empty($param)) return false;

        $xml = "";

        if(!empty($param['CategoryID']))
        {
            $xml .= eBayService::createXMLElement('CategoryID',$param['CategoryID']);
            if(isset($param['AllFeaturesForCategory']))
                $xml .= eBayService::createXMLElement('AllFeaturesForCategory',($param['AllFeaturesForCategory'] ? 'true' : 'false'));
        }
        if(isset($param['ViewAllNodes']))
            $xml .= eBayService::createXMLElement('ViewAllNodes',($param['ViewAllNodes'] ? 'true' : 'false'));
        else
            $xml .= eBayService::createXMLElement('ViewAllNodes', 'true');
        $xml .= eBayService::createXMLElement('DetailLevel',eBayDetailLevelCodeType::ReturnAll);
        if(isset($param['LevelLimit']))
            $xml .= eBayService::createXMLElement('LevelLimit',$param['LevelLimit']);
        else
            $xml .= eBayService::createXMLElement('LevelLimit',4);

        return $xml;
    }

    protected static function processeBayCategoryFeatureDefinitionAndDefault($param, $result)
    {
        if(empty($param) || empty($result))
        {
            echo "No input detected!\n";
            return false;
        }

        $transaction=NULL;
        try
        {
            $transaction= Yii::app()->db->beginTransaction();

            $eBayEntityType = eBayEntityType::model()->find('entity_model=:entity_model', array(':entity_model'=>'eBayCategoryFeatureDefinitionAndDefault'));
            if(empty($eBayEntityType))
            {
                echo "eBay entity type for eBay Category Feature, Feature Definition And site Defaul does not found!\n";
                return false;
            }

            $eBayAttributeSet = eBayAttributeSet::model()->find(
                'entity_type_id=:entity_type_id and is_active=:is_active',
                array(
                    ':entity_type_id'=>$eBayEntityType->id,
                    ':is_active'=>true,
                )
            );
            if(empty($eBayAttributeSet))
            {
                echo "eBay Attribute Set for eBay Category Feature, Feature Definition And site Defaul does not found!\n";
                return false;
            }

            $eBayCategoryFeatureDefinitionAndDefault = eBayCategoryFeatureDefinitionAndDefault::model()->find("site_id=:site_id", array(":site_id"=>$param['site_id']));
            if(empty($eBayCategoryFeatureDefinitionAndDefault))
            {
                $eBayCategoryFeatureDefinitionAndDefault = new eBayCategoryFeatureDefinitionAndDefault();
                $eBayCategoryFeatureDefinitionAndDefault->site_id = $param['site_id'];
                $eBayCategoryFeatureDefinitionAndDefault->name = "eBay Category Feature, Feature Definition And site Default for site: ".$param['site_id'];
                $eBayCategoryFeatureDefinitionAndDefault->CategoryVersion = (string)$result['CategoryVersion'];
                $eBayCategoryFeatureDefinitionAndDefault->ebay_entity_type_id = $eBayEntityType->id;
                $eBayCategoryFeatureDefinitionAndDefault->ebay_attribute_set_id = $eBayAttributeSet->id;
            }
            if(!$eBayCategoryFeatureDefinitionAndDefault->save(false))
            {
                echo "fail to save eBay Category Feature, Feature Definition And site Default.\n";
                if(isset($transaction)) $transaction->rollback();
                return false;
            }

            //clear all item's attribute value record
            self::clearAlleBayEntityAttributeValue($eBayCategoryFeatureDefinitionAndDefault);
            echo "all attribute value have been cleared.\n";

            echo("start to process eBay Category Feature, Feature Definition And site Default for site ".$param['site_id']." attribute:\n");
            eBayTradingAPI::processeBayEntityAttributesRC($eBayCategoryFeatureDefinitionAndDefault, $eBayAttributeSet, $result);
            $transaction->commit();
            echo("eBay Category Feature, Feature Definition And site Default for site ".$param['site_id']." attribute process finished!\n".date("Y-m-d H:i:s", time())."item process finished\n\n");
        }
        catch(Exception $ex)
        {
            if(isset($transaction)) $transaction->rollback();
            echo "Exception detected, code: ".$ex->getCode().", msg: ".$ex->getMessage()."\n";
            return false;
        }
    }

    protected static function processeBayCategoryFeature($param, $category)
    {
        if(empty($param) || empty($category))
        {
            echo "No input detected!\n";
            return false;
        }

        $transaction=NULL;
        try
        {
            $transaction= Yii::app()->db->beginTransaction();

            $eBayEntityType = eBayEntityType::model()->find('entity_model=:entity_model', array(':entity_model'=>'eBayCategoryFeature'));
            if(empty($eBayEntityType))
            {
                echo "eBay entity type for eBay Category Feature does not found!\n";
                return false;
            }

            $eBayAttributeSet = eBayAttributeSet::model()->find(
                'entity_type_id=:entity_type_id and is_active=:is_active',
                array(
                    ':entity_type_id'=>$eBayEntityType->id,
                    ':is_active'=>true,
                )
            );
            if(empty($eBayAttributeSet))
            {
                echo "eBay Attribute Set for eBay Category Feature does not found!\n";
                return false;
            }

            $eBayCategoryFeature = eBayCategoryFeature::model()->find("site_id=:site_id and category_id=:category_id", array(":site_id"=>$param['site_id'], ":category_id"=>(string)$category['CategoryID']));
            if(empty($eBayCategoryFeature))
            {
                $eBayCategoryFeature = new eBayCategoryFeature();
                $eBayCategoryFeature->site_id = $param['site_id'];
                $eBayCategoryFeature->name = "eBay Category Feature for site: ".$param['site_id'].", category: ".(string)$category['CategoryID'];
                $eBayCategoryFeature->category_id = (string)$category['CategoryID'];
                $eBayCategoryFeature->ebay_entity_type_id = $eBayEntityType->id;
                $eBayCategoryFeature->ebay_attribute_set_id = $eBayAttributeSet->id;
            }
            if(!$eBayCategoryFeature->save(false))
            {
                echo "fail to save eBay Category Feature.\n";
                if(isset($transaction)) $transaction->rollback();
                return false;
            }

            //clear all item's attribute value record
            self::clearAlleBayEntityAttributeValue($eBayCategoryFeature);
            echo "all attribute value have been cleared.\n";

            echo("start to process eBay Category Feature for site: ".$param['site_id'].", category: ".(string)$category['CategoryID']."\n");
            eBayTradingAPI::processeBayEntityAttributesRC($eBayCategoryFeature, $eBayAttributeSet, $category);
            $transaction->commit();
            echo("eBay Category Feature for site ".$param['site_id']." attribute process finished!\n".date("Y-m-d H:i:s", time())."item process finished\n\n");
        }
        catch(Exception $ex)
        {
            if(isset($transaction)) $transaction->rollback();
            echo "Exception detected, code: ".$ex->getCode().", msg: ".$ex->getMessage()."\n";
            return false;
        }
    }

    public static function GetSellerEvents($storeId=null, $param=array(
        'EndTimeFrom'=>'',
        'EndTimeTo'=>'',
        'HideVariations'=>false,
        'IncludeVariationSpecifics'=>true,
        'IncludeWatchCount'=>true,
        'ModTimeFrom'=>'',
        'ModTimeTo'=>'',
        'NewItemFilter'=>true,
        'StartTimeFrom'=>'',
        'StartTimeTo'=>'',
        'DetailLevel'=>eBayDetailLevelCodeType::ReturnAll,
    ))
    {
        if(empty($storeId)) return false;

        $store = Store::model()->findByPk($storeId);
        if(empty($store) || $store->is_active != Store::ACTIVE_YES || empty($store->ebay_token))
        {
            echo "store does not found or disactive!\n";
            return false;
        }

        $eBayService = new eBayService();
        $eBayService->post_data = $eBayService->getRequestAuthHead($store->ebay_token, "GetSellerEvents").self::GetSellerEventsXML($param).$eBayService->getRequestAuthFoot("GetSellerEvents");
        $eBayService->api_url = $store->eBayApiKey->api_url;
        $eBayService->createHTTPHead($store->ebay_site_code, 893, $store->eBayApiKey->dev_id, $store->eBayApiKey->app_id, $store->eBayApiKey->cert_id, "GetSellerEvents");

        try
        {
            $result = $eBayService->request();

            if(empty($result) || !$result)
            {
                echo "eBay service call failed!\n";
                return false;
            }

            if((string)$result->Ack===eBayAckCodeType::Success)
            {
                var_dump($result);
                return true;
            }
            else
            {
                var_dump($result);
                return false;
            }
        }
        catch(Exception $ex)
        {
            echo "Exception detected, code: ".$ex->getCode().", msg: ".$ex->getMessage()."\n";
            return false;
        }
    }

    protected static function GetSellerEventsXML($param)
    {
        $xml = "";

        if(isset($param['HideVariations']) && $param['HideVariations'])
            $xml .= eBayService::createXMLElement('HideVariations','true');
        else
            $xml .= eBayService::createXMLElement('HideVariations','false');
        if(isset($param['IncludeVariationSpecifics']) && $param['IncludeVariationSpecifics'])
            $xml .= eBayService::createXMLElement('IncludeVariationSpecifics','true');
        else
            $xml .= eBayService::createXMLElement('IncludeVariationSpecifics','false');
        if(isset($param['IncludeWatchCount']) && $param['IncludeWatchCount'])
            $xml .= eBayService::createXMLElement('IncludeWatchCount','true');
        else
            $xml .= eBayService::createXMLElement('IncludeWatchCount','false');
        if(isset($param['NewItemFilter']) && $param['NewItemFilter'])
            $xml .= eBayService::createXMLElement('NewItemFilter','true');
        else
            $xml .= eBayService::createXMLElement('NewItemFilter','false');
        if(isset($param['DetailLevel']))
            $xml .= eBayService::createXMLElement('DetailLevel',$param['DetailLevel']);
        else
            $xml .= eBayService::createXMLElement('DetailLevel',eBayDetailLevelCodeType::ReturnAll);

        if(isset($param['ModTimeFrom']) && isset($param['ModTimeTo']))
        {
            $xml .= eBayService::createXMLElement('ModTimeFrom',$param['ModTimeFrom']);
            $xml .= eBayService::createXMLElement('ModTimeTo',$param['ModTimeTo']);
        }
        else if(isset($param['StartTimeFrom']) && isset($param['StartTimeTo']))
        {
            $xml .= eBayService::createXMLElement('StartTimeFrom',$param['StartTimeFrom']);
            $xml .= eBayService::createXMLElement('StartTimeTo',$param['StartTimeTo']);
        }
        else if(isset($param['EndTimeFrom']) && isset($param['EndTimeTo']))
        {
            $xml .= eBayService::createXMLElement('EndTimeFrom',$param['EndTimeFrom']);
            $xml .= eBayService::createXMLElement('EndTimeFrom',$param['EndTimeFrom']);
        }

        return $xml;
    }

    public static function GetSellerDashboard($storeId)
    {
        if(empty($storeId)) return false;

        $store = Store::model()->findByPk($storeId);
        if(empty($store) || $store->is_active != Store::ACTIVE_YES || empty($store->ebay_token))
        {
            echo "store does not found or disactive!\n";
            return false;
        }

        $eBayService = new eBayService();
        $eBayService->post_data = $eBayService->getRequestAuthHead($store->ebay_token, "GetSellerDashboard").self::GetSellerDashboardXML(array()).$eBayService->getRequestAuthFoot("GetSellerDashboard");
        $eBayService->api_url = $store->eBayApiKey->api_url;
        $eBayService->createHTTPHead($store->ebay_site_code, 893, $store->eBayApiKey->dev_id, $store->eBayApiKey->app_id, $store->eBayApiKey->cert_id, "GetSellerDashboard");

        try
        {
            $result = $eBayService->request();

            if(empty($result) || !$result)
            {
                echo "eBay service call failed!\n";
                return false;
            }

            if((string)$result->Ack===eBayAckCodeType::Success)
            {
                $eBayEntityType = eBayEntityType::model()->find('entity_model=:entity_model', array(':entity_model'=>'eBaySellerDashboard'));
                if(empty($eBayEntityType))
                {
                    echo "eBay entity type for eBay Seller Dashboard does not found!\n";
                    return false;
                }

                $eBayAttributeSet = eBayAttributeSet::model()->find(
                    'entity_type_id=:entity_type_id and is_active=:is_active',
                    array(
                        ':entity_type_id'=>$eBayEntityType->id,
                        ':is_active'=>true,
                    )
                );
                if(empty($eBayAttributeSet))
                {
                    echo "eBay Attribute Set for eBay detail does not found!\n";
                    return false;
                }

                $transaction=NULL;
                try
                {
                    $transaction= Yii::app()->db->beginTransaction();
                    $eBaySellerDashboard = eBaySellerDashboard::model()->find("store_id=:store_id", array(":store_id"=>$storeId));
                    if(empty($eBaySellerDashboard))
                    {
                        $eBaySellerDashboard = new eBaySellerDashboard();
                        $eBaySellerDashboard->name = "eBay seller dashboard for store: ".$store->name;
                        $eBaySellerDashboard->store_id = $store->id;
                        $eBaySellerDashboard->ebay_entity_type_id = $eBayEntityType->id;
                        $eBaySellerDashboard->ebay_attribute_set_id = $eBayAttributeSet->id;
                        $eBaySellerDashboard->note = "";
                    }
                    if(!$eBaySellerDashboard->save(false))
                    {
                        echo "Fail to save eBay seller dashboard object for store $storeId!\n";
                        return false;
                    }

                    //clear all item's attribute value record
                    self::clearAlleBayEntityAttributeValue($eBaySellerDashboard);
                    echo "all attribute value have been cleared.\n";

                    echo("start to process eBay seller dashboard for store $storeId attributes:\n");
                    eBayTradingAPI::processeBayEntityAttributesRC($eBaySellerDashboard, $eBayAttributeSet, (array)$result);
                    $transaction->commit();
                    echo("eBay seller dashboard for store $storeId attributes process finished!\n".date("Y-m-d H:i:s", time())."item process finished\n\n");
                    return true;
                }
                catch(Exception $ex)
                {
                    if(isset($transaction)) $transaction->rollback();
                    echo "Exception detected, code: ".$ex->getCode().", msg: ".$ex->getMessage()."\n";
                    return false;
                }
            }
            else
            {
                var_dump($result);
                return false;
            }
        }
        catch(Exception $ex)
        {
            echo "Exception detected, code: ".$ex->getCode().", msg: ".$ex->getMessage()."\n";
            return false;
        }
    }

    protected static function GetSellerDashboardXML($params)
    {
        $xml = "";
        if(isset($param['ErrorLanguage']))
            $xml .= eBayService::createXMLElement('ErrorLanguage',$param['ErrorLanguage']);
        return $xml;
    }

    protected static function processeBaySeller($store=null, $seller=null)
    {
        if(!isset($store) || !isset($seller))
        {
            echo "Input is invaild, please check input parameters!\n";
            return false;
        }

        $eBayEntityType = eBayEntityType::model()->find('entity_model=:entity_model', array(':entity_model'=>'eBaySeller'));
        if(empty($eBayEntityType))
        {
            echo "eBay entity type for eBay detail does not found!\n";
            return false;
        }

        $eBayAttributeSet = eBayAttributeSet::model()->find(
            'entity_type_id=:entity_type_id and is_active=:is_active',
            array(
                ':entity_type_id'=>$eBayEntityType->id,
                ':is_active'=>true,
            )
        );
        if(empty($eBayAttributeSet))
        {
            echo "eBay Attribute Set for eBay detail does not found!\n";
            return false;
        }

        $transaction=NULL;
        try
        {
            $transaction= Yii::app()->db->beginTransaction();
            $eBaySeller = eBaySeller::model()->find("store_id=:store_id", array(":store_id"=>$store->id));
            if(empty($eBaySeller))
            {
                $eBaySeller = new eBaySeller();
                $eBaySeller->name = "eBay seller for store: ".$store->name;
                $eBaySeller->store_id = $store->id;
                $eBaySeller->ebay_entity_type_id = $eBayEntityType->id;
                $eBaySeller->ebay_attribute_set_id = $eBayAttributeSet->id;
                $eBaySeller->note = "";
            }
            if(!$eBaySeller->save(false))
            {
                echo "Fail to save eBay seller object for store $store->id!\n";
                return false;
            }

            //clear all item's attribute value record
            self::clearAlleBayEntityAttributeValue($eBaySeller);
            echo "all attribute value have been cleared.\n";

            echo("start to process eBay seller for store $store->id attributes:\n");
            eBayTradingAPI::processeBayEntityAttributesRC($eBaySeller, $eBayAttributeSet, (array)$seller);
            $transaction->commit();
            echo("eBay seller for store {$store->id} attributes process finished!\n".date("Y-m-d H:i:s", time())."item process finished\n\n");
            return true;
        }
        catch(Exception $ex)
        {
            if(isset($transaction)) $transaction->rollback();
            echo "Exception detected, code: ".$ex->getCode().", msg: ".$ex->getMessage()."\n";
            return false;
        }
    }

    public static function GetUser($storeId=0)
    {
        if(empty($storeId))
        {
            echo "Input is invalid, please check input parameters!\n";
            return false;
        }

        $store = Store::model()->findByPk($storeId);
        if(empty($store) || $store->is_active != Store::ACTIVE_YES || empty($store->ebay_token))
        {
            echo "store does not found or disactive!\n";
            return false;
        }

        $eBayService = new eBayService();
        $eBayService->post_data = $eBayService->getRequestAuthHead($store->ebay_token, "GetUser").self::GetUserXML(array()).$eBayService->getRequestAuthFoot("GetUser");
        $eBayService->api_url = $store->eBayApiKey->api_url;
        $eBayService->createHTTPHead($store->ebay_site_code, 893, $store->eBayApiKey->dev_id, $store->eBayApiKey->app_id, $store->eBayApiKey->cert_id, "GetUser");

        try
        {
            $result = $eBayService->request();

            if(empty($result) || !$result)
            {
                echo "eBay service call failed!\n";
                return false;
            }

            $eBayEntityType = eBayEntityType::model()->find('entity_model=:entity_model', array(':entity_model'=>'eBayUser'));
            if(empty($eBayEntityType))
            {
                echo "eBay entity type for eBay User does not found!\n";
                return false;
            }

            $eBayAttributeSet = eBayAttributeSet::model()->find(
                'entity_type_id=:entity_type_id and is_active=:is_active',
                array(
                    ':entity_type_id'=>$eBayEntityType->id,
                    ':is_active'=>true,
                )
            );
            if(empty($eBayAttributeSet))
            {
                echo "eBay Attribute Set for eBay detail does not found!\n";
                return false;
            }

            if((string)$result->Ack===eBayAckCodeType::Success)
            {
                $transaction=NULL;
                try
                {
                    $transaction= Yii::app()->db->beginTransaction();
                    $eBayUser = eBayUser::model()->find("store_id=:store_id", array(":store_id"=>$storeId));
                    if(empty($eBayUser))
                    {
                        $eBayUser = new eBayUser();
                        $eBayUser->name = "eBay user for store: ".$store->name;
                        $eBayUser->store_id = $store->id;
                        $eBayUser->ebay_entity_type_id = $eBayEntityType->id;
                        $eBayUser->ebay_attribute_set_id = $eBayAttributeSet->id;
                        $eBayUser->note = "";
                    }
                    if(!$eBayUser->save(false))
                    {
                        echo "Fail to save eBay seller dashboard object for store $storeId!\n";
                        return false;
                    }

                    //clear all item's attribute value record
                    self::clearAlleBayEntityAttributeValue($eBayUser);
                    echo "all attribute value have been cleared.\n";

                    echo("start to process eBay seller dashboard for store $storeId attributes:\n");
                    eBayTradingAPI::processeBayEntityAttributesRC($eBayUser, $eBayAttributeSet, (array)$result->User);
                    $transaction->commit();
                    echo("eBay seller dashboard for store $storeId attributes process finished!\n".date("Y-m-d H:i:s", time())."item process finished\n\n");
                    return true;
                }
                catch(Exception $ex)
                {
                    if(isset($transaction)) $transaction->rollback();
                    echo "Exception detected, code: ".$ex->getCode().", msg: ".$ex->getMessage()."\n";
                    return false;
                }
            }
            else
            {
                var_dump($result);
                return false;
            }
        }
        catch(Exception $ex)
        {
            echo "Exception detected, code: ".$ex->getCode().", msg: ".$ex->getMessage()."\n";
            return false;
        }
    }

    protected static function GetUserXML($param=array())
    {
        $xml = "";
        if(isset($param['DetailLevel']))
            $xml .= eBayService::createXMLElement('DetailLevel',$param['DetailLevel']);
        else
            $xml .= eBayService::createXMLElement('DetailLevel',eBayDetailLevelCodeType::ReturnAll);
        return $xml;
    }

    public static function GetMyeBaySelling($storeId=null, $param=array(
        'ActiveList'=>array(
            'Include'=>true,
            'IncludeNotes'=>false,
            'Pagination'=>array('EntriesPerPage'=>100, 'PageNumber'=>1),
        ),
        'BidList'=>array(
            'Include'=>true,
            'Pagination'=>array('EntriesPerPage'=>100, 'PageNumber'=>1),
        ),
        'SellingSummary'=>array('Include'=>true),
    ))
    {
        if(!isset($storeId) || $storeId < 1)
        {
            return false;
        }

        $store = Store::model()->findByPk($storeId);
        if(empty($store) || $store->is_active != Store::ACTIVE_YES || empty($store->ebay_token))
        {
            echo "store does not found or disactive!\n";
            return false;
        }

        $eBayIDList = array();

        $eBayService = new eBayService();
        $eBayService->post_data = $eBayService->getRequestAuthHead($store->ebay_token, "GetMyeBaySelling").self::GetMyeBaySellingXML($param).$eBayService->getRequestAuthFoot("GetMyeBaySelling");
        $eBayService->api_url = $store->eBayApiKey->api_url;
        $eBayService->createHTTPHead($store->ebay_site_code, 893, $store->eBayApiKey->dev_id, $store->eBayApiKey->app_id, $store->eBayApiKey->cert_id, "GetMyeBaySelling");

        try
        {
            $result = $eBayService->request();

            if(empty($result) || !$result)
            {
                echo "eBay service call failed!\n";
                return false;
            }

            if((string)$result->Ack===eBayAckCodeType::Success)
            {

                if(isset($result->ActiveList->ItemArray))
                {
                    foreach($result->ActiveList->ItemArray->Item as $item)
                    {
                        $eBayIDList[] = (string)$item->ItemID;
                    }
                    if(isset($result->ActiveList) && (int)$result->ActiveList->PaginationResult->TotalNumberOfPages > $param['ActiveList']['Pagination']['PageNumber'])
                    {
                        $param['ActiveList']['Pagination']['PageNumber']++;
                    }
                    else
                    {
                        $param['ActiveList']['Include'] = false;
                    }
                }

                if(isset($result->BidList->ItemArray))
                {
                    foreach($result->BidList->ItemArray->Item as $item)
                    {
                        $eBayIDList[] = (string)$item->ItemID;
                    }
                    if(isset($result->BidList) && (int)$result->BidList->PaginationResult->TotalNumberOfPages > $param['ActiveList']['Pagination']['PageNumber'])
                    {
                        $param['BidList']['Pagination']['PageNumber']++;
                    }
                    else
                    {
                        $param['BidList']['Include'] = false;
                    }
                }

                while($param['ActiveList']['Include'] || $param['BidList']['Include'])
                {
                    $eBayService->post_data = $eBayService->getRequestAuthHead($store->ebay_token, "GetMyeBaySelling").eBayTradingAPI::GetMyeBaySellingXML($param).$eBayService->getRequestAuthFoot("GetMyeBaySelling");
                    $result = $eBayService->request();

                    if(empty($result))
                    {
                        echo "service call failed with no return.\n";
                        return false;
                    }

                    if((string)$result->Ack===eBayAckCodeType::Success)
                    {

                        if(isset($result->ActiveList->ItemArray))
                        {
                            foreach($result->ActiveList->ItemArray->Item as $item)
                            {
                                $eBayIDList[] = (string)$item->ItemID;
                            }
                            if(isset($result->ActiveList) && (int)$result->ActiveList->PaginationResult->TotalNumberOfPages > $param['ActiveList']['Pagination']['PageNumber'])
                            {
                                $param['ActiveList']['Pagination']['PageNumber']++;
                            }
                            else
                            {
                                $param['ActiveList']['Include'] = false;
                            }
                        }
                        else
                        {
                            $param['ActiveList']['Include'] = false;
                        }

                        if(isset($result->BidList->ItemArray))
                        {
                            foreach($result->BidList->ItemArray->Item as $item)
                            {
                                $eBayIDList[] = (string)$item->ItemID;
                            }
                            if(isset($result->BidList) && (int)$result->BidList->PaginationResult->TotalNumberOfPages > $param['ActiveList']['Pagination']['PageNumber'])
                            {
                                $param['BidList']['Pagination']['PageNumber']++;
                            }
                            else
                            {
                                $param['BidList']['Include'] = false;
                            }
                        }
                        else
                        {
                            $param['BidList']['Include'] = false;
                        }

                        if(!$param['ActiveList']['Include'] && !$param['BidList']['Include']) break;

                        continue;
                    }
                    else
                    {
                        var_dump($result);
                        break;
                    }
                }

                if(empty($eBayIDList)) return true;
                $eBayIDList = array_unique($eBayIDList);
                $idInput = count($eBayIDList) > 1 ? "('".implode("','", $eBayIDList)."')" : "({$eBayIDList[0]})";

                $sql = "SELECT t.ebay_listing_id, t.update_time_utc FROM lt_ebay_listing t
                        where t.company_id= {$store->company_id} and t.store_id = {$store->id}
                        and t.ebay_listing_id in $idInput
                        group by t.ebay_listing_id;";
                $command = Yii::app()->db->createCommand($sql);
                $ids = $command->queryAll();
                if(empty($ids)) return true;
                $validIDs = array();
                $lookUpIDs = array();
                foreach($ids as $id)
                {
                    $validIDs[] = $id['ebay_listing_id'];
                    $listings[$id['ebay_listing_id']] = array('id'=>$id['ebay_listing_id'], 'update'=>$id['update_time_utc']);
                }
                foreach($eBayIDList as $test)
                {
                    if(!in_array($test, $validIDs))
                        $lookUpIDs[] = $test;
                    else if(in_array($test, $validIDs) && $listings[$test]['update'] < time() - 60 * 60 *12)
                        $lookUpIDs[] = $test;
                }

                $eBayEntityType = eBayEntityType::model()->find('entity_model=:entity_model', array(':entity_model'=>'eBayListing'));
                if(empty($eBayEntityType)) return false;

                $eBayAttributeSet = eBayAttributeSet::model()->find(
                    'entity_type_id=:entity_type_id and is_active=:is_active',
                    array(
                        ':entity_type_id'=>$eBayEntityType->id,
                        ':is_active'=>eBayAttributeSet::ACTIVE_YES,
                    )
                );
                if(empty($eBayAttributeSet)) return false;

                /*update active status*/
                $statusAttribute = $eBayAttributeSet->getEntityAttribute('SellingStatus->ListingStatus');
                $clearSQL = "update lt_ebay_entity_varchar t
                                set `value` = :value
                                where t.id in (select * from (
                                    SELECT t.id FROM lt_ebay_entity_varchar t
                                    left join lt_ebay_listing el on el.id = t.ebay_entity_id
                                    left join lt_store s on s.id = el.store_id
                                    where ebay_entity_attribute_id = :ebay_entity_attribute_id and s.id = :store_id and el.ebay_listing_id in $idInput ) as inside )";
                $command = Yii::app()->db->createCommand($clearSQL);
                $command->bindValue(":value", eBayListingStatusCodeType::Active, PDO::PARAM_STR);
                $command->bindValue(":ebay_entity_attribute_id", $statusAttribute->id, PDO::PARAM_INT);
                $command->bindValue(":store_id", $store->id, PDO::PARAM_INT);
                $command->execute();
                /*end*/

                if(empty($lookUpIDs)) return true;

                foreach($lookUpIDs as $id)
                {
                    $eBayListing = eBayListing::model()->find('ebay_listing_id=:ebay_listing_id', array(':ebay_listing_id'=>$id));
                    if(empty($eBayListing))
                    {
                        $eBayListing = new eBayListing();
                        $eBayListing->ebay_listing_id = $id;
                        $eBayListing->store_id = $store->id;
                        $eBayListing->company_id = $store->company_id;
                        $eBayListing->site_id = $store->ebay_site_code;
                        $eBayListing->is_active = 1;
                        $eBayListing->ebay_entity_type_id = $eBayEntityType->id;
                        $eBayListing->ebay_attribute_set_id = $eBayAttributeSet->id;
                    }
                    self::GetItem($eBayListing);
                    echo "$id has been synched.\n";
                }

                return true;
            }
            else
            {
                var_dump($result);
                return false;
            }
        }
        catch(Exception $ex)
        {
            echo "Exception detected, code: ".$ex->getCode().", msg: ".$ex->getMessage()."\n";
            return false;
        }
    }

    protected static function GetMyeBaySellingXML($param)
    {
        $xml = "";
        if(isset($param['ActiveList']) && !empty($param['ActiveList']))
        {
            $activeList = "";
            if(isset($param['ActiveList']['Include']))
                $activeList .= eBayService::createXMLElement('Include',$param['ActiveList']['Include'] ? 'true' : 'false');
            else
                $activeList .= eBayService::createXMLElement('Include','false');
            if(isset($param['ActiveList']['IncludeNotes']))
                $activeList .= eBayService::createXMLElement('IncludeNotes',$param['ActiveList']['IncludeNotes'] ? 'true' : 'false');
            else
                $activeList .= eBayService::createXMLElement('IncludeNotes','false');
            if(isset($param['ActiveList']['Pagination']) && !empty($param['ActiveList']['Pagination']))
            {
                $Pagination = "";
                if(isset($param['ActiveList']['Pagination']['EntriesPerPage']))
                    $Pagination .= eBayService::createXMLElement('EntriesPerPage', $param['ActiveList']['Pagination']['EntriesPerPage']);
                if(isset($param['ActiveList']['Pagination']['PageNumber']))
                    $Pagination .= eBayService::createXMLElement('PageNumber', $param['ActiveList']['Pagination']['PageNumber']);
                $activeList .= eBayService::createXMLElement('Pagination',$Pagination);
            }
            $xml .= eBayService::createXMLElement('ActiveList',$activeList);
        }
        if(isset($param['BidList']) && !empty($param['BidList']))
        {
            $bidList = "";
            if(isset($param['BidList']['Include']))
                $bidList .= eBayService::createXMLElement('Include',$param['BidList']['Include'] ? 'true' : 'false');
            else
                $bidList .= eBayService::createXMLElement('Include','false');
            if(isset($param['BidList']['Pagination']) && !empty($param['BidList']['Pagination']))
            {
                $Pagination = "";
                if(isset($param['BidList']['Pagination']['EntriesPerPage']))
                    $Pagination .= eBayService::createXMLElement('EntriesPerPage', $param['BidList']['Pagination']['EntriesPerPage']);
                if(isset($param['BidList']['Pagination']['PageNumber']))
                    $Pagination .= eBayService::createXMLElement('PageNumber', $param['BidList']['Pagination']['PageNumber']);
                $bidList .= eBayService::createXMLElement('Pagination',$Pagination);
            }
            $xml .= eBayService::createXMLElement('BidList',$bidList);
        }
        if(isset($param['SellingSummary']) && !empty($param['SellingSummary']))
        {
            $sellingSummary = "";
            if(isset($param['SellingSummary']['Include']))
                $sellingSummary .= eBayService::createXMLElement('Include',$param['SellingSummary']['Include'] ? 'true' : 'false');
            else
                $sellingSummary .= eBayService::createXMLElement('Include','false');
            $xml .= eBayService::createXMLElement('SellingSummary',$sellingSummary);
        }
        $xml .= eBayService::createXMLElement('HideVariations','false');

        return $xml;
    }

    public static function GetMyeBaySellingV2($storeId=null, $param=array(
            'ActiveList'=>array(
                'Include'=>true,
                'IncludeNotes'=>false,
                'Pagination'=>array('EntriesPerPage'=>100, 'PageNumber'=>1),
            ),
            /*'BidList'=>array(
                'Include'=>true,
                'Pagination'=>array('EntriesPerPage'=>100, 'PageNumber'=>1),
            ),*/
            'SellingSummary'=>array('Include'=>true),
        )
    )
    {
        if(!isset($storeId) || $storeId < 1)
        {
            return false;
        }

        $store = Store::model()->findByPk($storeId);
        if(empty($store) || $store->is_active != Store::ACTIVE_YES || empty($store->ebay_token))
        {
            echo "store does not found or disactive!\n";
            return false;
        }

        $eBayEntityType = eBayEntityType::model()->find('entity_model=:entity_model', array(':entity_model'=>'eBayListing'));
        if(empty($eBayEntityType)) { echo "invalid ebay entity!\n"; return false;}
        $eBayAttributeSet = eBayAttributeSet::model()->find(
            'entity_type_id=:entity_type_id and is_active=:is_active',
            array(
                ':entity_type_id'=>$eBayEntityType->id,
                ':is_active'=>true,
            )
        );
        if(empty($eBayAttributeSet)) { echo "invalid ebay attribute set.\n"; return false;}

        $listingStatusAttribute = $eBayAttributeSet->getEntityAttribute("SellingStatus->ListingStatus");
        $select = "select t.ebay_listing_id
                    from lt_ebay_listing t
                    left join lt_ebay_entity_varchar eev on eev.ebay_entity_id = t.id and eev.ebay_entity_attribute_id = :ebay_entity_attribute_id
                    left join lt_store s on s.id = t.store_id
                    where eev.value = :listingStatus and s.id = :store_id; ";
        $command = Yii::app()->db->createCommand($select);
        $command->bindValue(":ebay_entity_attribute_id", $listingStatusAttribute->id, PDO::PARAM_INT);
        $command->bindValue(":listingStatus", eBayListingStatusCodeType::Active, PDO::PARAM_STR);
        $command->bindValue(":store_id", $store->id, PDO::PARAM_INT);
        $result = $command->queryAll();
        $activeLists = array();
        if(!empty($result)) foreach($result as $val) $activeLists[] = $val['ebay_listing_id'];

        $updateLists = array();
        $eBayService = new eBayService();
        $eBayService->post_data = $eBayService->getRequestAuthHead($store->ebay_token, "GetMyeBaySelling").self::GetMyeBaySellingXML($param).$eBayService->getRequestAuthFoot("GetMyeBaySelling");
        $eBayService->api_url = $store->eBayApiKey->api_url;
        $eBayService->createHTTPHead($store->ebay_site_code, 893, $store->eBayApiKey->dev_id, $store->eBayApiKey->app_id, $store->eBayApiKey->cert_id, "GetMyeBaySelling");
        echo "start to get ebay selling for store id: ".$store->id.", site id: ".$store->ebay_site_code."\n";

        try
        {
            $response = $eBayService->request();

            if(empty($response) || !$response)
            {
                echo "eBay service call failed!\n";
                return false;
            }

            if((string)$response->Ack===eBayAckCodeType::Success)
            {
                //process ebay active items
                if(isset($response->ActiveList->ItemArray) && !empty($response->ActiveList->ItemArray))
                {
                    foreach($response->ActiveList->ItemArray->Item as $item)
                    {
                        $listing = eBayListing::model()->find("store_id=:store_id and ebay_listing_id=:ebay_listing_id", array(":store_id"=>$store->id, ":ebay_listing_id"=>(string)$item->ItemID));
                        if(empty($listing))
                        {
                            $listing = new eBayListing();
                            $listing->store_id = $store->id;
                            $listing->company_id = $store->company_id;
                            $listing->ebay_listing_id = (string)$item->ItemID;
                            $listing->site_id = (int)eBaySiteName::geteBaySiteNameCode((string)$item->Site);
                            $listing->ebay_entity_type_id = $eBayEntityType->id;
                            $listing->ebay_attribute_set_id = $eBayAttributeSet->id;
                            $listing->is_active = true;
                            if(!$listing->save(false))
                            {
                                echo("insert eBay item ".(string)$item->ItemID." failed!\n");
                                continue;
                            }
                        }
                        eBayTradingAPI::GetItem($listing);
                        $updateLists[] = (string)$item->ItemID;
                        echo (string)$item->ItemID." updated!\n";
                    }
                }

                while(isset($response->ActiveList) && (int)$response->ActiveList->PaginationResult->TotalNumberOfPages > $param['ActiveList']['Pagination']['PageNumber'])
                {
                    $param['ActiveList']['Pagination']['PageNumber']++;
                    echo "\nprocess page: ".$param['ActiveList']['Pagination']['PageNumber'].".\n";
                    $eBayService->post_data = $eBayService->getRequestAuthHead($store->ebay_token, "GetMyeBaySelling").eBayTradingAPI::GetMyeBaySellingXML($param).$eBayService->getRequestAuthFoot("GetMyeBaySelling");
                    $response = $eBayService->request();
                    if(empty($response))
                    {
                        echo "service call failed with no return.\n";
                        break;
                    }

                    if((string)$response->Ack===eBayAckCodeType::Success)
                    {
                        if(isset($response->ActiveList->ItemArray) && !empty($response->ActiveList->ItemArray))
                        {
                            foreach($response->ActiveList->ItemArray->Item as $item)
                            {
                                $listing = eBayListing::model()->find("store_id=:store_id and ebay_listing_id=:ebay_listing_id", array(":store_id"=>$store->id, ":ebay_listing_id"=>(string)$item->ItemID));
                                if(empty($listing))
                                {
                                    $listing = new eBayListing();
                                    $listing->store_id = $store->id;
                                    $listing->company_id = $store->company_id;
                                    $listing->ebay_listing_id = (string)$item->ItemID;
                                    $listing->site_id = (int)eBaySiteName::geteBaySiteNameCode((string)$item->Site);
                                    $listing->ebay_entity_type_id = $eBayEntityType->id;
                                    $listing->ebay_attribute_set_id = $eBayAttributeSet->id;
                                    $listing->is_active = true;
                                    if(!$listing->save(false))
                                    {
                                        echo("insert eBay item ".(string)$item->ItemID." failed!\n");
                                        continue;
                                    }
                                }
                                eBayTradingAPI::GetItem($listing);
                                $updateLists[] = (string)$item->ItemID;
                                echo (string)$item->ItemID." updated!\n";
                            }
                        }
                    }
                    else
                    {
                        var_dump($response);
                        break;
                    }
                }
                echo "\nupdate ebay selling finished.\n";

                echo "\nstart to update offline product\n";
                $offlineLists = array_diff($activeLists, $updateLists);
                foreach($offlineLists as $item)
                {
                    $list = eBayListing::model()->find("ebay_list_id=:ebay_listing_id and store_id=:store_id", array(":ebay_listing_id"=>$item, ":store_id"=>$store->id));
                    if(!empty($list)) eBayTradingAPI::GetItem($list);
                    echo (string)$item->ItemID." updated!\n";
                }
            }
            else
            {
                var_dump($response);
                return false;
            }
        }
        catch(Exception $ex)
        {
            echo "Exception detected, code: ".$ex->getCode().", msg: ".$ex->getMessage()."\n";
            return false;
        }

        return true;
    }
} 