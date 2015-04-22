<?php
/* @var $this EbayattributesetController */
/* @var $data eBayAttributeSet */
?>

<tr>
    <td><?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?></td>
    <td><?php echo CHtml::encode($data->name); ?></td>
    <td><?php echo CHtml::encode($data->getIsActiveText()); ?></td>
    <td><?php echo CHtml::link(CHtml::encode("Edit"), array('update', 'id'=>$data->id)); ?><!--&nbsp;|&nbsp;--><?php /*echo CHtml::linkButton('Delete',array(
            'submit'=>array('delete','id'=>$data->id),
            'confirm'=>"Are you sure to delete this attribute set?",
        )); */?></td>
</tr>

<!--<div class="view">

	<b><?php /*echo CHtml::encode($data->getAttributeLabel('id')); */?>:</b>
	<?php /*echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); */?>
	<br />

	<b><?php /*echo CHtml::encode($data->getAttributeLabel('name')); */?>:</b>
	<?php /*echo CHtml::encode($data->name); */?>
	<br />

	<b><?php /*echo CHtml::encode($data->getAttributeLabel('entity_type_id')); */?>:</b>
	<?php /*echo CHtml::encode($data->entity_type_id); */?>
	<br />

	<b><?php /*echo CHtml::encode($data->getAttributeLabel('is_active')); */?>:</b>
	<?php /*echo CHtml::encode($data->is_active); */?>
	<br />

</div>-->