<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Email';
$this->breadcrumbs=array(
    'Email',
);
?>

<h2><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'email_reset_password')?></h2>
<div class="row">
    <div><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'email_prompt')?></div>
</div>