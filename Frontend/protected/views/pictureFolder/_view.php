<tr>
    <td><?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?></td>
    <td><?php echo CHtml::encode($data->name); ?></td>
    <td><?php echo CHtml::encode($data->parent_id); ?></td>
    <td><?php echo CHtml::encode($data->create_user_id); ?></td>
    <td><?php echo CHtml::link(CHtml::encode("Edit"), array('', 'id'=>$data->id)); ?>&nbsp;|&nbsp;
        <?php echo CHtml::linkButton('Delete',array(
            'submit'=>array('delete','id'=>$data->id),
            'confirm'=>"Are you sure to delete this attribute set?",
        )); ?></td>
</tr>
