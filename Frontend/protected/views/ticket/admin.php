<?php
/* @var $this TicketController */
/* @var $model Ticket */

$this->breadcrumbs=array(
	'Tickets'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Ticket', 'url'=>array('index')),
	/*array('label'=>'Create Ticket', 'url'=>array('create')),*/
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#ticket-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Tickets</h1>

<p>
    <?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'seach_prompt')?>
</p>

<?php echo CHtml::link(Yii::t('Common','Advanced Search'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ticket-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'content',
		'type',
		'is_repliable',
		'is_viewable',
		/*
		'parent_id',
		'create_time_utc',
		'create_user_id',
		'update_time_utc',
		'update_user_id',
		'is_user',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
