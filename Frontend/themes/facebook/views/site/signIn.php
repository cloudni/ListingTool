<?php
/* @var $this SiteController */
/* @var $model SignInForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - '.ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'signIn_title');
$this->breadcrumbs=array(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'signIn_title'),
);
?>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;"><?php echo CHtml::label(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'signIn_title'),false);?></h1>
                </div>
            </div>
            <div class="form" style="padding-left: 10px;">
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
                    <?php echo $form->checkBox($model,'rememberMe', array('style'=>'position: relative; top: 3px;')); ?>
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
                    <?php echo CHtml::submitButton(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'signIn_title'), array('class'=>'boldFont greenButton', 'style'=>'margin-top: 10px; margin-bottom: 10px; min-width: 134px; padding: 7px 20px; -webkit-border-radius: 5px;')); ?>
                </div>

                <div class="row">
                    <p><?php echo CHtml::link(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'signIn_forgot_password'),array('site/forgotPwd')); ?></p>
                </div>

                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>
