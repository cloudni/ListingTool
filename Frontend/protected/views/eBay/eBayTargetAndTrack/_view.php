<?php
/* @var $this EBayTargetAndTrackController */
/* @var $data eBayTargetAndTrack */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('company_id')); ?>:</b>
	<?php echo CHtml::encode($data->company_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('target_ebay_item_id')); ?>:</b>
	<?php echo CHtml::encode($data->target_ebay_item_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tracking_ebay_listing_id')); ?>:</b>
	<?php echo CHtml::encode($data->tracking_ebay_listing_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_param')); ?>:</b>
	<?php echo CHtml::encode($data->update_param); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('note')); ?>:</b>
	<?php echo CHtml::encode($data->note); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time_utc')); ?>:</b>
	<?php echo CHtml::encode($data->create_time_utc); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('create_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->create_user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_time_utc')); ?>:</b>
	<?php echo CHtml::encode($data->update_time_utc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->update_user_id); ?>
	<br />

	*/ ?>

</div>