<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/4/13
 * Time: 14:24
 */

/* @var $this ADCampaignController */
/* @var $model Store */

$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'menu_marketing')=>array("/marketing/home"),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'display_advertisement')=>array("/marketing/advertisement/home"),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign')=>array('index'),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'update'),
    $model->name
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>