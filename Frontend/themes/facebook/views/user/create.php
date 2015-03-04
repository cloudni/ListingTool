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
);
?>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'user_create_title') ?></h1>
                </div>
            </div>
            <div style="display: block; padding: 0px 10px 0px 10px;">
                <?php $this->renderPartial('_form', array('model'=>$model)); ?>
            </div>
        </div>
    </div>
</div>

