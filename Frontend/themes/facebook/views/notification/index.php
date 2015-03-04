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



<?php /*$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); */?>
<div style="padding:15px;">
    <h1><?php echo  ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'notification_title'); ?></h1>
    <div class="grid-view">
        <table class="items" width="100%">
            <tr>
                <th><?php echo Yii::t('models/Notifications','Title');?></th>
                <th><?php echo Yii::t('models/Notifications','Content');?></th>
                <th><?php echo Yii::t('models/Notifications','Company');?></th>
                <th><?php echo Yii::t('models/Notifications','IsImportant');?></th>
                <th><?php echo Yii::t('models/Notifications','Create Time');?></th>
            </tr>
            <?php $this->widget('zii.widgets.CListView', array(
                'dataProvider'=>$dataProvider,
                'itemView'=>'_view',
            )); ?>
        </table>
    </div>
</div>

