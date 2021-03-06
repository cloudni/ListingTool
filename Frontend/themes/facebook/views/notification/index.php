<?php
/* @var $this NotificationController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle=Yii::app()->name . ' - '.ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'notification_title');
$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'notification_title'),
);

$this->menu=array(
	/*array('label'=>'Create Notification', 'url'=>array('create')),
	array('label'=>'Manage Notification', 'url'=>array('admin')),*/
);
?>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;"><?php echo  ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'notification_title'); ?></h1>
                </div>
            </div>
            <div style="display: block;">
                <div class="grid-view">
                    <table class="items" width="100%">
                        <tr>
                            <th><?php echo Yii::t('models/Notifications','Title');?></th>
                            <th><?php echo Yii::t('models/Notifications','Content');?></th>
                            <th><?php echo Yii::t('models/Notifications','Company');?></th>
                            <th><?php echo Yii::t('models/Notifications','Is New');?></th>
                            <th><?php echo Yii::t('models/Notifications','Create Time');?></th>
                        </tr>
                        <?php $this->widget('zii.widgets.CListView', array(
                            'dataProvider'=>$dataProvider,
                            'itemView'=>'_view',
                        )); ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
