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

<h1><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ticket_title') ?></h1>

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
