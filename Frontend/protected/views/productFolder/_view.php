<?php
/* @var $this ProductFolderController */
/* @var $data ProductFolder */
?>

<!--<div class="view">

	<b><?php /*echo CHtml::encode($data->getAttributeLabel('id')); */?>:</b>
	<?php /*echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); */?>
	<br />

	<b><?php /*echo CHtml::encode($data->getAttributeLabel('name')); */?>:</b>
	<?php /*echo CHtml::encode($data->name); */?>
	<br />

	<b><?php /*echo CHtml::encode($data->getAttributeLabel('parent_id')); */?>:</b>
	<?php /*echo CHtml::encode($data->parent_id); */?>
	<br />

	<b><?php /*echo CHtml::encode($data->getAttributeLabel('company_id')); */?>:</b>
	<?php /*echo CHtml::encode($data->company_id); */?>
	<br />

	<b><?php /*echo CHtml::encode($data->getAttributeLabel('create_time_utc')); */?>:</b>
	<?php /*echo CHtml::encode($data->create_time_utc); */?>
	<br />

	<b><?php /*echo CHtml::encode($data->getAttributeLabel('create_user_id')); */?>:</b>
	<?php /*echo CHtml::encode($data->create_user_id); */?>
	<br />

	<b><?php /*echo CHtml::encode($data->getAttributeLabel('update_time_utc')); */?>:</b>
	<?php /*echo CHtml::encode($data->update_time_utc); */?>
	<br />


</div>-->

<tr>
    <td >
        <span><?php echo CHtml::link(CHtml::encode($data->name),array('view','id'=>$data->id));?></span>
    </td>
    <td>
        <span><?php echo CHtml::encode($data->create_user_id); ?></span>
    </td>
    <td>
        <?php echo CHtml::encode(Helper::getFormatTime('Y-m-d H:i:s',$data->create_time_utc)); ?>
    </td>
</tr>