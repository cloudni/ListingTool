<?php
/**
 * Created by PhpStorm.
 * Date: 10/31/14
 * Time: 11:30 AM
 */
?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'picture-folder-form-create',
        'enableAjaxValidation'=>false,
    )); ?>
    <div class="container" style="width: 400px;">
        <div class="row left">
            <?php echo $form->labelEx($model,'name', array('style'=>'padding-top: 5px;')); ?>
        </div>
        <div class="row left">
            <?php echo $form->textField($model,'name',array('size'=>30,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'name'); ?>
        </div>
        <div class="row buttons left" style="margin-left: 10px;">
            <?php echo CHtml::button(Yii::t('models/PictureFolder',"Add New Picture Folder"), array('id'=>'add_new_picture_folder','onclick'=>'validate_new_picture()','style'=>'margin:0px;')); ?>
        </div>
        <div class="border"></div>
    </div>
    <div class="border"></div>
    <script>
        function validate_new_picture()
        {
            $("#add_new_picture_folder").attr("disabled", 'disabled');
            var errorMsg = '';
            if($("#PictureFolder_name").val().length<=0)
            {
                errorMsg += 'Name can not be null.';
            }
            if(errorMsg!='')
            {
                $("#PictureFolder_name").focus();
                $("#picture_create_error_msg").empty();
                $('<span class="error">'+errorMsg+'</span>').appendTo("#picture_create_error_msg");
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
                        $("#picture_create_error_msg").empty();
                        $('<span class="success">'+data.successMsg+'</span>').appendTo("#picture_create_error_msg");
                    }
                    $("#add_new_picture_folder").removeAttr("disabled");
                    $("#loadingData").hide();
                },
                error: function(data, status, xhr) {
                    $("#picture_create_error_msg").empty();
                    $('<span class="error">'+data.successMsg+'</span>').appendTo("#picture_create_error_msg");
                    $("#add_new_picture_folder").removeAttr("disabled");
                    $("#loadingData").hide();
                }
            });
        }
    </script>

    <?php $this->endWidget(); ?>

</div><!-- form -->