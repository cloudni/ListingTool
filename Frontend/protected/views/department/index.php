<?php
/* @var $this DepartmentController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle=Yii::app()->name . ' - '.ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'departments_title');
$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'departments_title'),
);

$this->menu=array(
	array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'departments_create_menu'), 'url'=>array('create')),
	/*array('label'=>'Manage Department', 'url'=>array('admin')),*/
);
?>

<h1><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'departments_title') ?></h1>
<div class="grid-view">
<table class="items" width="100%">
    <tr>
        <th><?php echo Yii::t('models/Department','ID') ?></th>
        <th><?php echo Yii::t('models/Department','Name') ?></th>
        <th><?php echo Yii::t('models/Department','Parent') ?></th>
        <th><?php echo Yii::t('models/Department','Company') ?></th>
        <th><?php echo Yii::t('models/Department','Create User') ?></th>
        <th><?php echo Yii::t('models/Department','Action') ?></th>
    </tr>
    <?php $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$dataProvider,
        'itemView'=>'_view',
    )); ?>
</table>
</div>
