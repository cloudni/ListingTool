<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - ' . $title;
$this->breadcrumbs=array(
    $bread
);
?>

<h2><?php echo $content; ?></h2>

<div class="row">
    <?php echo CHtml::link($url['name'],$url['ur']);?>
</div>