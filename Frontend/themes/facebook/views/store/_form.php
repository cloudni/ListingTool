<?php
/* @var $this StoreController */
/* @var $model Store */
/* @var $form CActiveForm */

Yii::app()->clientScript->registerCoreScript('jquery');
Yii::import('application.vendor.eBay.*');
require_once("reference.php");
?>



<style>
    .platform{ display: none; }
</style>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'store-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'warning') ?></p>

	<?php echo $form->errorSummary($model); ?>

    <div class="container">
        <div class="row left span-4">
            <?php echo $form->labelEx($model,'name'); ?>
        </div>
        <div class="row left">
            <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>256)); ?>
            <?php echo $form->error($model,'name'); ?>
        </div>
    </div>

    <div class="container">
        <div class="row left span-4">
            <?php echo $form->labelEx($model,'platform'); ?>
        </div>
        <div class="row left">
            <?php echo $form->dropDownList($model,'platform', $model->getPlatformOptions(), array('empty'=>'Please select store platform', 'id'=>'platform_selector', 'onChange'=>'updatePlatformPanel()')); ?>
            <?php echo $form->error($model,'platform'); ?>
        </div>
    </div>

    <div id="platform_<?php echo Store::PLATFORM_EBAY;?>" class="platform">
        <div class="container">
            <div class="row left span-4">
                <?php echo $form->labelEx($model,'ebay_site_code'); ?>
            </div>
            <div class="row left">
                <?php echo $form->dropDownList($model,'ebay_site_code', eBaySiteIdCodeType::getSiteIdCodeTypeOptions()); ?>
                <?php echo $form->error($model,'ebay_token'); ?>
            </div>
        </div>
        <?php if(!$model->isNewRecord):?>
        <div class="container">
            <div class="row left span-4">
                <?php echo $form->labelEx($model,'ebay_token'); ?>
            </div>
            <div class="row left">
                <?php echo $form->textField($model,'ebay_token',array('size'=>60,'maxlength'=>1000, 'disabled'=>'true')); ?>
                <?php echo $form->error($model,'ebay_token'); ?>
            </div>
        </div>
        <?php endif;?>
        <div class="container">
            <div class="row left">
                <?php if($model->isNewRecord) echo CHtml::label("After submit, we will redirect you to eBay to authorize, so we could access your data and do our job.", false);?>
            </div>
        </div>
    </div>

    <div id="platform_<?php echo Store::PLATFORM_ALIEXPRESS;?>" class="platform">
    </div>

    <div id="platform_<?php echo Store::PLATFORM_AMAZON;?>" class="platform">
    </div>

    <div id="platform_<?php echo Store::PLATFORM_ECSHOP;?>" class="platform">
    </div>

    <div id="platform_<?php echo Store::PLATFORM_MAGENTO;?>" class="platform">
    </div>

    <div id="platform_<?php echo Store::PLATFORM_WISH;?>" class="platform">
    </div>

    <div class="container">
        <div class="row left span-4">
            &nbsp;
        </div>
        <div class="row left">
            <?php echo CHtml::submitButton($model->isNewRecord ?  ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'btn_create') : ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'btn_save'), array('class'=>'greenButton', 'style'=>'font-size: 12px; width: 70px;')); ?>
        </div>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script>
    $(function(){
        updatePlatformPanel();
    });

    function updatePlatformPanel()
    {
        $("div[id^='platform']").addClass("platform");
        $("#platform_"+$("#platform_selector").val()).removeClass("platform");
    }
</script>