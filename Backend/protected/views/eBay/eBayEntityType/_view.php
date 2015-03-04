<?php
/* @var $this EbayentitytypeController */
/* @var $data eBayEntityType */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('entity_table')); ?>:</b>
	<?php echo CHtml::encode($data->entity_table); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('entity_model')); ?>:</b>
	<?php echo CHtml::encode($data->entity_model); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('attribute_table')); ?>:</b>
	<?php echo CHtml::encode($data->attribute_table); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('attribute_model')); ?>:</b>
	<?php echo CHtml::encode($data->attribute_model); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('value_table')); ?>:</b>
	<?php echo CHtml::encode($data->value_table); ?>
	<br />

	</b>	<?php echo CHtml::encode($data->getAttributeLabel('value_model')); ?>:</b>
	<?php echo CHtml::encode($data->value_model); ?>
	<br />

<!--	<b><?php /*echo CHtml::encode($data->getAttributeLabel('create_time_utc')); */?>:</b>
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