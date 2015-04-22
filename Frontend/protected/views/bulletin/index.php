<?php
/* @var $this BulletinController */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle=Yii::app()->name . ' - '.ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'label_bulletin');
$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'label_bulletin'),
);

/*$this->menu=array(
	array('label'=>'Create Bulletin', 'url'=>array('create')),
	array('label'=>'Manage Bulletin', 'url'=>array('admin')),
);
*/?>

<div class="bulletin-list">
    <div class="panel-title"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'label_bulletin'); ?></div>
    <table class="panel-table">
        <thead>
            <th><?php echo Yii::t('models/Bulletins','Title');?></th>
            <th><?php echo Yii::t('models/Bulletins','Content');?></th>
            <th><?php echo Yii::t('models/Bulletins','Create time');?></th>
        </thead>
        <tbody>
        <?php $this->widget('zii.widgets.CListView', array(
            'dataProvider'=>$dataProvider,
            'itemView'=>'_view',
        )); ?>
        </tbody>
    </table>
</div>



