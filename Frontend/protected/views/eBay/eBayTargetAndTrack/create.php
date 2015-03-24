<?php
/* @var $this EBayTargetAndTrackController */
/* @var $model eBayTargetAndTrack */

$this->breadcrumbs=array(
	'E Bay Target And Tracks'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List eBayTargetAndTrack', 'url'=>array('index')),
	array('label'=>'Manage eBayTargetAndTrack', 'url'=>array('admin')),
);
?>

<h1>Create eBayTargetAndTrack</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>