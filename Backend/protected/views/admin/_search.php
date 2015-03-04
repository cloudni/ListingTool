<?php
/* @var $this AdminController */
/* @var $model Admin */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>256)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>256)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'last_login_time_utc'); ?>
		<?php echo $form->textField($model,'last_login_time_utc'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'last_login_ip'); ?>
		<?php echo $form->textField($model,'last_login_ip',array('size'=>60,'maxlength'=>128)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'create_time_utc'); ?>
		<?php echo $form->textField($model,'create_time_utc'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'create_admin_id'); ?>
		<?php echo $form->textField($model,'create_admin_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'update_time_utc'); ?>
		<?php echo $form->textField($model,'update_time_utc'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'update_admin_id'); ?>
		<?php echo $form->textField($model,'update_admin_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->