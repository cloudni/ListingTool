<?php
/* @var $this UserController */
/* @var $model User */
$this->pageTitle=Yii::app()->name . ' - '.ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'user_update_label');
$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'user_title')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'btn_update'),
);

$this->menu=array(
    array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'user_list_label'), 'url'=>array('index')),
    array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'user_create_label'), 'url'=>array('create')),
    array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'user_view_label'), 'url'=>array('view', 'id'=>$model->id)),
    array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'user_manage_label'), 'url'=>array('admin')),
);
?>

<h1><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'user_update_label');?><?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>