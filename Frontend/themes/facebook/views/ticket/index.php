<?php
/* @var $this TicketController */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle=Yii::app()->name . ' - '.ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ticket_title');
$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ticket_title'),
);

$this->menu=array(
	array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ticket_create_menu'), 'url'=>array('create')),
	/*array('label'=>'Manage Ticket', 'url'=>array('admin')),*/
);
?>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ticket_title') ?></h1>
                </div>
            </div>
            <div style="display: block;">
                <table>
                    <thead>
                    <th><?php echo Yii::t('models/Ticket','ID') ?></th>
                    <th><?php echo Yii::t('models/Ticket','Title') ?></th>
                    <th><?php echo Yii::t('models/Ticket','Content') ?></th>
                    <th><?php echo Yii::t('models/Ticket','Type') ?></th>
                    <th><?php echo Yii::t('models/Ticket','New') ?></th>
                    <th><?php echo Yii::t('models/Ticket','Create User') ?></th>
                    <th><?php echo Yii::t('models/Ticket','RepliesCount') ?></th>
                    </thead>
                    <tbody>
                    <?php $this->widget('zii.widgets.CListView', array(
                        'dataProvider'=>$dataProvider,
                        'itemView'=>'_view',
                    )); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


