<?php
/* @var $this EbayattributesetController */
/* @var $model eBayAttributeSet */

$this->breadcrumbs=array(
	'eBay Attribute Sets'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List eBayAttributeSet', 'url'=>array('index')),
	array('label'=>'Create eBayAttributeSet', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#e-bay-attribute-set-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage eBay Attribute Sets</h1>

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
	'id'=>'ebay-attribute-set-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'entity_type_id',
		'is_active',
        /*
        'sort_order',
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
