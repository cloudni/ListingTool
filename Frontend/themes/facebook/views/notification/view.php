<?php
/* @var $this NotificationController */
/* @var $model Notification */

$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'notification_title')=>array('index'),
	$model->title,
);

/*$this->menu=array(
	array('label'=>'List Notification', 'url'=>array('index')),
);
*/?>

<!--<h1>View Notification #<?php /*echo $model->id; */?></h1>-->

<style>
    table.detail-view th, table.detail-view td
    {
        font-size: 12px;
    }
</style>

<div style="width: 990px;margin-top: 15px;">
    <div class="title" style="width:400px;margin: 0px auto ;">
        <div style="text-align: center;font-size: 18px;">
            <span><?php echo $model->title; ?></span>
        </div>
        <div style="word-break:break-all">

            <?php echo $model->content ?>
        </div>
    </div>
</div>