<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/4/15
 * Time: 23:45
 */

/* @var $this ADGroupController */
/* @var $model ADGroup */

$this->breadcrumbs=array(
    'Marketing'=>array("/marketing/home"),
    'Advertisement'=>array("/marketing/advertisement/home"),
    'AD Campaign'=>array('/marketing/advertisement/adcampaign/index'),
    'AD Group'=>array('index'),
    'Update',
    $model->name,
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>