<?php
/* @var $this EBayTargetAndTrackController */
/* @var $model eBayTargetAndTrack */

$this->breadcrumbs=array(
    'eBay'=>array('/eBay/eBay'),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'target_and_track')=>array('index'),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'update'),
);
?>

<?php $this->renderPartial('_form', array(
    'model'=>$model,
    'trackingList'=>$trackingList,
    'targetList'=>$targetList,
    'updateParam'=>json_decode($model->update_param),));
?>