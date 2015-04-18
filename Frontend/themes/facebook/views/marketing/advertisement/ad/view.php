<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/4/18
 * Time: 21:05
 */

/* @var $this ADController */
/* @var $model ADAdvertise */

$this->breadcrumbs=array(
    'Marketing'=>array("/marketing/home"),
    'Advertisement'=>array("/marketing/advertisement/home"),
    'AD Campaign'=>array('/marketing/advertisement/adcampaign'),
    'AD Group'=>array('/marketing/advertisement/adgroup'),
    'AD' => array('index'),
    $model->name,
);

$this->menu=array(
    array('label'=>'AD Index', 'url'=>array('index')),
    array('label'=>'AD Create', 'url'=>array('create')),
    array('label'=>'AD Update', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'AD Delete', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('models/ADAdvertisement','Are you sure you want to delete this Advertisement?'))),
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
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;">AD Group: <?php echo $model->name; ?></h1>
                </div>
            </div>
            <div style="display: block;">
                <?php $this->widget('zii.widgets.CDetailView', array(
                    'data'=>$model,
                    'attributes'=>array(
                        'name',
                        'note',
                    ),
                )); ?>
            </div>
        </div>
    </div>
</div>