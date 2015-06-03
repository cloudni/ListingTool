<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/5/26
 * Time: 14:36
 */
/* @var $this AdcampaignController */
/* @var $model ADCampaign */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'adcampaign_form',
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
        <?php echo $form->labelEx($model,'budget'); ?>
        <?php echo $form->textField($model,'budget',array('maxlength'=>255)); ?>
        <?php echo $form->error($model,'budget'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'status'); ?>
        <?php echo $form->dropDownList($model,'status',ADCampaign::getStatusOptions()); ?>
        <?php echo $form->error($model,'status'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'is_delete'); ?>
        <?php echo $form->dropDownList($model,'is_delete',array(ADCampaign::Delete_No=>"No", ADCampaign::Delete_Yes=>"Yes")); ?>
        <?php echo $form->error($model,'is_delete'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'start_datetime'); ?>
        <?php echo $form->textField($model,'start_datetime',array('maxlength'=>255)); ?>
        <?php echo $form->error($model,'start_datetime'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'end_datetime'); ?>
        <?php echo $form->textField($model,'end_datetime',array('maxlength'=>255)); ?>
        <?php echo $form->error($model,'end_datetime'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'note'); ?>
        <?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($model,'note'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->