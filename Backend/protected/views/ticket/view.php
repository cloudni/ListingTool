<?php
/* @var $this TicketController */
/* @var $model Ticket */

$this->breadcrumbs=array(
	'Tickets'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Ticket', 'url'=>array('index')),
	/*array('label'=>'Create Ticket', 'url'=>array('create')),*/
	array('label'=>'Update Ticket', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Ticket', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		/*'id',
		'title',
        'content'
        'is_repliable',
		'is_viewable',
        'parent_id',
		'create_time_utc',
		'create_user_id',
		'update_time_utc',
		'update_user_id'
		'is_user',*/
        'title',
		'content',
        array(
            'name'=>'type',
            'value'=>CHtml::encode($model->getTypeText())
        ),
        array(
            'name'=>'is_repliable',
            'value'=>CHtml::encode($model->getStatusText($model->is_repliable))
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
            'name'=>'create_user_id',
            'value'=>CHtml::encode($model->findUserById($model->create_user_id,$model->is_user)),
        ),

	),
)); ?>

<div id="replies">
    <?php if($model->replies!=null): ?>
        <h3> <?php echo $model->repliesCount>1 ? $model->repliesCount . ' replies' : 'One replies'; ?> </h3>
        <?php $this->renderPartial('_ticket',array( 'replies'=>$model->replies,)); ?>
    <?php endif; ?>
    <?php if($model->parent_id==0 &&$model->is_repliable==1):?>
        <h3>Leave a reply</h3>
        <?php if(Yii::app()->user->hasFlash('replySubmitted')): ?>
            <div class="flash-success">
                <?php echo Yii::app()->user->getFlash('replySubmitted'); ?>
            </div>
        <?php  Yii::app()->clientScript->registerScript( 'fadeAndHideEffect', '$(".flash-success").animate({opacity: 1.0}, 5000). fadeOut("slow");' ); endif; ?>
        <?php $this->renderPartial('_reply',array('model'=>$reply, )); ?>
    <?php endif; ?>
</div>