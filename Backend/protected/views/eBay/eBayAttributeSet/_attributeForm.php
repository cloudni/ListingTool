<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-10-21
 * Time: 11:51am
 */
?>

<div style="width: 100%;clear: both;">
    <div style="width: 100%;clear: both;">
        <div class="row left span-3">
            <?php echo $form->labelEx($model,'name', array('style'=>'padding-top: 5px;')); ?>
        </div>
        <div class="row left">
            <?php echo $form->textField($model,'name',array('size'=>27,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'name'); ?>
        </div>
    </div>
    <div style="width: 100%;clear: both;">
        <div class="row left span-3">
            <?php echo $form->labelEx($model,'code', array('style'=>'padding-top: 5px;')); ?>
        </div>
        <div class="row left">
            <?php echo $form->textField($model,'code',array('size'=>27,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'code'); ?>
        </div>
    </div>
    <div style="width: 100%;clear: both;">
        <div class="row left span-3">
            <?php echo $form->labelEx($model,'backend_type', array('style'=>'padding-top: 5px;')); ?>
        </div>
        <div class="row left">
            <?php echo $form->dropDownList($model,'backend_type', $model->getBackendTypes(), array('style'=>'width: 194px;', 'onchange'=>'updateFrontendInput();')); ?>
            <?php echo $form->error($model,'backend_type'); ?>
        </div>
    </div>
    <div style="width: 100%;clear: both;">
        <div class="row left span-3">
            <?php echo $form->labelEx($model,'size', array('style'=>'padding-top: 5px;')); ?>
        </div>
        <div class="row left">
            <?php echo $form->textField($model,'size',array('disabled'=>'disabled','size'=>27,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'size'); ?>
        </div>
    </div>
    <div style="width: 100%;clear: both;">
        <div class="row left span-3">
            <?php echo $form->labelEx($model,'frontend_input', array('style'=>'padding-top: 5px;')); ?>
        </div>
        <div class="row left">
            <?php echo $form->dropDownList($model,'frontend_input', $model->getFrontendInputs(), array('style'=>'width: 194px;')); ?>
            <?php echo $form->error($model,'frontend_input'); ?>
        </div>
    </div>
    <div style="width: 100%;clear: both;">
        <div class="row left span-3">
            <?php echo $form->labelEx($model,'frontend_label', array('style'=>'padding-top: 5px;')); ?>
        </div>
        <div class="row left">
            <?php echo $form->textField($model,'frontend_label',array('size'=>27,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'frontend_label'); ?>
        </div>
    </div>
    <div style="width: 100%;clear: both;">
        <div class="row left span-3">
            <?php echo $form->labelEx($model,'note', array('style'=>'padding-top: 5px;')); ?>
        </div>
        <div class="row left">
            <?php echo $form->textField($model,'note',array('size'=>27,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'note'); ?>
        </div>
    </div>
    <div style="width: 100%;clear: both;">
        <div class="row">
            <?php echo CHtml::checkBox("add_to_selected", true, array('id'=>'add_new_ebay_attribute_to_selected')); ?>
            <?php echo CHtml::label("add to selected eBay attribute", false, array('style'=>'display: inline;')); ?><br />
            <?php echo CHtml::button("Add New eBay Atribute", array('id'=>'add_new_ebay_attribute','onclick'=>'validate_new_attribute();')); ?>
        </div>
    </div>
    <div style="width: 100%;clear: both;">
        <div class="row">
            <?php echo CHtml::label("&nbsp;", false, array('id'=>'attribute_error_msg','style'=>'display: block; color: red;')); ?>
        </div>
    </div>
</div>

<script>
    function validate_new_attribute()
    {
        $("#add_new_ebay_attribute").attr("disabled", 'disabled');
        var errorMsg = '';
        $("#attribute_error_msg").html(errorMsg);
        if($("#eBayAttribute_name").val().length<=0)
            errorMsg += 'eBay Attribute Name can not be NULL.<br />';
        if($("#eBayAttribute_code").val().length<=0)
            errorMsg += 'eBay Attribute Code can not be NULL.<br />';
        if(errorMsg!='')
        {
            if($("#eBayAttribute_name").val().length<=0)
            {
                $("#eBayAttribute_name").focus();
            }
            else if($("#eBayAttribute_code").val().length<=0)
            {
                $("#eBayAttribute_code").focus();
            }
            $("#attribute_error_msg").html(errorMsg);
            $("#add_new_ebay_attribute").removeAttr("disabled");
            return false;
        }

        createeBayAttribute();
    }

    function createeBayAttribute()
    {
        $.ajax({
            type: "POST",
            url: "/ebay/ebayattribute/remoteCreate",
            data: {
                name:$("#eBayAttribute_name").val(),
                code:$("#eBayAttribute_code").val(),
                backend_type:$("#eBayAttribute_backend_type").val(),
                size:$("#eBayAttribute_size").val(),
                frontend_input:$("#eBayAttribute_frontend_input").val(),
                frontend_label:$("#eBayAttribute_frontend_label").val(),
                note:$("#eBayAttribute_note").val()
            },
            dataType: "JSON",
            success: function(data, status, xhr) {
                data = eval(data);
                if(data.status == 'success')
                {
                    $("#available_ebay_attribute").append("<option value='"+data.id+"'>"+$("#eBayAttribute_name").val()+"</option>");
                    if($("#add_new_ebay_attribute_to_selected").is(":checked"))
                    {
                        var zTree = getZTreeObj();
                        var selectedNodes = zTree.getSelectedNodes();
                        var newNode = {attribute_id:data.id, id:'new_'+treeNodeIndex/*parseInt($("#available_ebay_attribute").val())*/, name:$("#eBayAttribute_name").val(), pId:selectedNodes.length <= 0 ? 0 : selectedNodes[0].id};
                        zTree.addNodes(selectedNodes.length <= 0 ? null : selectedNodes[0], newNode);
                        treeNodeIndex++;
                    }
                    //restore input controllers
                    $("#eBayAttribute_name").val('');
                    $("#eBayAttribute_code").val('');
                    $("#eBayAttribute_backend_type").val(1);
                    $("#eBayAttribute_size").val(500);
                    $("#eBayAttribute_size").attr("disabled", "disabled");
                    $("#eBayAttribute_frontend_input").val(1);
                    $("#eBayAttribute_frontend_label").val('');
                    $("#eBayAttribute_note").val('');
                }
                else
                {
                    $("#attribute_error_msg").html(data.errorMsg);
                }
                $("#add_new_ebay_attribute").removeAttr("disabled");
            },
            error: function(data, status, xhr) {
                $("#attribute_error_msg").html(data.statusText);
                $("#add_new_ebay_attribute").removeAttr("disabled");
            }
        })
    }

    function updateFrontendInput()
    {
        $("#eBayAttribute_size").attr("disabled", "disabled");
        switch($("#eBayAttribute_backend_type").val())
        {
            case "5":
                $("#eBayAttribute_frontend_input").val(3);
                break;
            case "6":
                $("#eBayAttribute_frontend_input").val(5);
                break;
            case "4":
                $("#eBayAttribute_frontend_input").val(2);
                $("#eBayAttribute_size").removeAttr("disabled");
                break;
            case "7":
                $("#eBayAttribute_frontend_input").val(1);
                break;
            case "2":
                $("#eBayAttribute_frontend_input").val(1);
                break;
            case "3":
                $("#eBayAttribute_frontend_input").val(1);
                $("#eBayAttribute_size").removeAttr("disabled");
                break;
        }
    }
</script>