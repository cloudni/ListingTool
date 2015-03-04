<?php

$this->pageTitle=Yii::app()->name . ' - '. ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'forgot_password_title');
$this->breadcrumbs=array(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'forgot_password_title')
);
?>

<h1><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'forgot_password_title')?></h1>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'forgotPwd-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'email');?>
        <?php echo $form->textField($model,'email'); ?>
        <?php echo $form->error($model,'email'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'btn_submit')); ?>
    </div>

<?php $this->endWidget(); ?>
</div>

