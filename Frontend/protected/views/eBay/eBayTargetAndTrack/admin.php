<?php
/* @var $this EBayTargetAndTrackController */
/* @var $model eBayTargetAndTrack */

$this->breadcrumbs=array(
	'E Bay Target And Tracks'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List eBayTargetAndTrack', 'url'=>array('index')),
	array('label'=>'Create eBayTargetAndTrack', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#e-bay-target-and-track-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage E Bay Target And Tracks</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'e-bay-target-and-track-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'company_id',
		'target_ebay_item_id',
		'tracking_ebay_listing_id',
		'update_param',
		'note',
		/*
		'create_time_utc',
		'create_user_id',
		'update_time_utc',
		'update_user_id',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>