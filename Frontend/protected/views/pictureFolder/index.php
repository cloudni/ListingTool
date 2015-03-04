<?php
$this->pageTitle=Yii::app()->name . ' - '.Yii::t('models/PictureFolder','Picture Folders');
$this->breadcrumbs=array(
    Yii::t('models/PictureFolder','Picture Folders'),
);
?>

<div class="pub-list"  style="width: auto;padding:0px 15px;">
    <div style="margin: 0px;padding: 0px;">
        <!--add-->
        <div >
            <div class="panel-title" style="text-align: left;font-size: 16px;margin: 15px 0;"><?php echo Yii::t('models/PictureFolder','Add New Picture Folders');?></div>
            <div style="width:700px;float: left">
                <?php $this->renderPartial('_create',array('model'=>new PictureFolder())); ?>
            </div>
            <div style="float: left;line-height: 30px;width: 200px;margin-left: 10px;">
                <div class="row">
                    <?php echo CHtml::label("&nbsp;", false, array('id'=>'picture_create_error_msg','style'=>'display: block; color: red;')); ?>
                </div>
            </div>
            <div style="clear: both;"></div>
        </div>
        <hr style="width: 100%"/>

        <!--update-->
        <div>
            <div class="panel-title" style="text-align: left;font-size: 16px;margin: 15px 0; "><?php echo Yii::t('models/PictureFolder','Update Picture Folders');?></div>
            <div style="width: 600px;float: left;">
                <?php $this->renderPartial('_update', array('attributes'=>$pictureFolder)); ?>
            </div>
            <div style="width: 300px;float: left;margin-top: 25px;">
                <div class="row">
                    <div id="picture_success_msg" style="display: block;overflow-y: scroll;width:300px;height:240px;border: 1px solid rgb(163, 163, 163);padding: 5px;">

                    </div>
                </div>
            </div>
            <div style="clear: both;"></div>
        </div>
    </div>

    <script>
        $("<div id='loadingData'><img id='close_loadingData' src='/Frontend/images/loading.gif' width='30' height='30' style='position:absolute; top: 50%;left:50%;' /></div>").css({
            position:'absolute',
            backgroundColor:'#000',
            top:0,
            left:0,
            opacity:0.3,
            zIndex:300
        })
            .height($(document).height())
            .width($(document).width()).hide().appendTo("body")
    </script>
</div>