<?php
/* @var $this EbayattributeController */
/* @var $model eBayAttribute */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'e-bay-attribute-form',
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
		<?php echo $form->labelEx($model,'backend_type'); ?>
		<?php echo $form->textField($model,'backend_type'); ?>
		<?php echo $form->error($model,'backend_type'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'size'); ?>
        <?php echo $form->textField($model,'size'); ?>
        <?php echo $form->error($model,'size'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'frontend_input'); ?>
		<?php echo $form->textField($model,'frontend_input',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'frontend_input'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'frontend_label'); ?>
		<?php echo $form->textField($model,'frontend_label',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'frontend_label'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'note'); ?>
		<?php echo $form->textField($model,'note',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'note'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->