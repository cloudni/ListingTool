<?php
/* @var $this EBayListingController */
/* @var $model eBayListing */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'e-bay-listing-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'store_id'); ?>
		<?php echo $form->textField($model,'store_id'); ?>
		<?php echo $form->error($model,'store_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'company_id'); ?>
		<?php echo $form->textField($model,'company_id'); ?>
		<?php echo $form->error($model,'company_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ebay_listing_id'); ?>
		<?php echo $form->textField($model,'ebay_listing_id',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'ebay_listing_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'site_id'); ?>
		<?php echo $form->textField($model,'site_id'); ?>
		<?php echo $form->error($model,'site_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ebay_entity_type_id'); ?>
		<?php echo $form->textField($model,'ebay_entity_type_id'); ?>
		<?php echo $form->error($model,'ebay_entity_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ebay_attribute_set_id'); ?>
		<?php echo $form->textField($model,'ebay_attribute_set_id'); ?>
		<?php echo $form->error($model,'ebay_attribute_set_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_active'); ?>
		<?php echo $form->textField($model,'is_active'); ?>
		<?php echo $form->error($model,'is_active'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'note'); ?>
		<?php echo $form->textField($model,'note',array('size'=>60,'maxlength'=>255)); ?>
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