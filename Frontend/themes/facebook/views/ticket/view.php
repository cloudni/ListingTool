<?php
/* @var $this TicketController */
/* @var $model Ticket */
$this->pageTitle=Yii::app()->name . ' - '.ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ticket_title');
$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ticket_title')=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ticket_list_menu'), 'url'=>array('index')),
	array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ticket_create_menu'), 'url'=>array('create'))
);
?>

<style>
    table.detail-view th, table.detail-view td
    {
        font-size: 12px;
    }
</style>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;"><?php echo $model->title; ?></h1>
                </div>
            </div>
            <div style="display: block; padding: 0px 10px 0px 10px;">
                <div class="title">
                    <div>
                        <div class="author"  style="width: 535px;display: inline-block;">
                            <?php echo $model->findUserById($model->create_user_id,$model->is_user); ?>:
                        </div>
                        <div style="display: inline-block;vertical-align: bottom;text-align: right;width: 180px;">
                            on <?php echo  $model->getFormatTime('Y-m-d H:i:s',$model->create_time_utc); ?>
                        </div>
                    </div>
                    <div class="content">
                        <?php echo nl2br(CHtml::encode($model->content)); ?>
                    </div>
                    <hr>
                </div>

                <div id="replies">
                    <?php if($model->replies!=null): ?>
                        <h3> <?php echo $model->repliesCount>1 ? $model->repliesCount .Yii::t('models/Ticket','replies') : Yii::t('models/Ticket','One replies'); ?> </h3>
                        <?php $this->renderPartial('_ticket',array( 'replies'=>$model->replies,)); ?>
                    <?php endif; ?>
                    <?php if($model->parent_id==0 && $model->is_repliable==1):?>
                        <h3><?php echo Yii::t('models/Ticket','Leave a reply')?></h3>
                        <?php if(Yii::app()->user->hasFlash('replySubmitted')): ?>
                            <div class="flash-success">
                                <?php echo Yii::app()->user->getFlash('replySubmitted'); ?>
                            </div>
                            <?php  Yii::app()->clientScript->registerScript( 'fadeAndHideEffect', '$(".flash-success").animate({opacity: 1.0}, 5000). fadeOut("slow");' ); endif; ?>
                        <?php $this->renderPartial('_reply',array('model'=>$reply, )); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>



