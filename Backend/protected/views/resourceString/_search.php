<?php
/* @var $this ResourceStringController */
/* @var $model ResourceString */
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
		<?php echo $form->label($model,'key'); ?>
		<?php echo $form->textField($model,'key',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'language'); ?>
		<?php echo $form->textField($model,'language'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'environment'); ?>
		<?php echo $form->textField($model,'environment'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'message'); ?>
		<?php echo $form->textArea($model,'message',array('rows'=>6, 'cols'=>50)); ?>
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