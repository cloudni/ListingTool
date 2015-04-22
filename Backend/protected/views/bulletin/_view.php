<?php
/* @var $this BulletinController */
/* @var $data Bulletin */
?>

<!--<div class="view">

	<b><?php /*echo CHtml::encode($data->getAttributeLabel('id')); */?>:</b>
	<?php /*echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); */?>
	<br />

	<b><?php /*echo CHtml::encode($data->getAttributeLabel('title')); */?>:</b>
	<?php /*echo CHtml::encode($data->title); */?>
	<br />

	<b><?php /*echo CHtml::encode($data->getAttributeLabel('content')); */?>:</b>
	<?php /*echo CHtml::encode($data->content); */?>
	<br />


	<b><?php /*echo CHtml::encode($data->getAttributeLabel('is_top')); */?>:</b>
	<?php /*echo CHtml::encode($data->getStatusText($data->is_top)); */?>
	<br />

	<b><?php /*echo CHtml::encode($data->getAttributeLabel('is_viewable')); */?>:</b>
	<?php /*echo CHtml::encode($data->getStatusText($data->is_viewable)); */?>
	<br />

	<b><?php /*echo CHtml::encode($data->getAttributeLabel('create_time_utc')); */?>:</b>
	<?php /*echo CHtml::encode($data->getFormatTime('Y-m-d H:i:s',$data->create_time_utc)); */?>
	<br />

</div>-->

<tr>
    <td><?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?></td>
    <?php if($data->is_top==Bulletin::STATUS_TRUE):?>
        <td class="prominent">
            <span><?php echo CHtml::link(CHtml::encode($data->title),array('view','id'=>$data->id));?></span>
        </td>
    <?php else: ?>
        <td >
            <span><?php echo CHtml::link(CHtml::encode($data->title),array('view','id'=>$data->id));?></span>
        </td>
    <?php endif; ?>
    <td>
        <span><?php echo CHtml::encode($data->content); ?></span>
    </td>
    <td><?php echo CHtml::encode($data->getStatusText($data->is_top)); ?></td>
    <td><?php echo CHtml::encode($data->getStatusText($data->is_viewable)); ?></td>
    <td>
        <?php echo CHtml::encode($data->getFormatTime('Y-m-d H:i:s',$data->create_time_utc)); ?>
    </td>
</tr>