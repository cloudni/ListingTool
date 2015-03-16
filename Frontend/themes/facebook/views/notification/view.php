<?php
/* @var $this NotificationController */
/* @var $model Notification */

$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'notification_title')=>array('index'),
	$model->title,
);
?>

<style>
    table.detail-view th, table.detail-view td
    {
        font-size: 12px;
    }
</style>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;"><?php echo $model->title; ?></h1>
                </div>
            </div>
            <div style="display: block;">
                <div style="font-size: 14px; padding: 14px; font-weight: bold; word-wrap: normal;"><?php echo $model->content ?></div>
            </div>
        </div>
    </div>
</div>