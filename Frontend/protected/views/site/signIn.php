<?php
/* @var $this SiteController */
/* @var $model SignInForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - '.ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'signIn_title');
$this->breadcrumbs=array(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'signIn_title'),
);
?>
<h1><?php echo CHtml::label(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'signIn_title'),false);?></h1>
<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'SignIn-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'username'); ?>
        <?php echo $form->textField($model,'username'); ?>
        <?php echo $form->error($model,'username'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'password');?>
        <?php echo $form->passwordField($model,'password'); ?>
        <?php echo $form->error($model,'password'); ?>
    </div>

    <div class="row rememberMe">
        <?php echo $form->checkBox($model,'rememberMe'); ?>
        <?php echo $form->label($model,'rememberMe'); ?>
        <?php echo $form->error($model,'rememberMe'); ?>
    </div>

    <?php if(CCaptcha::checkRequirements() && Yii::app()->params['signInDisplayVerificationCode']): ?>
        <div class="row">
            <?php echo $form->labelEx($model,'verifyCode'); ?>
            <div>
                <?php $this->widget('CCaptcha'); ?>
                <?php echo $form->textField($model,'verifyCode'); ?>
            </div>
            <?php echo $form->error($model,'verifyCode'); ?>
        </div>
    <?php endif; ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'signIn_title')); ?>
    </div>

    <div class="row">
        <p><?php echo CHtml::link(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'signIn_forgot_password'),array('site/forgotPwd')); ?></p>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->
