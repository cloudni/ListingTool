<?php
$this->breadcrumbs=array(
	'Picture Folders'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List PictureFolder', 'url'=>array('index')),
	array('label'=>'Create PictureFolder', 'url'=>array('create')),
	array('label'=>'Update PictureFolder', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PictureFolder', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PictureFolder', 'url'=>array('admin')),
);
?>

<h1>View PictureFolder #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'parent_id',
		'create_time_utc',
		'create_user_id',
		'update_time_utc',
		'update_user_id',
	),
)); ?>
