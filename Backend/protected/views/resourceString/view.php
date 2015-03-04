<?php
/* @var $this ResourceStringController */
/* @var $model ResourceString */

$this->breadcrumbs=array(
	'Resource Strings'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ResourceString', 'url'=>array('index')),
	array('label'=>'Create ResourceString', 'url'=>array('create')),
	array('label'=>'Update ResourceString', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ResourceString', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ResourceString', 'url'=>array('admin')),
);
?>

<h1>View ResourceString #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'key',
		'language',
		'environment',
		'message',
		'create_time_utc',
		'create_admin_id',
		'update_time_utc',
		'update_admin_id',
	),
)); ?>
