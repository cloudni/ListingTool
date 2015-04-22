<?php
/* @var $this EbayattributeController */
/* @var $data eBayAttribute */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('backend_type')); ?>:</b>
	<?php echo CHtml::encode($data->backend_type); ?>
	<br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('size')); ?>:</b>
    <?php echo CHtml::encode($data->size); ?>
    <br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('frontend_input')); ?>:</b>
	<?php echo CHtml::encode($data->frontend_input); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('frontend_label')); ?>:</b>
	<?php echo CHtml::encode($data->frontend_label); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('note')); ?>:</b>
	<?php echo CHtml::encode($data->note); ?>
	<br />

	<!--<b><?php /*echo CHtml::encode($data->getAttributeLabel('create_time_utc')); */?>:</b>
	<?php /*echo CHtml::encode($data->create_time_utc); */?>
	<br />

	<b><?php /*echo CHtml::encode($data->getAttributeLabel('create_admin_id')); */?>:</b>
	<?php /*echo CHtml::encode($data->create_admin_id); */?>
	<br />

	<b><?php /*echo CHtml::encode($data->getAttributeLabel('update_time_utc')); */?>:</b>
	<?php /*echo CHtml::encode($data->update_time_utc); */?>
	<br />

	<b><?php /*echo CHtml::encode($data->getAttributeLabel('update_admin_id')); */?>:</b>
	<?php /*echo CHtml::encode($data->update_admin_id); */?>
	<br />-->

</div>