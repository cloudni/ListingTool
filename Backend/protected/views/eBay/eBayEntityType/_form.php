<?php
/* @var $this EbayentitytypeController */
/* @var $model eBayEntityType */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'e-bay-entity-type-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'entity_table'); ?>
		<?php echo $form->textField($model,'entity_table',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'entity_table'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'entity_model'); ?>
		<?php echo $form->textField($model,'entity_model',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'entity_model'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'attribute_table'); ?>
		<?php echo $form->textField($model,'attribute_table',array('size'=>60,'maxlength'=>255, 'readonly'=>'readonly')); ?>
		<?php echo $form->error($model,'attribute_table'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'attribute_model'); ?>
		<?php echo $form->textField($model,'attribute_model',array('size'=>60,'maxlength'=>255, 'readonly'=>'readonly')); ?>
		<?php echo $form->error($model,'attribute_model'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'value_table'); ?>
		<?php echo $form->dropDownList($model,'value_table', $model->getValueTableOptions(), array()); ?>
		<?php echo $form->error($model,'value_table'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'value_model'); ?>
		<?php echo $form->textField($model,'value_model',array('size'=>60,'maxlength'=>255, 'readonly'=>'readonly')); ?>
		<?php echo $form->error($model,'value_model'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->