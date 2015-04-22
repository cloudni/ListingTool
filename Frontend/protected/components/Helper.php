<?php
/**
 * Created by PhpStorm.
 * User: GavinLe
 * Date: 10/30/14
 * Time: 11:18 AM
 */

class Helper {

    public static function getFormatTime($format,$time)
    {
        return date($format,$time);
    }

    /**
     * set environmental language
     */
    public static function setLanguageEnvironmental()
    {
        $language = null;
        $cookie = Yii::app()->request->getCookies();
        if(isset($cookie['language'])){
            $language = $cookie['language']->value;
            if($language!=Yii::app()->language)
            {
                Yii::app()->language =$language ;
            }
        }

    }

    /**
     * get environmental language
     */
    public static function getLanguageEnvironmental()
    {
        $language = null;
        $cookie = Yii::app()->request->getCookies();
        return !isset($cookie['language']->value) ? 'zh_cn' : $cookie['language']->value;
    }

    public static function unsetCookie()
    {
        $cookie = Yii::app()->request->getCookies();
        unset($cookie['language']);
    }

} 