<?php
/* @var $this StoreController */
/* @var $data Store */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->name), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('platform')); ?>:</b>
    <?php echo CHtml::encode($data->getPlatformText()); ?>

    <b><?php echo CHtml::encode($data->getAttributeLabel('last_listing_sync_time_utc')); ?>:</b>
    <?php echo CHtml::encode(date("Y/m/d h:i:sa", $data->last_listing_sync_time_utc)); ?>
    <br />

</div>