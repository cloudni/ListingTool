<?php
/* @var $this EBayApiKeyController */
/* @var $data eBayApiKey */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
    <?php echo CHtml::encode($data->name); ?>
    <br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('api_url')); ?>:</b>
	<?php echo CHtml::encode($data->api_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('compatibility_level')); ?>:</b>
	<?php echo CHtml::encode($data->compatibility_level); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dev_id')); ?>:</b>
	<?php echo CHtml::encode($data->dev_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('app_id')); ?>:</b>
	<?php echo CHtml::encode($data->app_id); ?>
	<br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('cert_id')); ?>:</b>
    <?php echo CHtml::encode($data->cert_id); ?>
    <br />

    <?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time_utc')); ?>:</b>
	<?php echo CHtml::encode($data->create_time_utc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_admin_id')); ?>:</b>
	<?php echo CHtml::encode($data->create_admin_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_time_utc')); ?>:</b>
	<?php echo CHtml::encode($data->update_time_utc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_admin_id')); ?>:</b>
	<?php echo CHtml::encode($data->update_admin_id); ?>
	<br />

	*/ ?>

</div>