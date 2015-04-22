<?php
/* @var $this EBayTargetAndTrackController */
/* @var $model eBayTargetAndTrack */

$this->breadcrumbs=array(
	'E Bay Target And Tracks'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List eBayTargetAndTrack', 'url'=>array('index')),
	array('label'=>'Create eBayTargetAndTrack', 'url'=>array('create')),
	array('label'=>'Update eBayTargetAndTrack', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete eBayTargetAndTrack', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage eBayTargetAndTrack', 'url'=>array('admin')),
);
?>

<h1>View eBayTargetAndTrack #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'company_id',
		'target_ebay_item_id',
		'tracking_ebay_listing_id',
		'update_param',
		'note',
		'create_time_utc',
		'create_user_id',
		'update_time_utc',
		'update_user_id',
	),
)); ?>
