<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - '.ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'menu_help_about');
$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'menu_help_about'),
);
?>
<h1><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'menu_help_about');?></h1>

<p>This is a "static" page. You may change the content of this page
by updating the file <code><?php echo __FILE__; ?></code>.</p>
