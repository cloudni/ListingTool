<?php
/* @var $this ProductFolderController */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle=Yii::app()->name . ' - '.Yii::t('models/ProductFolder','Product Folders');
$this->breadcrumbs=array(
	Yii::t('models/ProductFolder','Product Folders'),
);
?>

<div class="pub-list" style="width: auto;padding:0px 15px;">

    <div style="margin: 0px;padding: 0px;">
        <!--add-->
        <div style="clear: both;">
            <div class="panel-title" style="text-align: left;font-size: 16px;margin: 15px 0;"><?php echo Yii::t('models/ProductFolder','Add New Product Folders');?></div>
            <div style="width:700px;float: left">
                <?php $this->renderPartial('_create', array('model'=>new ProductFolder())); ?>
            </div>
            <div style="float: left;line-height: 30px;width: 200px;margin-left: 10px;">
                <div class="row">
                    <?php echo CHtml::label("&nbsp;", false, array('id'=>'product_error_msg','style'=>'display: block; color: red;')); ?>
                </div>
            </div>
        </div>

        <hr style="width: 100%"/>
        <!--update-->
        <div >
            <div class="panel-title" style="text-align: left;font-size: 16px;margin: 15px 0; "><?php echo Yii::t('models/ProductFolder','Update Product Folders');?></div>
            <div style="width: 600px;float: left;">
                <?php $this->renderPartial('_update', array('attributes'=>$productFolder)); ?>
            </div>
            <div style="width: 300px;float: left;margin-top: 25px;">
                <div class="row">
                    <div id="product_success_msg" style="display: block;overflow-y: scroll;width:300px;height:240px;border: 1px solid rgb(163, 163, 163);padding: 5px;">

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


