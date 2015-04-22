<?php
/* @var $this EbayattributeController */
/* @var $model eBayAttribute */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'backend_type'); ?>
		<?php echo $form->textField($model,'backend_type'); ?>
	</div>

    <div class="row">
        <?php echo $form->label($model,'size'); ?>
        <?php echo $form->textField($model,'size',array('size'=>60,'maxlength'=>255)); ?>
    </div>

	<div class="row">
		<?php echo $form->label($model,'frontend_input'); ?>
		<?php echo $form->textField($model,'frontend_input',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'frontend_label'); ?>
		<?php echo $form->textField($model,'frontend_label',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'note'); ?>
		<?php echo $form->textField($model,'note',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'create_time_utc'); ?>
		<?php echo $form->textField($model,'create_time_utc'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'create_admin_id'); ?>
		<?php echo $form->textField($model,'create_admin_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'update_time_utc'); ?>
		<?php echo $form->textField($model,'update_time_utc'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'update_admin_id'); ?>
		<?php echo $form->textField($model,'update_admin_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->