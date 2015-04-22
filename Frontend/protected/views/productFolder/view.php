<?php
/* @var $this ProductFolderController */
/* @var $model ProductFolder */

$this->breadcrumbs=array(
	'Product Folders'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List ProductFolder', 'url'=>array('index')),
	array('label'=>'Create ProductFolder', 'url'=>array('create')),
	array('label'=>'Update ProductFolder', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ProductFolder', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>View ProductFolder #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
        'name',
        'parent_id',
        'company_id',
        'create_time_utc',
        'create_user_id',
        'update_time_utc',
        'update_user_id',
	),
)); ?>

<br/>
<h3>ChildProductFolder Tree</h3>

<?php $this->widget('ext.zTree.zTree',array(
    'data'=>array(
        'key'=>array('name'=>'name'),
        'simpleDate'=>array(
            'enable'=>false,//Set zTree's node to accept the simple data format, when zTree is initialized or when ajax get / or when use addNodes method.
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
    'htmlOptions'=>array('id'=>'attribute_has','name'=>'attribute_has','style'=>'overflow-y: scroll; overflow-x: auto;'),
    'input'=>$productFolder,
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
