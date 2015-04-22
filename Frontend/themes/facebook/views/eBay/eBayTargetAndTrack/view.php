<?php
/* @var $this EBayTargetAndTrackController */
/* @var $model eBayTargetAndTrack */

$this->breadcrumbs=array(
    'eBay'=>array('/eBay/eBay'),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'target_and_track')=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'List_target_and_track'), 'url'=>array('index')),
	array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'create_target_and_track'), 'url'=>array('create')),
	array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'update_target_and_track'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'delete_target_and_track'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
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
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;"><?php echo $model->name; ?></h1>
                </div>
            </div>
            <div style="display: block;">
                <?php $this->widget('zii.widgets.CDetailView', array(
                    'data'=>$model,
                    'attributes'=>array(
                        'id',
                        array(
                            'label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'name'),
                            'value'=>$model->name
                        ),
                        array(
                            'label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'note'),
                            'value'=>$model->note
                        ),
                        array(
                            'name'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'created_datetime'),
                            'value'=>CHtml::encode(date("m/d/Y", $model->create_time_utc)),
                        ),
                        array(
                            'name'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'create_username'),
                            'value'=>$model->CreateUser->username,
                        ),
                        array(
                            'label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'last_updated_time'),
                            'value'=>CHtml::encode(date("m/d/Y", $model->update_time_utc)),
                        ),
                        array(
                            'name'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'updated_username'),
                            'value'=>$model->UpdateUser->username,
                        ),
                    ),
                )); ?>
            </div>
        </div>
    </div>
</div>



