<?php
/* @var $this UserController */
/* @var $data User */
?>

<div class="view">

	<!--<b><?php /*echo CHtml::encode($data->getAttributeLabel('id')); */?>:</b>
	<?php /*echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); */?>
	<br />-->

	<b><?php echo CHtml::encode($data->getAttributeLabel('username')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->username), array('view', 'id'=>$data->id)); ?>
	<br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
    <?php echo CHtml::encode($data->email); ?>
    <br />

	<!--<b><?php /*echo CHtml::encode($data->getAttributeLabel('password')); */?>:</b>
	<?php /*echo CHtml::encode($data->password); */?>
	<br />-->

	<b><?php echo CHtml::encode($data->getAttributeLabel('company_id')); ?>:</b>
	<?php echo CHtml::encode($data->company->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_login_time_utc')); ?>:</b>
	<?php echo CHtml::encode(date("Y-m-d H:i:s", $data->last_login_time_utc)); ?>
	<br />

</div>