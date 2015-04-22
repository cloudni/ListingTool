<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/4/13
 * Time: 14:24
 */

/* @var $this ADCampaignController */
/* @var $model Store */

$this->breadcrumbs=array(
    'Marketing'=>array("/marketing/home"),
    'Advertisement'=>array("/marketing/advertisement/home"),
    'AD Campaign'=>array('index'),
    'Update',
    $model->name
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>