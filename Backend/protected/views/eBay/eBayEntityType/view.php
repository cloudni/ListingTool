<?php
/* @var $this EbayentitytypeController */
/* @var $model eBayEntityType */

$this->breadcrumbs=array(
	'eBay Entity Types'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List eBayEntityType', 'url'=>array('index')),
	array('label'=>'Create eBayEntityType', 'url'=>array('create')),
	array('label'=>'Update eBayEntityType', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete eBayEntityType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage eBayEntityType', 'url'=>array('admin')),
);
?>

<h1>View eBayEntityType #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'entity_table',
		'entity_model',
		'attribute_table',
		'attribute_model',
		'value_table',
		'value_model',
		'create_time_utc',
		'create_admin_id',
		'update_time_utc',
		'update_admin_id',
	),
)); ?>
