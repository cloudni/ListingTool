<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/4/13
 * Time: 13:45
 */

/* @var $this ADCampaignController */
/* @var $model AdCampaign */

$this->breadcrumbs=array(
    'Marketing'=>array("/marketing/home"),
    'Advertisement'=>array("/marketing/advertisement/home"),
    'Campaign'=>array('index'),
    $model->name,
);

$this->menu=array(
    array('label'=>'Campaign Index', 'url'=>array('index')),
    array('label'=>'Campaign Create', 'url'=>array('create')),
    array('label'=>'Campaign Update', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Campaign Delete', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('models/AdCampaign','Are you sure you want to delete this Campaign?'))),
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
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;">AD Campaign: <?php echo $model->name; ?></h1>
                </div>
            </div>
            <div style="display: block;">
                <?php
                $criteria = "";
                $setting = (array)json_decode($model->criteria);
                if(isset($setting['language']))
                {
                    if(!empty($setting['language']))
                        $criteria .= "Language: ".$setting['language']."<br />";
                    else
                        $criteria .= "Language: All Languages."."<br />";
                }
                else
                {
                    $criteria .= "Language: All Languages."."<br />";
                }
                if(isset($setting['location']))
                {
                    if(!empty($setting['location']))
                        $criteria .= "Location: ".$setting['location']."<br />";
                    else
                        $criteria .= "Location: All Countries and Regions."."<br />";
                }
                else
                {
                    $criteria .= "Location: All Countries and Regions."."<br />";
                }
                $schedule = "";
                if(isset($setting['schedule']) && !empty($setting['schedule']))
                {
                    foreach($setting['schedule'] as $period)
                    {
                        $period = (array)$period;
                        $schedule .= $period['day'].' '.$period['from_hour'].':'.$period['from_minute'].' to '.$period['to_hour'].':'.$period['to_minute']."<br />";
                    }
                }
                ?>
                <?php $this->widget('zii.widgets.CDetailView', array(
                    'data'=>$model,
                    'attributes'=>array(
                        'name',
                        array(
                            'name'=>'status',
                            'value'=>AdCampaign::getStatusText($model->status),
                        ),
                        array(
                            'label'=>'Budget',
                            'value'=>sprintf("$%1\$.2f", $model->budget)
                        ),
                        array(
                            'label'=>'Start Datetime',
                            'value'=>date('Y-m-d', $model->start_datetime),
                        ),
                        array(
                            'label'=>'End Datetime',
                            'value'=>isset($model->end_datetime) ? date('Y-m-d', $model->start_datetime) : null,
                        ),
                        array(
                            'label'=>"Criteria",
                            'value'=>$criteria,
                            'type'=>'html',
                        ),
                        array(
                            'label'=>'TimeZone',
                            'value'=>$setting['timezone'],
                        ),
                        array(
                            'label'=>'Schedule',
                            'value'=>!empty($schedule) ? $schedule : 'All Time.',
                            'type'=>'html',
                        ),
                        'note',
                    ),
                )); ?>
            </div>
        </div>
    </div>
</div>