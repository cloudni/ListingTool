<?php
/* @var $this DepartmentController */
/* @var $data Department */
?>

<tr>
    <td><?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?></td>
    <td><?php echo CHtml::encode($data->name); ?></td>
    <td><?php echo CHtml::encode($data->parent_id); ?></td>
    <td><?php echo CHtml::encode($data->company_id); ?></td>
    <td>
        <?php
        $query = "select id as id,username as name from lt_user where company_id = ".(Yii::app()->session['user']->company_id)." and department_id = ".( $data->id)."; ";
        $result = Yii::app()->db->createCommand($query)->queryAll();
        foreach($result as $row)
        { ?>
             <?php echo $row['name']?>&nbsp;
        <?php
        }
        ?>
    </td>
    <td><?php echo CHtml::link(CHtml::encode(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'btn_edit')), array('update', 'id'=>$data->id)); ?>&nbsp;|&nbsp;
        <?php echo CHtml::linkButton(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'btn_delete'),array(
            'submit'=>array('delete','id'=>$data->id),
            'confirm'=>Yii::t('models/Department','Are you sure to delete this department?'),
        )); ?></td>

</tr>

<!--<div class="view">

	<b><?php /*echo CHtml::encode($data->getAttributeLabel('id')); */?>:</b>
	<?php /*echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); */?>
	<br />

	<b><?php /*echo CHtml::encode($data->getAttributeLabel('name')); */?>:</b>
	<?php /*echo CHtml::encode($data->name); */?>
	<br />

	<b><?php /*echo CHtml::encode($data->getAttributeLabel('parent_id')); */?>:</b>
	<?php /*echo CHtml::encode($data->parent_id); */?>
	<br />

	<b><?php /*echo CHtml::encode($data->getAttributeLabel('company_id')); */?>:</b>
	<?php /*echo CHtml::encode($data->company_id); */?>
	<br />

	<b><?php /*echo CHtml::encode($data->getAttributeLabel('create_time_utc')); */?>:</b>
	<?php /*echo CHtml::encode($data->create_time_utc); */?>
	<br />

	<b><?php /*echo CHtml::encode($data->getAttributeLabel('create_user_id')); */?>:</b>
	<?php /*echo CHtml::encode($data->create_user_id); */?>
	<br />

	<b><?php /*echo CHtml::encode($data->getAttributeLabel('update_time_utc')); */?>:</b>
	<?php /*echo CHtml::encode($data->update_time_utc); */?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('update_user_id')); */?>:</b>
	<?php /*echo CHtml::encode($data->update_user_id); */?>
	<br />

	<b><?php /*echo CHtml::encode($data->getAttributeLabel('note')); */?>:</b>
	<?php /*echo CHtml::encode($data->note); */?>
	<br />

	 ?>

</div>-->