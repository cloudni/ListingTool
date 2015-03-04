<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'picture-folder-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'parent_id'); ?>
        <?php echo $form->dropDownList($model,
            'parent_id',
            CHtml::listData(
                PictureFolder::model()->findAll(
                    array(
                        'condition'=>"company_id=:company_id" ,
                        'params'=>array(':company_id' => Yii::app()->session['user']->company_id),
                        'order'=>'id, parent_id'
                    )
                ),
                'id',
                'cascadeFolderNameRec'
            ),
            array('class'=>'span4', 'encode'=>false,'empty'=>'Main Picture')); ?>
        <?php /*echo $form->textField($model,'parent_id'); */?>
        <?php echo $form->error($model,'parent_id'); ?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->