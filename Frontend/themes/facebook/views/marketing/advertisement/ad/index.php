<?php
/* @var $this ADController */

$this->breadcrumbs=array(
    'Marketing'=>array("/marketing/home"),
    'Advertisement'=>array("/marketing/advertisement/home"),
    'AD Campaign'=>array('/marketing/advertisement/adcampaign/index'),
    'AD Group'=>array('/marketing/advertisement/adgroup'),
    'index'
);

$this->menu=array(
    array('label'=>'Test #1', 'url'=>array('/marketing/advertisement/ad/view/id/17')),
);
?>

<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<p>
	You may change the content of this page by modifying
	the file <tt><?php echo __FILE__; ?></tt>.
</p>
