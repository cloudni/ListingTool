<?php
/**
 * Created by PhpStorm.
 * User: GavinLe
 * Date: 10/21/14
 * Time: 11:26 AM
 */

class ResourceStringTool {
    /**
     * @return array init all languages type
     */
    const TYPE_ZH_CN=1;
    const TYPE_EN_US=2;
    const MESSAGE="Unknow Message Code";

    public static function init()
    {
        return array(
            self::TYPE_ZH_CN=>'zh_cn',
            self::TYPE_EN_US=>'en_us',
            /*array('code'=>1,'displayName'=>'zh_cn'),
            array('code'=>2,'displayName'=>'en_us'),*/
        );
    }

    /**
     * @return array all languages
     */
    public static function getAllLanguagesType()
    {
        //var_dump("hello"); die();
        return self::init();
    }

    /**
     *  getDisplayName by code
     */
    public static function getLanguageCodeByDisplayName($displayName)
    {
        $allLanguagesType = self::init();
        foreach($allLanguagesType as $k =>$v) {
            if($v == $displayName){
                return $k;
            }
        }
        return null;
    }

    /**
     * @return  array by key
     *
     */
    public static function getSourceStringByKey($key)
    {
        $sql = " select * from lt_resource_string where 1=1 and `key`=:key and `environment`=:environment ";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(":key", $key, PDO::PARAM_INT);
        $command->bindValue(":environment",Environment, PDO::PARAM_INT);
        return $command->queryAll();

    }

    /**
     * Depending on the type of field and language for the target text
     * $key ： field or array
     * $languageType : language type
     * Environmwent
     */
    public static function getSourceStringByKeyAndLanguage($languageType,$field)
    {
        $rawData = Yii::app()->cache->get(sprintf("resource_string_%S_%s", $languageType, $field));
        if($rawData === false)
        {
            try
            {
                $type = self::getLanguageCodeByDisplayName($languageType);
                $sql = "select *  from lt_resource_string where `key`=:key and `language`=:type and `environment`=:environment limit 0, 1";
                $command = Yii::app()->db->createCommand($sql);
                $command->bindValue(":key", $field, PDO::PARAM_INT);
                $command->bindValue(":type", $type, PDO::PARAM_INT);
                $command->bindValue(":environment", Environment, PDO::PARAM_INT);
                $messages = $command->queryAll();
                if(isset($messages[0]))
                {
                    $rawData = $messages[0]['message'];
                    Yii::app()->cache->set(sprintf("resource_string_%S_%s", $languageType, $field),$rawData, 60 * 60 * 24);
                    return $rawData;
                }
                return ResourceStringTool::MESSAGE;
            } catch(Exception $ex)
            {
                throw new CHttpException(ResourceStringTool::MESSAGE, "internal error");
            }
        }
        return $rawData;
    }



} 