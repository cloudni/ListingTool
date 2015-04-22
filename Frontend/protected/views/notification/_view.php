<?php
/* @var $this NotificationController */
/* @var $data Notification */
?>

<tr>
    <td><?php echo CHtml::link(CHtml::encode($data->title), array('view', 'id'=>$data->id)); ?></td>
    <td><?php echo substr((CHtml::encode($data->content)),0,15)."..."; ?></td>
    <td><?php echo CHtml::encode($data->company->name); ?></td>
    <td>
        <?php if($data->is_important==0): ?>
        <?php echo "NO" ?>
        <?php else: ?>
            <?php echo CHtml::link('close important', array('close', 'id'=>$data->id)); ?>
        <?php endif; ?>
    </td>
       <!-- <?php /*echo CHtml::encode($data->is_import,$data->getIsImportOptions()); */?></td>-->
    <?php /*echo $form->dropDownList($model,'is_import', $model->getIsImportOptions()); */?>
    <td>
        <?php echo date("Y-m-d h:i:sa", (CHtml::encode($data->create_time_utc))) ; ?>
    </td>
    <!--<td><?php /*echo CHtml::link(CHtml::encode("Edit"), array('update', 'id'=>$data->id)); */?>&nbsp;|&nbsp;
        <?php /*echo CHtml::linkButton('Delete',array(
            'submit'=>array('delete','id'=>$data->id),
            'confirm'=>"Are you sure to delete this notification?",
        )); */?></td>-->

</tr>