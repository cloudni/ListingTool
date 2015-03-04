<?php
/* @var $this EbayentitytypeController */
/* @var $model eBayEntityType */
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
		<?php echo $form->label($model,'entity_table'); ?>
		<?php echo $form->textField($model,'entity_table',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'entity_model'); ?>
		<?php echo $form->textField($model,'entity_model',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'attribute_table'); ?>
		<?php echo $form->textField($model,'attribute_table',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'attribute_model'); ?>
		<?php echo $form->textField($model,'attribute_model',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'value_table'); ?>
		<?php echo $form->textField($model,'value_table',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'value_model'); ?>
		<?php echo $form->textField($model,'value_model',array('size'=>60,'maxlength'=>255)); ?>
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