<?php
/* @var $this StoreController */
/* @var $model Store */
$this->pageTitle=Yii::app()->name . ' - '.ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'store_manage_menu');
$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'store_title')=>array('index'),
	'Manage',
);

$this->menu=array(
    array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'store_list_menu'), 'url'=>array('index')),
    array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'store_create_menu'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#store-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'store_manage_menu')?></h1>

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
	'id'=>'store-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'platform',
        'is_active',
        'ebay_api_key_id',
        'ebay_token',
		'company_id',
        'last_listing_sync_time_utc',
		'create_time_utc',
		'create_user_id',
		/*
		'update_time_utc',
		'update_user_id',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
