<?php
/* @var $this BulletinController */
/* @var $data Bulletin */
?>

<tr>
    <?php if($data->is_top==Bulletin::STATUS_TRUE):?>
        <td class="prominent">
            <span><?php echo CHtml::link(CHtml::encode($data->title),array('view','id'=>$data->id));?></span>
        </td>
    <?php else: ?>
        <td >
           <span><?php echo CHtml::link(CHtml::encode($data->title),array('view','id'=>$data->id));?></span>
        </td>
    <?php endif; ?>
        <?php /*echo CHtml::link(CHtml::encode($data->title), array('view', 'id'=>$data->id)); */?>
    <td>
        <span><?php echo CHtml::encode($data->content); ?></span>
    </td>
    <td>
        <?php echo CHtml::encode($data->getFormatTime('Y-m-d H:i:s',$data->create_time_utc)); ?>
    </td>
</tr>