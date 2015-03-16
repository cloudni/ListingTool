<?php
/* @var $this NotificationController */
/* @var $data Notification */
?>

<tr>
    <td><?php echo CHtml::link(CHtml::encode($data->title), array('view', 'id'=>$data->id)); ?></td>
    <td><?php echo substr((CHtml::encode($data->content)),0,15)."..."; ?></td>
    <td><?php echo CHtml::encode($data->Company->name); ?></td>
    <td>
        <?php if($data->is_new==0): ?>
        <?php echo "Yes" ?>
        <?php else: ?>
            <?php echo "No" ?>
        <?php endif; ?>
    </td>
    <td>
        <?php echo date("Y-m-d h:i:sa", (CHtml::encode($data->create_time_utc))) ; ?>
    </td>
</tr>