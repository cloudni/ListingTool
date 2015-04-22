<?php
/* @var $this EBayTargetAndTrackController */
/* @var $model eBayTargetAndTrack */

$this->breadcrumbs=array(
	'E Bay Target And Tracks'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List eBayTargetAndTrack', 'url'=>array('index')),
	array('label'=>'Create eBayTargetAndTrack', 'url'=>array('create')),
	array('label'=>'View eBayTargetAndTrack', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage eBayTargetAndTrack', 'url'=>array('admin')),
);
?>

<h1>Update eBayTargetAndTrack <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>