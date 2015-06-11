<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/5/26
 * Time: 14:34
 */
/* @var $this AdcampaignController */
/* @var $model ADCampaign */
$this->breadcrumbs=array(
    'AD Campaign',
);

$this->menu=array(
    array('label'=>"AD Campaign List", 'url'=>array('marketing/advertisement/adcampaign/index')),
    array('label'=>"View AD Campaign", 'url'=>array('marketing/advertisement/adcampaign/view', 'id'=>$model->id)),
    array('label'=>'Delete AD Campaign', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>
<h1>AD Campaign: <?php echo $model->name;?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>