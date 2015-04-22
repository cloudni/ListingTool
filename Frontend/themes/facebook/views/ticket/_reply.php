<?php
/**
 * Created by PhpStorm.
 * User: GavinLe
 * Date: 10/22/14
 * Time: 4:40 AM
 */
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

    <?php echo $form->errorSummary($model); ?>
    <div class="row">
        <?php echo $form->labelEx($model,'content'); ?>
        <?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($model,'content'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'btn_create') : ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'btn_save')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div>