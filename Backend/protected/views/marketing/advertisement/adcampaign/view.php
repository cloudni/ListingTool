<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/5/26
 * Time: 14:07
 */
/* @var $this AdcampaignController */
/* @var $model ADCampaign */
$this->breadcrumbs=array(
    'AD Campaign',
);

$this->menu=array(
    array('label'=>"AD Campaign List", 'url'=>array('marketing/advertisement/adcampaign/index')),
    array('label'=>"Update AD Campaign", 'url'=>array('marketing/advertisement/adcampaign/update', 'id'=>$model->id)),
    array('label'=>'Delete AD Campaign', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>
<h1>AD Campaign: <?php echo $model->name;?></h1>

<?php
$criteria = "";
$setting = $model->criteria;
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
        $criteria .= "Location: ".str_replace(',', ', ', $setting['location'])."<br />";
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
        $schedule .= $period['day'].' From: '.$period['from_hour'].':'.$period['from_minute'].' To: '.$period['to_hour'].':'.$period['to_minute']."<br />";
    }
}
?>
<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        array(
            'label'=>"Name",
            'value'=>$model->name,
        ),
        array(
            'name'=>"Status",
            'value'=>ADCampaign::getStatusText($model->status),
        ),
        array(
            'label'=>"Budget",
            'value'=>sprintf("$%1\$.2f", $model->budget)
        ),
        array(
            'label'=>"Start Date",
            'value'=>date('Y-m-d', $model->start_datetime),
        ),
        array(
            'label'=>"End Date",
            'value'=>isset($model->end_datetime) ? date('Y-m-d', $model->start_datetime) : null,
        ),
        array(
            'label'=>"Criteria",
            'value'=>"<div style=\"word-break: break-word; width: 100%;\">".$criteria."</div>",
            'type'=>'html',
        ),
        array(
            'label'=>"Timezone",
            'value'=>isset($setting['timezone']) ? $setting['timezone'] : "",
        ),
        array(
            'label'=>"Schedule",
            'value'=>!empty($schedule) ? $schedule : 'All Time.',
            'type'=>'html',
        ),
        array(
            'label'=>"Note",
            'value'=>$model->note,
        )
    ),
)); ?>

