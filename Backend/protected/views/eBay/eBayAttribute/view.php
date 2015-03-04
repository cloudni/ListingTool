<?php
/* @var $this EbayattributeController */
/* @var $model eBayAttribute */

$this->breadcrumbs=array(
	'eBay Attributes'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List eBayAttribute', 'url'=>array('index')),
	array('label'=>'Create eBayAttribute', 'url'=>array('create')),
	array('label'=>'Update eBayAttribute', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete eBayAttribute', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage eBayAttribute', 'url'=>array('admin')),
);
?>

<h1>View eBayAttribute #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'backend_type',
        'size',
		'frontend_input',
		'frontend_label',
		'note',
		'create_time_utc',
		'create_admin_id',
		'update_time_utc',
		'update_admin_id',
	),
)); ?>
