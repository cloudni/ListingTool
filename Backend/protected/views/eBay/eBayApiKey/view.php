<?php
/* @var $this EBayApiKeyController */
/* @var $model eBayApiKey */

$this->breadcrumbs=array(
	'eBay API Keys'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List eBay API Key', 'url'=>array('index')),
	array('label'=>'Create eBay API Key', 'url'=>array('create')),
	array('label'=>'Update eBay API Key', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete eBay API Key', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage eBay API Key', 'url'=>array('admin')),
);
?>

<h1>View eBay API Key #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
        'name',
		'api_url',
		'compatibility_level',
		'type',
		'dev_id',
		'app_id',
		'cert_id',
		'create_time_utc',
		'create_admin_id',
		'update_time_utc',
		'update_admin_id',
	),
)); ?>
