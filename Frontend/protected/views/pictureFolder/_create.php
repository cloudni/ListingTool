<?php
/**
 * Created by PhpStorm.
 * Date: 10/31/14
 * Time: 11:30 AM
 */
?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'picture-folder-form',
        'enableAjaxValidation'=>false,
    )); ?>
    <?php echo $form->errorSummary($model); ?>
    <div class="container" style="width: 700px;">
        <div class="row left span-3">
            <?php echo $form->labelEx($model,'name', array('style'=>'padding-top: 5px;')); ?>
        </div>
        <div class="row left">
            <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'name'); ?>
        </div>
        <div class="row buttons left" style="margin-left: 10px;">
            <?php echo CHtml::button(Yii::t('models/PictureFolder',"Add New Picture Folder"), array('id'=>'add_new_picture_folder','onclick'=>'validate_new_picture();')); ?>
        </div>
    </div>

    <script>
        function validate_new_picture()
        {
            $("#add_new_picture_folder").attr("disabled", 'disabled');
            var errorMsg = '';
            $("#picture_create_error_msg").html(errorMsg);
            if($("#PictureFolder_name").val().length<=0)
            {
                errorMsg += 'Name can not be null.<br />';
            }
            if(errorMsg!='')
            {
                if($("#PictureFolder_name").val().length<=0)
                {
                    $("#PictureFolder_name").focus();
                }
                $("#picture_create_error_msg").html(errorMsg);
                $("#add_new_picture_folder").removeAttr("disabled");
                return false;
            }
            createPicture();
            return false;
        }

        function createPicture()
        {
            var name  =  $("#PictureFolder_name").val();
            var treeObj = $.fn.zTree.getZTreeObj("picture_has");
            var currentNode = treeObj.getSelectedNodes();
            $.ajax({
                type: "POST",
                url: '<?php echo Yii::app()->createAbsoluteUrl("pictureFolder/RemoteCreate");?>',
                data: {
                    name:name,
                    pid:currentNode[0]?currentNode[0].id : 0
                },
                dataType: "JSON",
                beforeSend:function(){
                    $("#loadingData").show();
                },
                success: function(data, status, xhr) {
                    if(data.status == 'success')
                    {
                        var newNode = {name:name,id:data.id,pId:0};
                        treeObj.addNodes(currentNode[0]?currentNode[0]:null, newNode);
                        $("#PictureFolder_name").val(null);
                        $('<span style="color:green;">'+data.successMsg+'</span><br/>').appendTo("#picture_success_msg");
                    }
                    else
                    {
                        $('<span style="color:red;">'+data.successMsg+'</span><br/>').appendTo("#picture_success_msg");
                    }
                    $("#add_new_picture_folder").removeAttr("disabled");
                    $("#loadingData").hide();
                },
                error: function(data, status, xhr) {
                    $('<span style="color:red;">'+data.successMsg+'</span><br/>').appendTo("#picture_success_msg");
                    $("#add_new_picture_folder").removeAttr("disabled");
                    $("#loadingData").hide();
                }
            });
        }
    </script>

    <?php $this->endWidget(); ?>

</div><!-- form -->