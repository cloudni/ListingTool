<?php
/* @var $this NotificationController */
/* @var $data Notification */
?>

<tr>
    <td><?php echo  CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?></td>
    <td><?php echo CHtml::encode($data->title); ?></td>
    <td><?php echo substr((CHtml::encode($data->content)),0,15)."..."; ?></td>
    <td><?php echo CHtml::encode($data->Company->name); ?></td>
    <td>
        <?php echo date("Y-m-d h:i:sa", (CHtml::encode($data->create_time_utc))) ; ?>
    </td>
    <td><?php echo CHtml::link(CHtml::encode("Edit"), array('update', 'id'=>$data->id)); ?>&nbsp;|&nbsp;
        <?php echo CHtml::linkButton('Delete',array(
            'submit'=>array('delete','id'=>$data->id),
            'confirm'=>"Are you sure to delete this notification?",
        )); ?></td>

</tr>