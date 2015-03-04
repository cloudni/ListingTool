<?php
/* @var $this DepartmentController */
/* @var $model Department */

$this->pageTitle=Yii::app()->name . ' - '.ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'departments_view_menu');
$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'departments_title')=>array('index'),
	$model->name,
);

$this->menu=array(
    array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'departments_list_menu'), 'url'=>array('index')),
    array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'departments_create_menu'), 'url'=>array('create')),
	array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'departments_update_menu'), 'url'=>array('update', 'id'=>$model->id)),
	/*array('label'=>'Delete Department', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Department', 'url'=>array('admin')),*/
    //'Update Department' View Department
);
?>

<h1><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'departments_view_menu')?>#<?php echo $model->id; ?></h1>

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
		'note',
	),
)); ?>
