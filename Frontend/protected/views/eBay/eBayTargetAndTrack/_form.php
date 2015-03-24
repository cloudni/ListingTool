<?php
/* @var $this EBayTargetAndTrackController */
/* @var $model eBayTargetAndTrack */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'e-bay-target-and-track-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'company_id'); ?>
		<?php echo $form->textField($model,'company_id'); ?>
		<?php echo $form->error($model,'company_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'target_ebay_item_id'); ?>
		<?php echo $form->textField($model,'target_ebay_item_id',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'target_ebay_item_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tracking_ebay_listing_id'); ?>
		<?php echo $form->textField($model,'tracking_ebay_listing_id',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'tracking_ebay_listing_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'update_param'); ?>
		<?php echo $form->textField($model,'update_param',array('size'=>60,'maxlength'=>1000)); ?>
		<?php echo $form->error($model,'update_param'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'note'); ?>
		<?php echo $form->textField($model,'note',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'note'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'create_time_utc'); ?>
		<?php echo $form->textField($model,'create_time_utc'); ?>
		<?php echo $form->error($model,'create_time_utc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'create_user_id'); ?>
		<?php echo $form->textField($model,'create_user_id'); ?>
		<?php echo $form->error($model,'create_user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'update_time_utc'); ?>
		<?php echo $form->textField($model,'update_time_utc'); ?>
		<?php echo $form->error($model,'update_time_utc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'update_user_id'); ?>
		<?php echo $form->textField($model,'update_user_id'); ?>
		<?php echo $form->error($model,'update_user_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->