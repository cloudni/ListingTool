<?php
/* @var $this EbayentitytypeController */
/* @var $model eBayEntityType */

$this->breadcrumbs=array(
	'eBay Entity Types'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List eBayEntityType', 'url'=>array('index')),
	array('label'=>'Create eBayEntityType', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#e-bay-entity-type-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage eBay Entity Types</h1>

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
	'id'=>'e-bay-entity-type-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'entity_table',
		'entity_model',
		'attribute_table',
		'attribute_model',
		'value_table',
		'value_model',
		/*
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
