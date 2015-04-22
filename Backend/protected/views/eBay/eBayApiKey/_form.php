<?php
/* @var $this EBayApiKeyController */
/* @var $model eBayApiKey */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'e-bay-api-key-form',
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
		<?php echo $form->labelEx($model,'api_url'); ?>
		<?php echo $form->textField($model,'api_url',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'api_url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'compatibility_level'); ?>
		<?php echo $form->textField($model,'compatibility_level',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'compatibility_level'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
        <?php echo $form->dropDownList($model,'type', $model->getTypeOptions()); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dev_id'); ?>
		<?php echo $form->textField($model,'dev_id',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'dev_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'app_id'); ?>
		<?php echo $form->textField($model,'app_id',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'app_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cert_id'); ?>
		<?php echo $form->textField($model,'cert_id',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'cert_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->