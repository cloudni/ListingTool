<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array(
        'onsubmit'=>' return validate()',
    ),
)); ?>

    <p class="note"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'warning') ?></p>

	<?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'username'); ?>
        <?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>20, 'onkeyup'=>'CheckInputSignUpName(this);')); ?>
        <?php echo $form->error($model,'username'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>256, 'onkeyup'=>'CheckInputEmailAddress(this);')); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>20, 'onkeyup'=>'CheckInputPassword(this);')); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

    <div class="row">
        <?php echo $form->label($model,'password_repeat'); ?>
        <?php echo $form->passwordField($model,'password_repeat',array('size'=>60,'maxlength'=>20, 'onkeyup'=>'CheckInputPassword(this);')); ?>
        <?php echo $form->error($model,'password_repeat'); ?>
    </div>

	<div class="row hide">
		<?php echo $form->labelEx($model,'company_id'); ?>
		<?php echo $form->textField($model,'company_id'); ?>
		<?php echo $form->error($model,'company_id'); ?>
	</div>
    <div class="row">
        <?php echo $form->labelEx($model,'department_id'); ?>
        <?php echo $form->dropDownList($model, 'department_id',
            CHtml::listData(
                Department::model()->findAll(
                    array(
                        'condition'=>"company_id=:company_id" ,
                        'params'=>array(':company_id' => Yii::app()->session['user']->company_id),
                        'order'=>'id, parent_id'
                    )
                ),
                'id',
                'cascadeDepartmentNameRec'
            ),
            array('class'=>'span4', 'encode'=>false,)); ?>

        <?php echo $form->error($model,'parent_id'); ?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'btn_create') : ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'btn_save'),
				array('class'=>'greenButton', 'style'=>'font-size: 14px; width: 70px;')
			); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script>
    function CheckInputSignUpName(oInput)
    {
        if('' != oInput.value.replace(/[a-zA-Z_0-9]{1,20}/,''))
        {
            oInput.value = oInput.value.match(/[a-zA-Z_0-9]{1,20}/) == null ? '' :oInput.value.match(/[a-zA-Z_0-9]{1,20}/);
        }
    }

    function CheckInputPassword(oInput)
    {
        if('' != oInput.value.replace(/[a-zA-Z0-9!@#$%^&*()_+]{1,20}/,''))
        {
            oInput.value = oInput.value.match(/[a-zA-Z0-9!@#$%^&*()_+]{1,20}/) == null ? '' :oInput.value.match(/[a-zA-Z0-9!@#$%^&*()_+]{1,20}/);
        }
    }

    function CheckInputEmailAddress(oInput)
    {
        if('' != oInput.value.replace(/[a-zA-Z0-9@._]{1,}/,''))
        {
            oInput.value = oInput.value.match(/[a-zA-Z0-9@._]{1,}/) == null ? '' :oInput.value.match(/[a-zA-Z0-9@._]{1,}/);
        }
    }

    function validate()
    {
        var error = '';
        if($("#User_username").val().length < 6 || $("#User_username").val().length > 20)
        {
            error += '<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'index_signup_username_help');?>'+"\n";
        }

        if($("#User_email").val().length <= 0)
        {
            error += '<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'index_signup_email_help');?>'+"\n";
        }
        else
        {
            var Regex = /^(?:\w+\.?)*\w+@(?:\w+\.)*\w+$/;
            if(!Regex.test($("#User_email").val()))
            {
                error += '<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'index_signup_email_help');?>'+"\n";
            }
        }

        if($("#User_password").val().length < 6 || $("#User_password").val().length > 20)
        {
            error += '<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'index_signup_password_help');?>'+"\n";
        }

        if($("#User_password").val() != $("#User_password_repeat").val())
        {
            error += '<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'index_signup_re_password_help');?>'+"\n";
        }

        if(error.length>0) { alert(error); return false; } else return true;
    }
</script>