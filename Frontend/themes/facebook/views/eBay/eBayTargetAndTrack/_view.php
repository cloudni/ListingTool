<?php
/* @var $this EBayTargetAndTrackController */
/* @var $data eBayTargetAndTrack */
?>

<tr>
    <td><?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?></td>
    <td><?php echo CHtml::encode($data->name); ?></td>
    <td><?php echo CHtml::encode($data->CreateUser->username); ?></td>
    <td><?php echo CHtml::encode($data->note); ?></td>
    <td><?php echo CHtml::link(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'view'), array('view', 'id'=>$data->id)); ?> | <?php echo CHtml::link(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'update'), array('update', 'id'=>$data->id)); ?></td>
</tr>