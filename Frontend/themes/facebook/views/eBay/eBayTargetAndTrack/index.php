<?php
/* @var $this EBayTargetAndTrackController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    'eBay'=>array('/eBay/eBay'),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'target_and_track'),
);

$this->menu=array(
	array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'create_target_and_track'), 'url'=>array('create')),
);
?>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'target_and_track');?></h1>
                </div>
            </div>
            <div style="display: block;">
                <table>
                    <thead>
                        <th>ID</th>
                        <th><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'name');?></th>
                        <th><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'create_username');?></th>
                        <th><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'note');?></th>
                        <th><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'action');?></th>
                    </thead>
                    <tbody>
                    <?php $this->widget('zii.widgets.CListView', array(
                        'dataProvider'=>$dataProvider,
                        'itemView'=>'_view',
                    )); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



