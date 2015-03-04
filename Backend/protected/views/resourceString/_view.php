<?php
/* @var $this ResourceStringController */
/* @var $data ResourceString */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('key')); ?>:</b>
	<?php echo CHtml::encode($data->key); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('language')); ?>:</b>
	<?php echo CHtml::encode($data->language); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('environment')); ?>:</b>
	<?php echo CHtml::encode($data->environment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('message')); ?>:</b>
	<?php echo CHtml::encode($data->message); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time_utc')); ?>:</b>
	<?php echo CHtml::encode($data->create_time_utc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_admin_id')); ?>:</b>
	<?php echo CHtml::encode($data->create_admin_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('update_time_utc')); ?>:</b>
	<?php echo CHtml::encode($data->update_time_utc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_admin_id')); ?>:</b>
	<?php echo CHtml::encode($data->update_admin_id); ?>
	<br />

	*/ ?>

</div>