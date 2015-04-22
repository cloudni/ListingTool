<?php

$this->pageTitle=Yii::app()->name . ' - '. 'Reset Password';
$this->breadcrumbs=array(
    "resetPassword",
);
?>

<h1><?php echo "Reset Password";?></h1>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'upPwd-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'password');?>
        <?php echo $form->passwordField($model,'password'); ?>
        <?php echo $form->error($model,'password'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'password_repeat');?>
        <?php echo $form->passwordField($model,'password_repeat'); ?>
        <?php echo $form->error($model,'password_repeat'); ?>
    </div>

    <div class="row rememberMe">
        <?php echo $form->checkBox($model,'rememberMe'); ?>
        <?php echo $form->label($model,'rememberMe'); ?>
        <?php echo $form->error($model,'rememberMe'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('submit'); ?>
    </div>


    <?php $this->endWidget(); ?>
</div>

