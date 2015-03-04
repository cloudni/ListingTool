<?php
/* @var $this CompanyController */
/* @var $data Company */
?>

<tr>
    <td><?php echo  CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?></td>
    <td><?php echo CHtml::encode($data->name); ?></td>
    <td><?php echo CHtml::encode($data->phone); ?></td>
    <td>
        <?php echo CHtml::encode($data->country); ?>
    </td>

</tr>