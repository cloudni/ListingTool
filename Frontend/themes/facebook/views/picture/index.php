<?php
/* @var $this PictureController */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle=Yii::app()->name . ' - '.Yii::t('models/Picture','Pictures');
$this->breadcrumbs=array(
	Yii::t('models/Picture','Pictures'),
);

/*Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.1.7.min.js", CClientScript::POS_END);*/
/*Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/jquery/jquery-ui-1.8.16.custom.min.js", CClientScript::POS_END);*/
?>

<style>
     /*
        ========================================
        =========== picture css ================
     */
     ul{margin: 0px;padding: 0px;}
    .break { *zoom: 1; }
    .break:before, .break:after { display: table; line-height: 0; content: ""; }
    .break:after { clear: both;}

    .picture {width: auto;padding:0px 15px;}
    .picture .msg .success {color: green;}
    .picture .msg .error {color: red;}
    .picture .title{margin: 10px 0px;}
    .picture .zTree{width: 400px;float: left;}
    .picture .images {width: 530px;float: left;}
    .picture .images .tabs {list-style-type: none; margin: 5px 0px; padding: 0px;}
    .picture .images .tabs li {float: left;display: inline-block;}
    .picture .images .tabs .left-content{width: 100px;display: inline-block;}
    .picture .images .tabs .right-content{width: 200px;display: inline-block;float: right;}
    .picture .images .tabs .right-content li{float: right;}

    .picture .images .content{width: 99%; border: 1px solid rgb(163, 163, 163);height: 302px;margin: 5px 0px;}
    .picture .images .content .list .pictures{height: 285px;}
    .picture .images .content .list .pictures ul{padding: 15px 25px;}{height: 285px;}
    .picture .images .content .list .pictures ul li{margin: 16px;display: inline-block;}
    .picture .images .content .list .pictures ul li .image-title{display:inline-block;text-align: center;width: 60px;overflow: hidden; text-overflow: ellipsis;white-space: nowrap;}
    .picture .images .content .list .pictures ul li img{width: 60px;height: 60px;}
    .picture .images .content .list .pagecount{text-align: center;}

    .picture .images .content .list .edit ul li {position: relative;}
    .picture .images .content .list .edit ul li .input-checkbox{position: absolute;top: -14px;left:0px;margin: 0px;}
    .picture .images .content .list .edit ul li .cancel-btn {position: absolute;top: -14px;right:0px;border-radius: 6px;height: 14px;text-align: center;width: 14px;background-color: #B4B4B4;}
    .picture .images .content .list .edit ul li .cancel-btn:hover{cursor: pointer;color: red;}


</style>

<div class="picture" >
    <h1 class="title"><?php echo Yii::t('models/Picture','Pictures');?></h1>
    <div class="msg" id="picture_create_error_msg"></div>
    <div class="zTree">
        <div>
            <?php $this->renderPartial('_create_picture_folder',array('model'=>new PictureFolder())); ?>
        </div>
        <?php $this->renderPartial('_ztree', array('attributes'=>$pictureFolder)); ?>
    </div>
    <div class="images">
        <ul class="tabs">
            <div class="left-content">
                <li id="list-btn" style="width: 40px;" ><a href="javascript:void(0)"  ><?php echo Yii::t('models/Picture','List');?></a>&nbsp;|&nbsp;</li>
                <li id="upload-btn" ><a href="javascript:void(0)" ><?php echo Yii::t('models/Picture','Upload');?></a> </li>
            </div>

            <div class="right-content">
                <li id="finish-btn" ><button onclick="finish()"><?php echo Yii::t('models/Picture','Finish');?></button></li>
                <li id="remove-btn"><button disabled onclick="deleteCheck()"><?php echo Yii::t('models/Picture','DelSelect');?></button></li>
                <li id="check-btn"><input type="checkbox" onchange="changeCheckBtn(this)"></li>
                <li id="edit-btn"><button onclick="editPicture()"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'btn_edit') ;?></button></li>
            </div>
            <div style="clear: both;"></div>
        </ul>
        <div class="content">
            <div class="list" id="view">
                <div id="pictures" class="pictures">
                    <ul></ul>
                </div>
                <div id="pagecount" class="pagecount" ></div>
            </div>
            <div class="list" id="view-edit">
                <div id="pictures-edit" class="pictures edit">
                    <ul id='draggable'></ul>
                </div>
                <div id="pagecount-edit" class="pagecount" ></div>
            </div>
            <!--Plupload plugin-->
            <div class="upload" id="upload">
                <?php $this->renderPartial('_plupload'); ?>
            </div>
        </div>
    </div>
    <div class="break"></div>
</div>
<script>
    window.delArray ={};
/**
 ====================================================================================
 ====================================  POPUP START  =================================
 */
    $("<div id='loadingData'><img id='close_loadingData' src='/Frontend/images/loading.gif' width='30' height='30' style='position:absolute; top: 50%;left:50%;' /></div>").css({
        position:'absolute',
        backgroundColor:'#000',
        top:0,
        left:0,
        opacity:0.3,
        zIndex:300
    })
        .height($(document).height())
        .width($(document).width()).hide().appendTo("body");
/**
 ====================================================================================
 ====================================  POPUP END    =================================
 */

/**
 ====================================================================================
 ====================================  TABLE START    ===============================
 */
$(document).ready( function () {
    $("#view").show();
    $("#view-edit").hide();
    $("#upload").hide();
    $("#finish-btn").hide();
    $("#check-btn").hide();
    $("#remove-btn").hide();

    $("#list-btn").click(function(){
        $("#upload").hide();
        if($("#edit-btn").css("display")=="none"){
            // show page
            $("#view").hide();
            $("#view-edit").show();
        }else {
            $("#view").show();
            $("#view-edit").hide();
        }
    });
    $("#upload-btn").click(function(){
        $("#upload").show();
        $("#view").hide();
        $("#view-edit").hide();
       // $("#edit-btn").hide();
    });

});

function editPicture(){
    $("#edit-btn").hide();
    $("#finish-btn").show();
    $("#check-btn").show();
    $("#remove-btn").show();
    $("#view").hide();
    $("#upload").hide();
    $("#view-edit").show();
}

function changeCheckItem(tag){
    if($(tag).attr("checked")=='checked'){
        $("#remove-btn button").removeAttr("disabled");
    }else{
        var isTrue = false;
        $("#remove-btn button").attr("disabled","disabled");
        $("[name='checkbox']").each(function(){
            if($(this).attr("checked")=='checked') {
                //isTrue = true;
                $("#remove-btn button").removeAttr("disabled");
            }
        })
        if(isTrue){
            $("#remove-btn button").removeAttr("disabled");
        }
    }

}

function changeCheckBtn(tag){
    if($(tag).attr("checked")=='checked'){
        $("#remove-btn button").removeAttr("disabled");
        $("[name='checkbox']").attr("checked",'checked');
    }
    else
    {
        $("[name='checkbox']").each(function(){
            $(this).removeAttr("checked")
        })
        $("#remove-btn button").attr("disabled","disabled");
    }
}

function removePicture(pid,tag){
    //TODO :remove and getData
    delArray[pid]=pid;
    $(tag).parent().remove();
}

function deleteCheck(){
    $("[name='checkbox']").each(function(){
        if($(this).attr("checked")=='checked'){
            delArray[$(this).val()]=$(this).val();
            $(this).parent().remove();
        }
    })
}


/**
 ====================================================================================
 ====================================  TABLE END    =================================
 */


</script>
