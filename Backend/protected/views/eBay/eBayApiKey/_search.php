<?php
/* @var $this EBayApiKeyController */
/* @var $model eBayApiKey */
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
		<?php echo $form->label($model,'api_url'); ?>
		<?php echo $form->textField($model,'api_url',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'compatibility_level'); ?>
		<?php echo $form->textField($model,'compatibility_level',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'type'); ?>
		<?php echo $form->textField($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dev_id'); ?>
		<?php echo $form->textField($model,'dev_id',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'app_id'); ?>
		<?php echo $form->textField($model,'app_id',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cert_id'); ?>
		<?php echo $form->textField($model,'cert_id',array('size'=>60,'maxlength'=>255)); ?>
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