<style>
    .treeList{
        width: 90%;
        height: 240px;
        border: 1px solid rgb(163, 163, 163);
    }

    hr{
        top: 6px;
        position: relative;
        width: 90%;
        background-color: gray;
    }
</style>
<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'picture-folder-form',
        'enableAjaxValidation'=>false,
    )); ?>

    <div >
        <div class="row">
            <?php echo CHtml::label(Yii::t('models/PictureFolder','Available Picture Folder').":", false, array('style'=>'')); ?>
        </div>
        <div class="row" style="width: 100%;">
            <?php
            $this->widget('ext.zTree.zTree',array(
                'data'=>array(
                    'key'=>array('name'=>'name'),
                    'simpleDate'=>array(
                        'enable'=>true,//Set zTree's node to accept the simple data format, when zTree is initialized or when ajax get / or when use addNodes method.
                        'idKey'=>'id',//The node data's attribute to save node data's unique identifier. It is valid when [setting.data.simpleData.enable = true]
                        'pIdKey'=>'parent_id',
                    ),
                ),
                'view'=>array(
                    'expandSpeed'=>"",
                    'showLine'=>true,
                    'selectedMulti'=>false,
                    'showIcon'=>false,
                    'autoCancelSelected'=>true,
                ),
                'edit'=>array(
                    'enable'=>true,
                    'showRemoveBtn'=>true,
                    'showRenameBtn'=>true,
                    'removeTitle'=>'del',
                ),
                'callback'=>array(
                    'beforeRemove'=>'removeFolder',
                    'beforeRename'=>'editName',
                    'beforeDrop'=>'dropFolder'
                ),
                'htmlOptions'=>array('id'=>'picture_has','name'=>'picture_has','class'=>'treeList', 'style'=>'overflow-y: scroll; overflow-x: auto;'),
                'input'=>$attributes,
            ));
            echo CHtml::textField('picture_folder', null, array('hidden'=>'hidden', 'style'=>'visibility: hidden;'));
            ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
<script>
    var treeNodeIndex = 1;

    function getZTreeObj()
    {
        return $.fn.zTree.getZTreeObj("picture_has");
    }

    function editName(tid,tNode,newName)
    {
        $.ajax({
            type: "POST",
            url: '<?php echo Yii::app()->createAbsoluteUrl("pictureFolder/updateName");?>',
            data: {
                id:tNode.id,
                name:newName,
                pid:tNode.pId
            },
            dataType: "JSON",
            beforeSend:function()
            {
                $("#loadingData").show();
            },
            success: function(data, status, xhr) {
                if(data.status == 'success')
                {
                    $('<span style="color:green;">'+data.successMsg+'</span><br/>').appendTo("#picture_success_msg");
                }
                else
                {
                    $('<span style="color:red;">'+data.errorMsg+'</span><br/>').appendTo("#picture_success_msg");
                }
                $("#add_new_picture_folder").removeAttr("disabled");
                $("#loadingData").hide();
            },
            error: function(data, status, xhr) {
                $('<span style="color:red;">'+data.statusText+'</span><br/>').appendTo("#picture_success_msg");
                $("#add_new_picture_folder").removeAttr("disabled");
                $("#loadingData").hide();
            }
        });
    }


    function removeFolder(tid,tNode)
    {
        var zTree = $.fn.zTree.getZTreeObj("picture_has");
        $.ajax({
            type: "POST",
            url: '<?php echo Yii::app()->createAbsoluteUrl("pictureFolder/removeTreeNode");?>',
            data: {
                id:tNode.id
            },
            dataType: "JSON",
            beforeSend:function()
            {
                $("#loadingData").show();
            },
            success: function(data, status, xhr) {
                if(data.status == 'success')
                {
                    /*if(tNode.children)
                    {
                        var treeNodeP = tNode.parentTId ? tNode.getParentNode() : null;

                            for(var i=0;i<tNode.children.length;i++) {
                                var childNode = tNode.children[i];
                                childNode.pId = tNode.pId;
                            }
                            zTree.addNodes(treeNodeP,childNode);
                    }*/

                    var filterNode =  function(node)
                    {
                        var isTrue  = (node.parentTId == tNode.tId)?true:false;
                        return isTrue;
                    }
                    var childNode = zTree.getNodesByFilter(filterNode,false,tNode);
                    var parentNode = zTree.getNodeByTId(tNode.parentTId);
                    if(childNode.length>0)
                    {
                        for(var key in childNode)
                        {
                            if(parentNode==null) childNode[key].pId =0;
                            else  childNode[key].pId = parentNode.id;
                            zTree.addNodes(parentNode,childNode[key]);
                        }

                    }

                    $('<span style="color:green;">'+data.successMsg+'</span><br/>').appendTo("#picture_success_msg");
                }
                else
                {
                    $('<span style="color:red;">'+data.errorMsg+'</span><br/>').appendTo("#picture_success_msg");
                }
                $("#add_new_picture_folder").removeAttr("disabled");
                $("#loadingData").hide();
            },
            error: function(data, status, xhr) {
                $('<span style="color:red;">'+data.statusText+'</span><br/>').appendTo("#picture_success_msg");
                $("#add_new_picture_folder").removeAttr("disabled");
                $("#loadingData").hide();
            }
        });
    }

    function dropFolder(tid,tNode,targetNode)
    {
        $.ajax({
            type: "POST",
            url: '<?php echo Yii::app()->createAbsoluteUrl("pictureFolder/dropFolder");?>',
            data: {
                id:tNode[0].id,
                tid:(targetNode==null)?0:targetNode.id
            },
            dataType: "JSON",
            beforeSend:function()
            {
                $("#loadingData").show();
            },
            success: function(data, status, xhr) {
                if(data.status == 'success')
                {
                    $('<span style="color:green;">'+data.successMsg+'</span><br/>').appendTo("#picture_success_msg");
                }
                else
                {
                    $('<span style="color:red;">'+data.errorMsg+'</span><br/>').appendTo("#picture_success_msg");
                }
                $("#add_new_picture_folder").removeAttr("disabled");
                $("#loadingData").hide();
            },
            error: function(data, status, xhr) {
                $('<span style="color:red;">'+data.statusText+'</span><br/>').appendTo("#picture_success_msg");
                $("#add_new_picture_folder").removeAttr("disabled");
                $("#loadingData").hide();
            }
        });
    }
</script>