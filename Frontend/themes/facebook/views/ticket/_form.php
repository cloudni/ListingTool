<?php
/* @var $this TicketController */
/* @var $model Ticket */
/* @var $form CActiveForm */

Yii::app()->getClientScript()->registerCoreScript('jquery');
?>

<style>
    .attachFile{
        position: relative;
        top: 4px;
        cursor: pointer;
    }
</style>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ticket-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array('enctype'=>"multipart/form-data")
)); ?>

	<p class="note"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'warning') ?></p>

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
        <?php echo $form->labelEx($model,'type'); ?>
        <?php echo $form->dropDownList($model,'type', $model->getTypeOptions()); ?>
        <?php echo $form->error($model,'type'); ?>
    </div>

    <div class="row" style="display: none;">
        <div><?php echo CHtml::label("Attach Files", false, array('style'=>'display: inline;'));?>&nbsp;&nbsp;<?php echo CHtml::image("/images/addicon.gif", 'Add another file', array('class'=>'attachFile', 'onClick'=>'addAttachFile();'));?></div>
        <div id="attachPanel">
            <div id="attachRow"><?php echo CHtml::fileField("attach[]", '');?><?php echo CHtml::image("/images/delicon.gif", 'Remove file', array('class'=>'attachFile', 'onClick'=>'removeAttachFile(this);'));?></div>
        </div>
    </div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ?  ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'btn_create') : ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'btn_save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script>
    function addAttachFile()
    {
        var inputControl = '<?php echo CHtml::fileField("attach[]", '').CHtml::image("/images/delicon.gif", 'Remove file', array('class'=>'attachFile'));?>';
        $("#attachPanel").append("<div id='attachRow'>"+inputControl+"</div>");
    }

    function removeAttachFile(obj)
    {
        $(obj).parent().remove();
        if($("#attachRow").length<=0) addAttachFile();
    }
</script>