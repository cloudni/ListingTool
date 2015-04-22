<?php
/* @var $this EbayattributesetController */
/* @var $model eBayAttributeSet */

$this->breadcrumbs=array(
	'eBay Attribute Sets'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List eBayAttributeSet', 'url'=>array('index')),
	array('label'=>'Create eBayAttributeSet', 'url'=>array('create')),
	array('label'=>'Update eBayAttributeSet', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete eBayAttributeSet', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>View eBayAttributeSet #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'entity_type_id',
		'is_active',
		/*'sort_order',*/
		'create_time_utc',
		'create_admin_id',
		'update_time_utc',
		'update_admin_id',
	),
)); ?>
<br/>
<h3>Attribute Tree</h3>

<?php $this->widget('ext.zTree.zTree',array(
    'data'=>array(
        'key'=>array('name'=>'name'),
        'simpleData'=>array(
            'enable'=>true,//Set zTree's node to accept the simple data format, when zTree is initialized or when ajax get / or when use addNodes method.
            'idKey'=>'id',//The node data's attribute to save node data's unique identifier. It is valid when [setting.data.simpleData.enable = true]
            'pIdKey'=>'pId',
        ),
    ),
    'view'=>array(
        'expandSpeed'=>"",
        'showLine'=>true,
        'selectedMulti'=>false,
        'showIcon'=>false,
        'autoCancelSelected'=>true,
    ),
    'edit'=>array(
        'enable'=>false,
    ),
    //'backgroundTagName'=>'div',
    'htmlOptions'=>array('style'=>'overflow-y: scroll; overflow-x: auto;'),
    'input'=>$attributeList,
    /*'input'=>array(
        array(
            'id'=>1,
            'parent_id'=>0,
            'name'=>'目录1',
            'children'=>array(
                array(
                    'id'=>2,
                    'parent_id'=>1,
                    'name'=>'目录2',
                    'children'=>array(
                        array('id'=>5, 'parent_id'=>2, 'name'=>'目录5'),
                    ),
                ),
                array(
                    'id'=>3,
                    'parent_id'=>1,
                    'name'=>'目录3',
                    'children'=>array(
                        array('id'=>6, 'parent_id'=>3, 'name'=>'目录6')
                    ),
                ),
                array('id'=>4, 'parent_id'=>1, 'name'=>'目录4'),
            ),
        ),
    ),*/
    /*'model'=>'eBayEntityAttribute',
    'criteria'=>$criteria,*/
 )); ?>
