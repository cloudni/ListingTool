<style>
    .treeList{
        width: 90%;
        height: 260px;
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
                    'simpleData'=>array(
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
                    'beforeClick'=>'clickNode',
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


    /**
     ====================================================================================
     ==================================== ZTREE START====================================
     */
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
                $("#loadingData").hide();
            },
            error: function(data, status, xhr) {
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
                }
                $("#loadingData").hide();
            },
            error: function(data, status, xhr) {
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
                $("#loadingData").hide();
            },
            error: function(data, status, xhr) {
                $("#loadingData").hide();
            }
        });
    }


    function clickNode(tid,node)
    {
        getData(curPage,node.id);
    }

    /**
     ====================================================================================
     ==================================== ZTREE END====================================
     */


    /**
     ====================================================================================
     ==================================== PAGE START=====================================
     */

    var curPage = 1;
    var total,pageSize,totalPage;
    function getData(currentPage,folderId){
        // init data
        window.delArray={};
        $("#check-btn input").removeAttr("checked");
        $("#remove-btn button").attr("disabled","disabled");

        $.ajax({
            type: 'POST',
            url:  '<?php echo Yii::app()->createAbsoluteUrl("picture/getPage");?>',
            data: {'currentPage':currentPage-1,'folderId':folderId},//folderId
            dataType:'json',
            beforeSend:function(){
                $("#loadingData").show();
            },
            success:function(json){
                $("#pictures ul").empty();
                $("#pictures-edit ul").empty();
                var page  = json.lists.pages;
                var lists =  json.lists.pictures;
                total = page.total; //total count
                pageSize = page.pageSize; //page size
                curPage = currentPage; //current page
                totalPage = page.totalPage; //total page
                //view
                var li = getPageImage(lists,false);
                $("#pictures ul").append(li);
                //edit
                var li_edit = getPageImage(lists,true);
                $("#pictures-edit ul").append(li_edit);

                if($("#edit-btn").css("display")=="none"){
                    // show page
                    $("#view").hide();
                    $("#view-edit").show();
                    $("#upload").hide();
                }else {
                    $("#view").show();
                    $("#view-edit").hide();
                    $("#upload").hide();
                }

                $("#loadingData").hide();
            },
            complete:function(){
                getPageBar();
            },
            error:function(){
                $("#loadingData").hide();
                alert("Loading failed");
            }
        });
    }


    function getPageBar(){
        pageStr ="";
        if(totalPage>1){
            if(curPage>totalPage) curPage=totalPage;
            if(curPage<1) curPage=1;
            pageStr = "<span>Total:"+total+"</span>&nbsp;<span>"+curPage+"/"+totalPage+"</span>&nbsp;";

            if(curPage==1){
                pageStr += "&nbsp;<span>First</span>&nbsp;<span>Previous</span>&nbsp;";
            }else{
                pageStr += "&nbsp;<span><a href='javascript:void(0)' rel='1'>First</a></span>&nbsp;<span><a href='javascript:void(0)' rel='"+(curPage-1)+"'>Previous</a></span>";
            }

            for(var i=1;i<=totalPage;i++){
                if(curPage==i){
                    pageStr += "&nbsp;<span>"+i+"</span>&nbsp;";
                }else{
                    pageStr += "&nbsp;<span><a href='javascript:void(0)' rel='"+i+"'>"+i+"</a></span>&nbsp;";
                }
             }

            if(curPage>=totalPage){
                pageStr += "&nbsp;<span>Next</span>&nbsp;<span>Last</span>&nbsp;";
            }else{
                pageStr += "&nbsp;<span><a href='javascript:void(0)' rel='"+(parseInt(curPage)+1)+"'>Next</a></span>&nbsp;<span><a href='javascript:void(0)' rel='"+totalPage+"'>Last</a></span>";
            }
        }
        $("#pagecount").html(pageStr);
        $("#pagecount-edit").html(pageStr);
    }

    function getPageImage(lists,isEdit){
        var li = "";
        if(lists.length>0){
            if(isEdit){
                $.each(lists,function(index,array){
                    li += "<li >" +
                                "<img  title='"+array['title']+"' src='/Frontend/upload/"+array['file_path']+'/'+array['name']+"'></br>"+
                                "<div class='image-title'><span>"+array['title']+"</span><br>"+
                                "<span>"+array['width']+"X"+array['height']+"</span></div>" +
                                "<input class='input-checkbox' type='checkbox' name='checkbox' onchange='changeCheckItem(this)'  value='"+array['id']+"' />"+
                                "<span  class='cancel-btn' onclick='removePicture("+array['id']+",this)'>" +" X "+"</span>"+
                            "</li>";
                });
            }else{
                $.each(lists,function(index,array){
                    li += "<li>" +
                        "<img title='"+array['title']+"' src='/Frontend/upload/"+array['file_path']+'/'+array['name']+"'></br>"+
                        "<div class='image-title'><span>"+array['title']+"</span><br>"+
                        "<span>"+array['width']+"X"+array['height']+"</span></div>"+
                        "</li>";
                });
            }
        }else{
            li +="No result";
        }
        return li;
    }

    $(function(){
        getData(1,0);
        $("#pagecount span a").live('click',function(){
            var rel = $(this).attr("rel");
            if(rel){
                var node = getZTreeObj().getSelectedNodes()[0];
                var folderId = node!=null?node.id:0;
                getData(rel,folderId);
            }
        });
        $("#pagecount-edit span a").live('click',function(){
            var rel = $(this).attr("rel");
            if(rel){
                var node = getZTreeObj().getSelectedNodes()[0];
                var folderId = node!=null?node.id:0;
                getData(rel,folderId);
            }
        });
    });

    /**
     ====================================================================================
     ==================================== PAGE END  =====================================
     */

    /**
     ====================================================================================
     ==================================== Finish Start  =================================
     */

    /**
     * Batch delete
     */
    function delPicture(data)
    {
        $.ajax({
            type: "POST",
            url: '<?php echo Yii::app()->createAbsoluteUrl("picture/batchPicture");?>',
            data: {ids:data},
            dataType: "JSON",
            beforeSend:function()
            {
                $("#loadingData").show();
            },
            success: function(data, status, xhr) {
                if(data.status=="success"){
                    var node = getZTreeObj().getSelectedNodes()[0];
                    var folderId = node!=null?node.id:0;
                    getData(1,folderId);
                    window.delArray={};
                }
                $("#loadingData").hide();
            },
            error: function(data, status, xhr) {
                $("#loadingData").hide();
            }
        });
    }


    /**
     *  finish btn function
     */
    function finish()
    {
        $("#edit-btn").show();
        $("#finish-btn").hide();
        $("#check-btn").hide();
        $("#remove-btn").hide();
        $("#checkbox").removeAttr("checked");
        $("#upload").hide();

        if(!isEmptyObject(window.delArray)){
            // Remove select data
            delPicture(window.delArray);
        }else{
            $("#view").show();
            $("#view-edit").hide();
        }
    }

    function isEmptyObject(obj){
        for(var name in obj){
            return false;
        }
        return true;
    }


    /**
     ====================================================================================
     ==================================== Finish End ====================================
     */



</script>