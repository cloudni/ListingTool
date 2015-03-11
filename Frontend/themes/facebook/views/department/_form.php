<?php
/* @var $this DepartmentController */
/* @var $model Department */
/* @var $form CActiveForm */
?>


<style>
    .treeList{
        width: 90%;
        height: 450px;
        border: 1px solid rgb(163, 163, 163);
    }
</style>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'department-form',
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

    <div class="container">
        <div class="row left span-3">
            <?php echo $form->labelEx($model,'name', array('style'=>'padding-top: 5px;')); ?>
        </div>
        <div class="row left">
            <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>30,)); ?>
            <?php echo $form->error($model,'name'); ?>
        </div>
        <div class="row buttons prepend-1 left"  id="departmentButt">
            <?php echo CHtml::submitButton($model->isNewRecord ? ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'btn_create') : ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'btn_save'), array('class'=>'greenButton', 'style'=>'font-size: 12px; width: 50px;')); ?>
        </div>
    </div>

    <div class="container">
        <div class="row left span-3">
            <?php echo $form->labelEx($model,'parent_id', array('style'=>'padding-top: 5px;')); ?>
        </div>
        <div class="row left span-5">
            <?php
                $critirea = array();
                if(!$model->isNewRecord)
                    $critirea = array(
                        'condition'=>"company_id=:company_id and id <> :self" ,
                        'params'=>array(':company_id' => Yii::app()->session['user']->company_id, ':self'=>$model->id),
                        'order'=>'id, parent_id'
                    );
                else
                    $critirea = array(
                        'condition'=>"company_id=:company_id" ,
                        'params'=>array(':company_id' => Yii::app()->session['user']->company_id),
                        'order'=>'id, parent_id'
                    );
                echo $form->dropDownList($model,
                    'parent_id',
                    CHtml::listData(
                        Department::model()->findAll($critirea),
                        'id',
                        'cascadeDepartmentNameRec'
                    ),
                    array('class'=>'span4', 'encode'=>false, 'empty'=>'Please select supervisory department'));
            ?>
            <?php /*echo $form->textField($model,'parent_id'); */?>
            <?php echo $form->error($model,'parent_id'); ?>
        </div>
    </div>
    <div class="container" style="width: 100%">
        <div class="left" style="width: 340px;">
            <div class="row">
                <?php echo CHtml::label(Yii::t('models/Department','Chose Users').':', false, array('style'=>'')); ?>
            </div>
            <div class="row">
                <?php
                $query = "select id as id,username as name from lt_user where company_id = ".(Yii::app()->session['user']->company_id)." and department_id = ".($model->isNewRecord ? '-1' : $model->id)."; ";
                $result = Yii::app()->db->createCommand($query)->queryAll();
                echo CHtml::dropDownList('changeDepartment', 0, CHtml::listData($result,'id','name'), array('style'=>'width: 90%; height: 150px;', 'multiple'=>'multiple'));
                ?>
            </div>
        </div>
        <div class="left" style="width: 40px; padding-top: 80px;">
            <?php echo CHtml::button("=>", array('onclick'=>'departmentRemoveUser();', 'style'=>'margin-left: -11px;')); ?><br />
            <?php echo CHtml::button("<=", array('onclick'=>'departmentAddUser();', 'style'=>'margin-left: -11px;')); ?>
        </div>
        <div class="left" style="width: 340px;">
            <div class="row">
                <?php echo CHtml::label(Yii::t('models/Department','All Users').':', false, array('style'=>'')); ?>
            </div>
            <div class="row" >
                <?php
                $query = "select id as id,username as name from lt_user where company_id = ".(Yii::app()->session['user']->company_id)." and ( department_id not in ( ".($model->isNewRecord ? '-1' : $model->id)." ) or department_id is null); ";
                $user = Yii::app()->db->createCommand($query)->queryAll();
                echo CHtml::dropDownList('department_id', NULL, CHtml::listData($user,'id','name'), array('style'=>'width: 90%; height: 150px;', 'multiple'=>'multiple'));
                ?>
            </div>
        </div>
    </div>
    <div style="width: 100%;clear: both;">
        <div class="row">
            <?php echo CHtml::label("&nbsp;", false, array('id'=>'department_error_msg','style'=>'display: block; color: red;')); ?>
        </div>
    </div>
    <div>
        <?php echo $form->textField($model,'userId',array('id'=>'userId','size'=>60,'maxlength'=>255,'style'=>'display: none')); ?>
        <?php echo $form->textField($model,'removeId',array('id'=>'removeId','size'=>60,'maxlength'=>255,'style'=>'display: none')); ?>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form --><!-- form -->

<script>
    function addUserId(){
        var to=document.getElementById("changeDepartment");
        var userId="";
        for(i=0;i<to.length;i++)
        {
            userId+=to.options[i].value+",";
        }
        $("#userId").val(userId);
    }
    addUserId();
    function departmentAddUser()
    {
        var from=document.getElementById("department_id");
        var to=document.getElementById("changeDepartment");
        if(from.length>0)
        {
            var selectValue="";
            var length=from.length;
            var arrays=new Array();
            for(i=0;i<from.length;i++)
            {
                if(from.options[i].selected)
                {
                    selectValue+=from.options[i].value+",";
                    to.options.add(new Option(from.options[i].text,from.options[i].value));
                    arrays.push(from.options[i].value);
                }

            }
            for(t=0;t<arrays.length;t++)
            {
                for(s=0;s<from.length;s++)
                {
                    if(from.options[s].value == arrays[t])
                    {
                        from.options.remove(s);
                    }
                }
            }
            var userId="";
            for(i=0;i<to.length;i++)
            {
                userId+=to.options[i].value+",";
            }
            $("#userId").val(userId);
        }

    }
    function departmentRemoveUser()
    {
        var from=document.getElementById("changeDepartment");
        var to=document.getElementById("department_id");
        if(from.length>0)
        {
            var selectValue="";
            var arrays=new Array();
            for(i=0;i<from.length;i++)
            {
                if(from.options[i].selected)
                {
                    selectValue+=from.options[i].value+",";
                    to.options.add(new Option(from.options[i].text,from.options[i].value));
                    arrays.push(from.options[i].value);

                }
            }
            for(t=0;t<arrays.length;t++)
            {
                for(s=0;s<from.length;s++)
                {
                    if(from.options[s].value == arrays[t])
                    {
                        from.options.remove(s);
                    }
                }
            }
            var userId="";
            for(i=0;i<from.length;i++)
            {
                userId+=from.options[i].value+",";
            }
            $("#userId").val(userId);
            $("#removeId").val(selectValue)
        }
    }

    function validate()
    {
        var error = '';
        if($("#Department_name").val().length < 6 || $("#Department_name").val().length > 30)
        {
            error += '<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'create_department_name_help');?>'+"\n";
            $("#Department_name").focus();
        }

        if(error.length>0) { alert(error); return false; } else return true;
    }

</script>