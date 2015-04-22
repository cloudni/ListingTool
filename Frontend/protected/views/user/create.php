<?php
/* @var $this UserController */
/* @var $model User */
$this->pageTitle=Yii::app()->name . ' - '.ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'user_create_title');
$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'user_list_label')=>array('index'),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'btn_create'),
);

$this->menu=array(
	array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'user_list_label'), 'url'=>array('index')),
	array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'user_manage_label'), 'url'=>array('admin')),
);
?>

<h1><?php echo CHtml::label(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'user_create_title'),false);?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>