<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/4/15
 * Time: 23:55
 */

/* @var $this ADGroupController */
/* @var $model ADGroup */

$this->breadcrumbs=array(
    'Marketing'=>array("/marketing/home"),
    'Advertisement'=>array("/marketing/advertisement/home"),
    'AD Campaign'=>array('/marketing/advertisement/adcampaign'),
    'AD Group'=>array('index'),
    $model->name,
);

$this->menu=array(
    array('label'=>'AD Group Index', 'url'=>array('index')),
    array('label'=>'AD Group Create', 'url'=>array('create')),
    array('label'=>'AD Group Update', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'AD Group Delete', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('models/ADGroup','Are you sure you want to delete this AD Group?'))),
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
                <?php
                $criteria = "";
                $setting = (array)json_decode($model->criteria);
                ?>
                <?php $this->widget('zii.widgets.CDetailView', array(
                    'data'=>$model,
                    'attributes'=>array(
                        'name',
                        array(
                            'name'=>'status',
                            'value'=>ADCampaign::getStatusText($model->status),
                        ),
                        array(
                            'label'=>'Default Bid',
                            'value'=>sprintf("$%1\$.2f", $model->default_bid)
                        ),
                        array(
                            'label'=>"Keywords",
                            'value'=>($setting['keywords'] ? str_replace(ADGroup::Criteria_Separator, "<br />", $setting['keywords']) : ""),
                            'type'=>'html',
                        ),
                        array(
                            'label'=>"Placements",
                            'value'=>($setting['placements'] ? str_replace(ADGroup::Criteria_Separator, "<br />", $setting['placements']) : ""),
                            'type'=>'html',
                        ),
                        'note',
                    ),
                )); ?>
            </div>
        </div>
    </div>
</div>