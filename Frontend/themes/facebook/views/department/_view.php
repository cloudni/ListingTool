<?php
/* @var $this DepartmentController */
/* @var $data Department */
?>

<tr>
    <td><?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?></td>
    <td><?php echo CHtml::encode($data->name); ?></td>
    <td><?php echo CHtml::encode(isset($data->parentDepartment) ? $data->parentDepartment->name : null); ?></td>
    <td>
        <?php echo CHtml::link(CHtml::encode(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'btn_view')), array('view', 'id'=>$data->id)); ?>&nbsp;|&nbsp;
        <?php echo CHtml::link(CHtml::encode(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'btn_edit')), array('update', 'id'=>$data->id)); ?>&nbsp;|&nbsp;
        <?php echo CHtml::linkButton(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'btn_delete'),array(
            'submit'=>array('delete','id'=>$data->id),
            'confirm'=>Yii::t('models/Department','Are you sure to delete this department?'),
        )); ?>
    </td>
</tr>