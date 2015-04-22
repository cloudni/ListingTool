<?php
/**
 * Created by PhpStorm.
 * User: GavinLe
 * Date: 10/31/14
 * Time: 11:30 AM
 */
?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'product-folder-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
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
            <?php echo CHtml::button(Yii::t('models/ProductFolder','Add New Product Folder'), array('id'=>'add_new_product_folder','onclick'=>'validate_new_product();')); ?>
        </div>
    </div>

    <script>
        function validate_new_product()
        {
            $("#add_new_product_folder").attr("disabled", 'disabled');
            var errorMsg = '';
            $("#product_error_msg").html(errorMsg);
            if($("#ProductFolder_name").val().length<=0)
                errorMsg += 'Name can not be null.<br />';
            if(errorMsg!='')
            {
                if($("#ProductFolder_name").val().length<=0)
                {
                    $("#ProductFolder_name").focus();
                }
                $("#product_error_msg").html(errorMsg);
                $("#add_new_product_folder").removeAttr("disabled");
                return false;
            }
            createProduct();
            return false;
        }

        function createProduct()
        {
            var name  =  $("#ProductFolder_name").val();
            var treeObj = $.fn.zTree.getZTreeObj("attribute_has");
            var currentNode = treeObj.getSelectedNodes();
            $.ajax({
                type: "POST",
                url: '<?php echo Yii::app()->createAbsoluteUrl("productFolder/RemoteCreate");?>',
                data: {
                    name:name,
                    pid:currentNode[0]?currentNode[0].id:0
                },
                dataType: "JSON",
                beforeSend:function(){
                    $("#loadingData").show();
                },
                success: function(data, status, xhr) {
                    if(data.status == 'success')
                    {
                       // window.location.reload();
                        var newNode = {name:name,id:data.id,pId:currentNode[0]?currentNode[0].id:0};
                        treeObj.addNodes(currentNode[0]?currentNode[0]:null, newNode);
                        $("#ProductFolder_name").val(null);
                        $('<span style="color:green;">'+data.successMsg+'</span><br/>').appendTo("#product_success_msg");
                    }
                    else
                    {
                        $('<span style="color:red;">'+data.errorMsg+'</span><br/>').appendTo("#product_success_msg");
                    }
                    $("#add_new_product_folder").removeAttr("disabled");
                    $("#loadingData").hide();
                },
                error: function(data, status, xhr) {
                    $('<span style="color:red;">'+data.errorMsg+'</span><br/>').appendTo("#product_success_msg");
                    $("#add_new_product_folder").removeAttr("disabled");
                    $("#loadingData").hide();
                }
            });
        }
    </script>

    <?php $this->endWidget(); ?>

</div><!-- form -->