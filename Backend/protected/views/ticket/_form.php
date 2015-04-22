<?php
/* @var $this TicketController */
/* @var $model Ticket */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ticket-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>
    <div class="row">
        <?php echo $form->labelEx($model,'is_repliable'); ?>
        <?php echo $form->dropDownList($model,'is_repliable',$model->getStatus()); ?>
        <?php echo $form->error($model,'is_repliable'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'is_viewable'); ?>
        <?php echo $form->dropDownList($model,'is_viewable',$model->getStatus()); ?>
        <?php echo $form->error($model,'is_viewable'); ?>
    </div>
	<!--<div class="row">
		<?php /*echo $form->labelEx($model,'type'); */?>
        <?php /*echo $form->dropDownList($model,'type', $model->getTypeOptions()); */?>
		<?php /*echo $form->error($model,'type'); */?>
	</div>-->

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->