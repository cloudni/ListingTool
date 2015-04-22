<?php
/**
 * Created by PhpStorm.
 * User: GavinLe
 * Date: 10/27/14
 * Time: 2:53 PM
 */

?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'bulletin-form',
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
		<?php echo $form->labelEx($model,'is_viewable'); ?>
        <?php echo $form->dropDownList($model,'is_viewable',$model->getStatus()); ?>
		<?php echo $form->error($model,'is_viewable'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'is_top'); ?>
        <?php echo $form->dropDownList($model,'is_top',$model->getStatus()); ?>
        <?php echo $form->error($model,'is_top'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'owner'); ?>
        <?php echo $form->dropDownList($model,'owner',$model->getOwnerStatus()); ?>
        <?php echo $form->error($model,'owner'); ?>
    </div>


    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
