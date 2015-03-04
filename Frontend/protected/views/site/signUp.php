<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-9-16
 * Time: 10:18am
 */

/* @var $this SiteController */
/* @var $model SignUpForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - '. ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'signUp_title');
$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'signUp_title'),
);
?>

<h1><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'signUp_title') ?></h1>

<p><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'signUp_description') ?></p>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'signUp-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>
    <p class="note"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'warning') ?></p>

    <hr>

    <h3><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'signUp_personal_information') ?></h3>

    <div class="row">
        <?php echo $form->labelEx($model,'email'); ?>
        <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>256)); ?>
        <?php echo $form->error($model,'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'username'); ?>
        <?php echo $form->textField($model,'username',array('size'=>20,'maxlength'=>20)); ?>
        <?php echo $form->error($model,'username'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'password'); ?>
        <?php echo $form->passwordField($model,'password',array('size'=>20,'maxlength'=>20)); ?>
        <?php echo $form->error($model,'password'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'password_repeat'); ?>
        <?php echo $form->passwordField($model,'password_repeat',array('size'=>20,'maxlength'=>20)); ?>
        <?php echo $form->error($model,'password_repeat'); ?>
    </div>

    <hr>

    <h3><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'signUp_company_information') ?></h3>

    <div class="row">
        <?php echo $form->labelEx($model,'name'); ?>
        <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>256)); ?>
        <?php echo $form->error($model,'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'phone'); ?>
        <?php echo $form->textField($model,'phone',array('size'=>20,'maxlength'=>256)); ?>
        <?php echo $form->error($model,'phone'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'country'); ?>
        <?php echo $form->textField($model,'country',array('size'=>20,'maxlength'=>256)); ?>
        <?php echo $form->error($model,'country'); ?>
    </div>

    <?php if(CCaptcha::checkRequirements() && Yii::app()->params['signUpDisplayVerificationCode']): ?>
        <div class="row">
            <?php echo $form->labelEx($model,'verifyCode'); ?>
            <div>
                <?php $this->widget('CCaptcha'); ?>
                <?php echo $form->textField($model,'verifyCode'); ?>
            </div>
            <div class="hint">Please enter the letters as they are shown in the image above.
                <br/>Letters are not case-sensitive.</div>
            <?php echo $form->error($model,'verifyCode'); ?>
        </div>
    <?php endif; ?>

    <hr>

    <div class="row buttons">
        <?php echo CHtml::submitButton( ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'signUp_title')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->