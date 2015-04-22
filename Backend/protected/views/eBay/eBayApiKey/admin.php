<?php
/* @var $this EBayApiKeyController */
/* @var $model eBayApiKey */

$this->breadcrumbs=array(
	'eBay API Keys'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List eBay API Key', 'url'=>array('index')),
	array('label'=>'Create eBay API Key', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#e-bay-api-key-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage eBay API Keys</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'e-bay-api-key-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'api_url',
		'compatibility_level',
		'type',
		'name',
		'dev_id',
		/*
		'app_id',
		'cert_id',
		'create_time_utc',
		'create_admin_id',
		'update_time_utc',
		'update_admin_id',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
