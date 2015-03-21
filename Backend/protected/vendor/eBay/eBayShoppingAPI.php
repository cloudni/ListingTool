<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/3/16
 * Time: 22:20
 */

Yii::import('application.vendor.*');
require_once("reference.php");
require_once("eBayService.php");
Yii::import('application.components.*');
require_once("ExceptionHandler/ExceptionCode.php");

class eBayShoppingAPI
{
    const Prod_API_URL = 'http://open.api.ebay.com/shopping';
    const Sandbox_API_URL = 'http://open.api.sandbox.ebay.com/shopping';

    public static function GetItem($itemIDs=array('400844296652'),$params=array('includeSelector'=>array(eBayIncludeSelectorCodeType::Details, eBayIncludeSelectorCodeType::Description, eBayIncludeSelectorCodeType::ItemSpecifics, eBayIncludeSelectorCodeType::Variations)))
    {
        if(empty($itemIDs)) return false;

        $eBayAPIKey = eBayApiKey::model()->findByPk(6);
        if(empty($eBayAPIKey)) return false;

        $eBayService = new eBayService();
        $eBayService->post_data = $eBayService->getRequestAuthHead(null, "GetMultipleItems").eBayShoppingAPI::GetMultipleItemsXML($itemIDs, $params).$eBayService->getRequestAuthFoot("GetMultipleItems");
        $eBayService->api_url = self::Prod_API_URL;
        $eBayService->createHTTPHead(null, $eBayAPIKey->compatibility_level, $eBayAPIKey->dev_id, $eBayAPIKey->app_id, $eBayAPIKey->cert_id, "GetMultipleItems");

        try
        {
            $result = $eBayService->request();
            var_dump($result);
        }
        catch(Exception $ex)
        {
            var_dump($ex);
            return array(
                'ErrorCode'=>$ex->getCode(),
                'ShortMessage'=>$ex->getMessage(),
            );
        }
        return true;
    }

    protected static function GetMultipleItemsXML($itemIDs, $params)
    {
        $xml = '';

        if(empty($params) || empty($itemIDs)) return $xml;

        if(!empty($params['includeSelector']))
        {
            if(count($params['includeSelector'])>1)
                $xml .= eBayService::createXMLElement('IncludeSelector', implode(",", $params['includeSelector']));
            else
                $xml .= eBayService::createXMLElement('IncludeSelector', $params['includeSelector']);
        }

        foreach($itemIDs as $item)
        {
            $xml .= eBayService::createXMLElement('ItemID',$item);
        }

        return $xml;
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
                        $valueId = self::SaveAttributeValue($eBayEntity, $currenteBayEntityAttribute, $subField, $parentEntityAttribute, $parentValueId);
                        self::processeBayEntityAttributesRC($eBayEntity, $eBayAttributeSet, $subField, $currenteBayEntityAttribute, $valueId, $indentation.'|--');
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
                    self::SaveAttributeValue($eBayEntity, $currenteBayEntityAttribute, $field, $parentEntityAttribute, $parentValueId);
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
                $valueId = self::SaveAttributeValue($eBayEntity, $currenteBayEntityAttribute, $field, $parentEntityAttribute, $parentValueId);
                if(gettype($field) == 'object')
                {
                    self::processeBayEntityAttributesRC($eBayEntity, $eBayAttributeSet, $field, $currenteBayEntityAttribute, $valueId, $indentation.'|--');
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

        $clearSQL = "update {{ebay_entity_decimal}} set
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

}