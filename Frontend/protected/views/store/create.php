<?php
/* @var $this StoreController */
/* @var $model Store */
$this->pageTitle=Yii::app()->name . ' - '.ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'store_create_menu');
$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'store_title')=>array('index'),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'btn_create'),
);

$this->menu=array(
    array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'store_list_menu'), 'url'=>array('index')),
);
?>

<h1><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'store_create_menu') ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>