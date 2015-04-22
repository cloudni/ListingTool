<?php
/* @var $this TicketController */
/* @var $model Ticket */
$this->pageTitle=Yii::app()->name . ' - '.ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ticket_create_menu');
$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ticket_title')=>array('index'),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'btn_create'),
);

$this->menu=array(
	array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ticket_list_menu'), 'url'=>array('index')),
	/*array('label'=>'Manage Ticket', 'url'=>array('admin')),*/
);
?>

<h1><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ticket_create_menu') ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>