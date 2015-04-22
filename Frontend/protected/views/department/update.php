<?php
/* @var $this DepartmentController */
/* @var $model Department */
$this->pageTitle=Yii::app()->name . ' - '.ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'departments_update_menu');
$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'departments_title')=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'departments_list_menu'), 'url'=>array('index')),
	array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'departments_create_menu'), 'url'=>array('create')),
	array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'departments_view_menu'), 'url'=>array('view', 'id'=>$model->id)),
	/*array('label'=>'Manage Department', 'url'=>array('admin')),*/
);
?>

<h1><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'departments_update_menu')?> <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>