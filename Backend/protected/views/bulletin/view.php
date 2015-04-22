<?php
/* @var $this BulletinController */
/* @var $model Bulletin */

$this->breadcrumbs=array(
	'Bulletins'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Bulletin', 'url'=>array('index')),
	array('label'=>'Create Bulletin', 'url'=>array('create')),
	array('label'=>'Update Bulletin', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Bulletin', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<!--<div class="span-19">
    <div style="text-align: center;">
        <h1><?php /*echo $model->title; */?></h1>
    </div>
    <div>

    </div>
</div>-->
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
        'id',
        'title',
		'content',
        array(
            'name'=>'is_top',
            'value'=>CHtml::encode($model->getStatusText($model->is_viewable))
        ),
        array(
            'name'=>'is_viewable',
            'value'=>CHtml::encode($model->getStatusText($model->is_viewable))
        ),
        array(
            'name'=>'create_time_utc',
            'value'=>CHtml::encode($model->getFormatTime('Y-m-d H:i:s',$model->create_time_utc))
        ),
        array(
            'name'=>'create_admin_id',
            'value'=>CHtml::encode($model->Admin->username)
        ),
        array(
            'name'=>'owner',
            'value'=>CHtml::encode($model->getOwnerStatusText($model->owner))
        ),
	),
)); ?>
