<?php
/* @var $this TicketController */
/* @var $data Ticket */
?>


<tr>
    <td><?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?></td>
    <td><?php echo CHtml::encode($data->title); ?></td>
    <td><?php echo CHtml::encode($data->content); ?></td>
    <td><?php echo CHtml::encode($data->getTypeText()); ?></td>
    <td>
        <?php if($data->is_new==1): ?>
            <span style="color: red">new</span>
        <?php endif; ?>
        <?php if($data->is_new==0): ?>
            <span style="color: #cccccc;">new</span>
        <?php endif; ?>
    </td>
    <td><?php echo CHtml::encode(CHtml::encode($data->findUserById($data->create_user_id,$data->is_user))); ?></td>
    <td><?php echo CHtml::encode(Ticket::model()->count('is_repliable =1 and is_viewable = 1 and parent_id=:id',array(":id"=>$data->id))); ?></td>
</tr>


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

	<b><?php /*echo CHtml::encode($data->getAttributeLabel('type')); */?>:</b>
	<?php /*echo CHtml::encode($data->getTypeText()); */?>
	<br />

	<b><?php /*echo CHtml::encode($data->getAttributeLabel('is_repliable')); */?>:</b>
	<?php /*echo CHtml::encode($data->getStatusText($data->is_repliable)); */?>
	<br />

	<b><?php /*echo CHtml::encode($data->getAttributeLabel('is_viewable')); */?>:</b>
	<?php /*echo CHtml::encode($data->getStatusText($data->is_viewable)); */?>
	<br />

    <b><?php /*echo CHtml::encode($data->getAttributeLabel('create_user_id')); */?>:</b>
    <?php /*echo CHtml::encode(CHtml::encode($data->findUserById($data->create_user_id,$data->is_user))); */?>
    <br />
</div>-->