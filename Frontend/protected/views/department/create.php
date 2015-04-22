<?php
/* @var $this DepartmentController */
/* @var $model Department */

$this->pageTitle=Yii::app()->name . ' - '.ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'departments_create_menu');
$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'departments_title')=>array('index'),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'btn_create'),
);

$this->menu=array(
	array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'departments_list_menu'), 'url'=>array('index')),
	/*array('label'=>'Manage Department', 'url'=>array('admin')),*/
);
?>

<h1><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'departments_create_menu') ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>