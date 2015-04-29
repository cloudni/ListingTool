<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/4/16
 * Time: 14:01
 */

/* @var $this ADAdvertiseController */
/* @var $model ADAdvertise */
/* @var $form CActiveForm */

Yii::import('application.vendor.eBay.*');
require_once 'reference.php';
?>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'ad_form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
    'htmlOptions'=>array(
        'onsubmit'=>' return validate()',
    ),
));
?>

<link href="/css/jquery-hex-colorpicker.css" rel="stylesheet" />
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-hex-colorpicker.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/ajaxfileupload.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.json.min.js"></script>

<style>
    .DabE-j {
        border-style: solid;
        border-width: 2px;
        border-color: gray;
        background-image: url(/themes/facebook/images/noimage.png);
        background-repeat: repeat;
        width: 60px;
        height: 50px;
        position: relative;
    }

    .removeButton{
        background-image: url(/themes/facebook/images/NKweBg8DV6y.png);
        background-repeat: no-repeat;
        background-size: auto;
        background-position: -509px -160px;
        height: 12px;
        width: 12px;
        display: inline-block;
        cursor: pointer;
        display: inline-block;
    }

    .detailOption{
        display: block;
        clear: both;
        padding-top: 5px;
        height: 24px;
    }

    .colorPicker{
        height: 15px;
        width: 15px;
        border: 1px solid black;
    }

    .textColor{
        font-size: 15px;
        border-bottom:3px solid black;
    }

    .removeAppliedListing{
        background-image: url(/themes/facebook/images/NKweBg8DV6y.png);
        background-repeat: no-repeat;
        background-size: auto;
        background-position: -509px -160px;
        height: 12px;
        width: 12px;
        display: inline-block;
        cursor: pointer;
        position: relative;
        top: 1px;
        /*margin-left: 3px;*/
    }

    .applied_listing_table_div{
        width: 100%;
        height: 200px;
        overflow-y: scroll;
        overflow-x: auto;
    }

    .headline{
        font-size: 18px;
        height: 32px;
        margin: 0 auto;
        padding: 2px 0;
        text-align: center;
        width: 240px;
        color: #4d4d4d;
        overflow: hidden;
        white-space: nowrap;
    }

    .carousel-bg {
        background: #e6e6e6;
        border-bottom: rgb(138,138,138) 3px solid;
        height: 146px;
        width: 100%;
    }

    .carousel-wrapper {
        height: 100%;
        overflow: hidden;
        position: relative;
        display: inline-block;
    }

    .ad-container {
        cursor: pointer;
    }
    .layout, .product-image-container, .product-image-container .product-image {
        border: 1px solid #cbcbcb;
    }

    .inline-wrapper {
        display: block;
        font-size: 0;
    }

    .carousel-item {
        display: inline-block;
        float: left;
        width: 100%;
    }

    .products {
        height: 100%;
        margin: 0 auto;
        width: 250px;
        display: block;
        -webkit-font-smoothing: antialiased;
    }

    .product {
        float: left;
        height: 100%;
        width: 50%;
        -webkit-font-smoothing: antialiased;
    }

    .product-content {
        margin: 0 auto;
        overflow: hidden;
        text-align: center;
        width: 86%;
    }

    .details {
        height: 30px;
        width: 100%;
    }

    .productName {
        height: 16px;
    }

    .product-price .not-alone {
        height: 48%;
        position: relative;
        top: -2px;
    }
    .product-price div {
        height: 100%;
        width: 52px;
        display: block;
        float: left;
        padding: 0;
        text-align: center;
        vertical-align: bottom;
    }

    .product-price-prefix {
        color: #0073ed;
        font-size: 12px;
    }

    .product-price-value {
        color: #0073ed;
        font-size: 24px;
    }

    .img-btn {
        border: 3px solid rgba(255, 255, 255, .9);
        -webkit-border-radius: 3px;
        border-radius: 3px;
        height: 103px;
        width: 100%;
        -moz-osx-font-smoothing: grayscale;
        -webkit-font-smoothing: antialiased;
    }

    .img-btn div {
        background: rgba(255, 255, 255, .9);
        height: 100%;
        width: 100%;
    }

    .productImage {
        height: 68px;
        position: relative;
        width: 100%;
    }

    .actions {
        height: 29px;
        width: 100%;
    }

    .button {
        height: 29px;
        width: 100%;
        display: block;
        font-size: 15px;
        line-height: normal;
        padding: 0 5px;
    }

    .footer {
        height: 70px;
        text-align: center;
        width: 100%;
    }

    .logo-wrapper.w-disclaimer {
        height: 53px;
    }

    .logo-wrapper {
        height: 66px;
        margin: 2px auto;
        width: 75%;
    }

    .logo {
        height: 100%;
        width: 100%;
    }
    .logo {
        overflow: visible !important;
        position: relative;
    }

    .disclaimer {
        bottom: 1px;
        height: 13px;
        /*margin: 0 38px;*/
        position: relative;
        text-align: center;
        width: 224px;
        top: -7px;
    }
    .disclaimer {
        color: #434343;
        font-size: 8px;
    }

    .content {
        height: 100%;
        width: 100%;
        -moz-osx-font-smoothing: grayscale;
        -webkit-font-smoothing: antialiased;
    }

    .image-container {
        width: 45%;
    }

    .column {
        float: left;
        height: 100%;
    }

    .image-container .logo-container {
        height: 25%;
        display: none !important;
    }

    .ng-hide{
        display: none !important;
    }

    .logo {
        height: 100%;
        position: relative;
        width: 100%;
    }

    .layout, .product-image-container, .product-image-container .product-image {
        border-color: #cbcbcb;
    }

    .product-image-container {
        border-right: 1px solid transparent;
        height: 75%;
    }

    .main-container {
        width: 55%;
    }

    .product-info {
        height: 70%;
        padding: 5px 0 0 5px;
    }

    .product-info-content {
        background: rgba(255, 255, 255, 0.5);
        border: 1px solid #ccc;
        border-bottom-left-radius: 20px;
        border-right: none;
        border-top-left-radius: 20px;
        height: 100%;
        max-height: 235px;
        overflow: hidden;
        padding: 5px 0 5px 5px;
    }

    .transition {
        -webkit-transition: all 0.5s linear;
        transition: all 0.5s linear;
    }

    .shadow {
        -moz-box-shadow: 1px 1px 2px #333;
        -webkit-box-shadow: 1px 1px 2px #333;
        box-shadow: 1px 1px 2px #333;
    }

    .transition {
        -webkit-transition: all .25s linear;
        transition: all .25s linear;
    }

    .shadow {
        -moz-box-shadow: 0 2px 2px #333;
        -webkit-box-shadow: 0 2px 2px #333;
        box-shadow: 0 2px 2px #333;
    }

    .product-name {
        background: -moz-linear-gradient(top, rgb(253,253,253) 0%, #e6e6e6 35%, rgb(207,207,207) 100%);
        background: -ms-linear-gradient(top, rgb(253,253,253) 0%, #e6e6e6 35%, rgb(207,207,207) 100%);
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, rgb(253,253,253)), color-stop(35%, #e6e6e6), color-stop(100%, rgb(207,207,207)));
        background: -webkit-linear-gradient(top, rgb(253,253,253) 0%, #e6e6e6 35%, rgb(207,207,207) 100%);
        background: linear-gradient(to bottom, rgb(253,253,253) 0%, #e6e6e6 44%, rgb(207,207,207) 100%);
        background-color: #e6e6e6;
        border-top-left-radius: 20px;
        height: 18%;
    }

    .product-name-wrapper {
        color: #4d4d4d;
        font-size: 24px;
        line-height: normal;
        padding: 5px 5px 3px 10px;
    }

    .product-subtitle {
        color: #4d4d4d;
        font-size: 18px;
        height: 20%;
    }

    .product-subtitle-content {
        height: 99%;
        padding: 5px 5px 3px 10px;
    }

    .divider {
        border-bottom: 1px solid #4d4d4d;
    }

    .product-price-block {
        height: 35%;
        padding: 3px 3px 3px 4px;
    }

    .product-description-container {
        height: 26%;
    }

    .product-description {
        color: #4d4d4d;
        font-size: 14px;
        height: 100%;
        /*padding: 0 5px;*/
        text-align: center;
    }

    .headline .left {
        padding-right: 10px;
    }

    .headline {
        height: 14%;
        overflow: hidden;
        padding-top: 7px;
        width: 100%;
    }

    .left .headline-content {
        border-bottom-right-radius: 20px;
        border-top-right-radius: 20px;
    }
    .headline-content {
        background-color: #ffffff;
        border-color: #ffffff;
        color: #4d4d4d;
        font-size: 20px;
    }
    .headline-content {
        background: #fff;
        border: 1px solid #ccc;
        height: 27px;
        padding: 3px 5px;
        width: 100%;
    }
    .headline-content {
        text-align: center;
    }
</style>

<div style="clear: both; width: 100%; position: relative; top: -5px; ">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal; display: none;">
                </div>
            </div>
            <div style="clear: both; width: 100%;">
                <div style="padding: 12px; float: left; width: 60%;">
                    <div style="width: 80%;clear: both;" onmouseover=" $(this).css('background-color', '#efefef');" onmouseout="$(this).css('background-color', '#fff');">
                        <h1><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement');?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'name');?></h1>
                        <div style="padding-top: 5px;"><input id="adName_value" name="advertise[name]" type="text" value="" size="40" style="height: 22px; padding-left: 5px;" maxlength="25" /></div>
                    </div>
                    <div style="height: 12px; clear: both;">&nbsp;</div>
                    <hr />
                    <div style="width: 80%;clear: both; width: 595px;" onmouseover=" $(this).css('background-color', '#efefef');" onmouseout="$(this).css('background-color', '#fff');">
                        <h1><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_feed');?></h1>
                        <div style="padding-top: 7px; clear: both; width: 100%;">
                            <?php echo CHtml::textField('search_string', NULL, array('size'=>24, 'style'=>'height: 17px;'));?>
                            <?php echo CHtml::dropDownList('store', NULL, Store::getStoreOptions(Store::PLATFORM_EBAY), array('empty'=>array('all'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'all_stores')), 'style'=>'width: 120px;'));?>
                            <?php echo CHtml::dropDownList('ebay_site', NULL, eBaySiteIdCodeType::getSiteIdCodeTypeOptions(), array('empty'=>array('all'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'all_ebay_sites')), 'style'=>'width: 120px;'));?>
                            <?php echo CHtml::button(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'search'), array('id'=>'search_button', 'name'=>'search_button', 'style'=>'height: 23px;'));?>
                        </div>
                        <div id="searched_listing_table_div" style="padding-top: 7px; clear: both; width: 590px; display: none;">
                            <table id="searched_listing_table" border="0" cellspacing="0" cellpadding="0" width="100%"></table>
                        </div>
                        <div id="applied_listing_result" style="padding-top: 12px; clear: both; width: 100%; display: none;"></div>
                        <div id="applied_listing_result_empty" style="padding-top: 7px; clear: both; width: 100%;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_no_listing_selected');?></div>
                    </div>
                    <div style="height: 12px; clear: both; ">&nbsp;</div>
                    <hr />
                    <div style="width: 80%;clear: both;" onmouseover=" $(this).css('background-color', '#efefef');" onmouseout="$(this).css('background-color', '#fff');">
                        <h1><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_logo');?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'optional');?></h1>
                        <div style="padding-top: 7px; clear: both;">
                            <table cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td style="width: 80px; padding: 0px;" align="left">
                                        <div id="logoImage" class="DabE-j" style="float: left;">

                                        </div>
                                    </td>
                                    <td style="  vertical-align: bottom; padding: 0px;">
                                        <div id="removeLogo" class="removeButton" style="display: none;"></div>
                                        <input id="uploadLogoButton" type="button" value="Upload Logo" style="margin-left: 7px;" onclick="logo_upload_file.click();" />
                                        <input type="file" value="" id="logo_upload_file" name="logo_upload_file" style="display: none;" onchange="uploadLogoFile();" />
                                        <input type="hidden" value="" id="logo_value" name="logo_value" />
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr />
                    <div style="width: 80%;clear: both;" onmouseover=" $(this).css('background-color', '#efefef');" onmouseout="$(this).css('background-color', '#fff');">
                        <h1><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_headline');?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'optional');?></h1>
                        <div style="padding-top: 5px;"><input id="headline_value" name="headline_value" type="text" value="Headline text" size="40" style="height: 22px; padding-left: 5px;" maxlength="25" /></div>
                        <div style="display: block; padding-top: 5px;">
                            <img id="headlineOptions_img" src="/themes/facebook/images/rightArrow.png" />
                            <span id="headlineOptions" onclick="updateMoreOptionsUI('headlineOptions')" style="position: relative; top: -6px; cursor: pointer;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'more_options');?></span>
                        </div>
                        <div id="headlineOptions_panel" style="display: none; padding-top: 5px; padding-left: 7px;">
                            <div class="detailOption" style="padding-top: 0px;">
                                <div style="float: left"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_headline');?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'font_color');?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'optional');?></div>
                                <div style="float: right;">
                                    <span id="headlineColor" class="textColor">A</span>
                                    <input id="headlineColor_value" name="headlineColor_value" type="hidden" value="#000" />
                                </div>
                            </div>
                            <div class="detailOption">
                                <div style="float: left"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_headline');?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'background_color');?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'optional');?></div>
                                <div style="float: right;">
                                    <div id="headlineBackgroundColor" class="colorPicker" style="background-color: white;">&nbsp;</div>
                                    <input id="headlineBackgroundColor_value" name="headlineBackgroundColor_value" type="hidden" value="#fff" />
                                </div>
                            </div>
                            <div class="detailOption">
                                <div style="float: left"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_headline');?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'text_size');?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'optional');?></div>
                                <div style="float: right;"><input id="headlineTextSize_value" name="headlineTextSize_value" value="18" type="text" size="15" maxlength="5" style="padding-left: 5px;" /></div>
                            </div>
                            <div class="detailOption">
                                <div style="float: left"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_headline');?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'shadow');?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'optional');?></div>
                                <div style="float: right;">
                                    <select id="headlineShadow_value" name="headlineShadow_value">
                                        <option value="true"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'include_shadow');?></option>
                                        <option value="false" selected><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'no_shadow');?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="height: 12px; clear: both;">&nbsp;</div>
                    <hr />
                    <div style="width: 80%;clear: both;" onmouseover=" $(this).css('background-color', '#efefef');" onmouseout="$(this).css('background-color', '#fff');">
                        <h1><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_price_prefix');?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'optional');?></h1>
                        <div style="padding-top: 5px;"><input id="pricePrefix_value" name="pricePrefix_value" type="text" value="as low as" size="40" style="height: 22px; padding-left: 5px;" maxlength="25" /></div>
                        <div style="display: block; padding-top: 5px;">
                            <img id="pricePrefixOptions_img" src="/themes/facebook/images/rightArrow.png" />
                            <span id="pricePrefixOptions" onclick="updateMoreOptionsUI('pricePrefixOptions')" style="position: relative; top: -6px; cursor: pointer;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'more_options');?></span>
                        </div>
                        <div id="pricePrefixOptions_panel" style="display: none; padding-top: 5px; padding-left: 7px;">
                            <div class="detailOption" style="padding-top: 0px;">
                                <div style="float: left"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_price_prefix');?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'font_color');?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'optional');?></div>
                                <div style="float: right;">
                                    <span id="pricePrefixColor" class="textColor" style="color: #0073ED; border-bottom-color: #0073ED;">A</span>
                                    <input id="pricePrefixColor_value" name="pricePrefixColor_value" type="hidden" value="#0073ED" />
                                </div>
                            </div>
                            <div class="detailOption">
                                <div style="float: left"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_price_prefix');?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'text_size');?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'optional');?></div>
                                <div style="float: right;"><input id="pricePrefixTextSize_value" name="pricePrefixTextSize_value" value="11" type="text" size="15" maxlength="5" style="padding-left: 5px;" /></div>
                            </div>
                        </div>
                    </div>
                    <div style="height: 12px; clear: both; display: none;">&nbsp;</div>
                    <hr style="display: none;" />
                    <div style="width: 80%;clear: both; display: none;" onmouseover=" $(this).css('background-color', '#efefef');" onmouseout="$(this).css('background-color', '#fff');">
                        <h1><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_price_suffix');?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'optional');?></h1>
                        <div style="padding-top: 5px;"><input id="priceSuffix_value" name="priceSuffix_value" type="text" value="" size="40" style="height: 22px; padding-left: 5px;" maxlength="25" /></div>
                        <div style="display: block; padding-top: 5px;">
                            <img id="priceSuffixOptions_img" src="/themes/facebook/images/rightArrow.png" />
                            <span id="priceSuffixOptions" onclick="updateMoreOptionsUI('priceSuffixOptions')" style="position: relative; top: -6px; cursor: pointer;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'more_options');?></span>
                        </div>
                        <div id="priceSuffixOptions_panel" style="display: none; padding-top: 5px; padding-left: 7px;">
                            <div class="detailOption" style="padding-top: 0px;">
                                <div style="float: left"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_price_suffix');?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'font_color');?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'optional');?></div>
                                <div style="float: right;">
                                    <span id="priceSuffixColor" class="textColor" style="color: #B00000; border-bottom-color: #B00000;">A</span>
                                    <input id="priceSuffixColor_value" name="priceSuffixColor_value" type="hidden" value="#B00000" />
                                </div>
                            </div>
                            <div class="detailOption">
                                <div style="float: left"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_price_suffix');?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'text_size');?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'optional');?></div>
                                <div style="float: right;"><input id="priceSuffixTextSize_value" name="priceSuffixTextSize_value" value="18" type="text" size="15" maxlength="5" /></div>
                            </div>
                        </div>
                    </div>
                    <div style="height: 12px; clear: both;">&nbsp;</div>
                    <hr />
                    <div style="width: 80%;clear: both;" onmouseover=" $(this).css('background-color', '#efefef');" onmouseout="$(this).css('background-color', '#fff');">
                        <h1><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_button');?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'optional');?></h1>
                        <div style="padding-top: 5px;"><input id="button_value" name="button_value" type="text" value="Shop now!" size="40" style="height: 22px; padding-left: 5px;" maxlength="25" /></div>
                        <div style="display: block; padding-top: 5px;">
                            <img id="buttonOptions_img" src="/themes/facebook/images/rightArrow.png" />
                            <span id="buttonOptions" onclick="updateMoreOptionsUI('buttonOptions')" style="position: relative; top: -6px; cursor: pointer;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'more_options');?></span>
                        </div>
                        <div id="buttonOptions_panel"  style="display: none; padding-top: 5px; padding-left: 7px;">
                            <div class="detailOption" style="padding-top: 0px;">
                                <div style="float: left"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_button');?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'font_color');?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'optional');?></div>
                                <div style="float: right;">
                                    <span id="buttonTextColor" class="textColor" style="color: #000; border-bottom-color: #FFFFFF;">A</span>
                                    <input id="buttonTextColor_value" name="buttonTextColor_value" type="hidden" value="#FFFFFF" />
                                </div>
                            </div>
                            <div class="detailOption">
                                <div style="float: left"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_button');?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'color');?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'optional');?></div>
                                <div style="float: right;">
                                    <div id="buttonColor" class="colorPicker" style="background-color: #0073ED;">&nbsp;</div>
                                    <input id="buttonColor_value" name="buttonColor_value" type="hidden" value="#0073ED" />
                                </div>
                            </div>
                            <div class="detailOption" style="display: none;">
                                <div style="float: left"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_button');?>&nbsp;Rollover color&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'optional');?></div>
                                <div style="float: right;">
                                    <div id="rolloverColor" class="colorPicker" style="background-color: #004479;">&nbsp;</div>
                                    <input id="rolloverColor_value" name="rolloverColor_value" type="hidden" value="#004479" />
                                </div>
                            </div>
                            <div class="detailOption" style="display: none;">
                                <div style="float: left"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_button');?>&nbsp;corners&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'optional');?></div>
                                <div style="float: right;">
                                    <select id="buttonCorner_value" name="buttonCorner_value">
                                        <option value="round">Round corner</option>
                                        <option value="square" selected>Square corner</option>
                                    </select>
                                </div>
                            </div>
                            <div class="detailOption" style="display: none;">
                                <div style="float: left"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_button');?>&nbsp;bevel&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'optional');?></div>
                                <div style="float: right;">
                                    <select id="buttonBevel_value" name="buttonBevel_value">
                                        <option value="true" >Include bevel</option>
                                        <option value="false" selected>No bevel</option>
                                    </select>
                                </div>
                            </div>
                            <div class="detailOption">
                                <div style="float: left"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_button');?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'shadow');?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'optional');?></div>
                                <div style="float: right;">
                                    <select id="buttonShadow_value" name="buttonShadow_value">
                                        <option value="true"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'include_shadow');?></option>
                                        <option value="false" selected><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'no_shadow');?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="height: 12px; clear: both;">&nbsp;</div>
                    <hr />
                    <div style="width: 80%;clear: both;" onmouseover=" $(this).css('background-color', '#efefef');" onmouseout="$(this).css('background-color', '#fff');">
                        <h1><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_display_url');?></h1>
                        <div style="padding-top: 5px;"><input id="displayURL_value" name="displayURL_value" type="text" value="" size="60" style="height: 22px; padding-left: 5px;" maxlength="500" /></div>
                        <h1 style="padding-top: 5px;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_landing_page');?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'optional');?></h1>
                        <div style="padding-top: 5px;"><input id="landingPage_value" name="landingPage_value" type="text" value="" size="60" style="height: 22px; padding-left: 5px;" maxlength="500" /></div>
                        <div style="display: block; padding-top: 5px;">
                            <img id="landingPageOptions_img" src="/themes/facebook/images/rightArrow.png" />
                            <span id="landingPageOptions" onclick="updateMoreOptionsUI('landingPageOptions')" style="position: relative; top: -6px; cursor: pointer;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'more_options');?></span>
                        </div>
                        <div id="landingPageOptions_panel" style="display: none; padding-top: 5px; padding-left: 7px;">
                            <div class="detailOption">
                                <div style="float: left"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_click_behavior');?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'optional');?></div>
                                <div style="float: right;">
                                    <select id="clickBehavior_value" name="clickBehavior_value">
                                        <option value="product_url"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_nav_to_prod_url');?></option>
                                        <option value="ad_url"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_nav_to_ad_url');?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="padding: 12px; float: left;width: 35%;">
                    <h1 class="boldFont">AD preview</h1>
                    <div id="adPreViewM" style="width: 320px; height: 270px; padding-top: 12px;">
                        <div class="ad-container layout" style="width: 300px; height: 250px; ">
                            <div class="headline" minfontsize="11" multiline="false" truncate="true" valign="middle" style="overflow: hidden; white-space: nowrap;">
                                <span id="adPreViewM_headline" style="font-size: 18px; overflow: inherit; text-overflow: clip; white-space: inherit; display: inline-block; height: auto; vertical-align: middle; width: 100%;">Headline text</span>
                            </div>
                            <div class="carousel-bg">
                                <div class="carousel-wrapper">
                                    <div class="carousel-item" style="width: 300px;">
                                        <div class="products">
                                            <div class="product">
                                                <div class="product-content">
                                                    <div class="details">
                                                        <div class="productName">
                                                            <div minfontsize="9" multiline="true" truncate="true" valign="bottom" style="overflow: hidden; font-size: 12px;">
                                                                <span id="adPreViewM_itemHeadline1" style="font-size: 12px; overflow: inherit; text-overflow: clip; white-space: inherit; display: inline-block; height: 18px; vertical-align: bottom; width: 100%;">Summary</span>
                                                            </div>
                                                        </div>
                                                        <div class="product-price not-alone">
                                                            <div class="product-price-prefix inline-wrapper" minfontsize="9" multiline="false" truncate="true" valign="middle" style="overflow: hidden; white-space: nowrap; font-size: 11px;">
                                                                <span id="adPreViewM_pricePrefix" style="font-size: 11px; overflow: inherit; text-overflow: clip; white-space: inherit; display: inline-block; height: auto; vertical-align: middle; width: 100%;">as low as</span>
                                                            </div>
                                                            <div class="product-price-value inline-wrapper" minfontsize="9" multiline="false" truncate="true" valign="middle" style="overflow: hidden; white-space: nowrap; font-size: 11px;">
                                                                <span id="adPreViewM_itemPrice1" style="font-size: 11px; overflow: inherit; text-overflow: clip; white-space: inherit; display: inline-block; height: auto; vertical-align: middle; width: 100%;">Sale price</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="img-btn">
                                                        <div>
                                                            <div class="productImage" scaletype="fill" aligntype="left" style="overflow: hidden;">
                                                                <img id="adPreViewM_itemImage1" src="/themes/facebook/images/default_image.png" width="102" height="85" style="position: inherit; left: -2.5px; top: -8.5px;">
                                                            </div>
                                                            <div class="actions">
                                                                <span class="button inline-wrapper" minfontsize="11" multiline="false" truncate="true" valign="middle" style="overflow: hidden; white-space: nowrap; padding: 0px; position: relative; top: -30px;">
                                                                    <div id="adPreViewM_buttonDiv" class="cta-bg" style="width: 101.5px; height: 26px; position: absolute; border-bottom-color: rgb(0, 69, 142); border-bottom-width: 3px; border-bottom-style: solid; border-bottom-left-radius: 3px; border-bottom-right-radius: 3px; background: rgb(0, 115, 237);"></div>
                                                                    <span id="adPreViewM_button" style="font-size: 15px; overflow: inherit; text-overflow: clip; white-space: inherit; display: inline-block; height: auto; vertical-align: middle; width: 97px; color: rgb(255, 255, 255); position: relative; padding-top: 3px;">Shop now!</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product">
                                                <div class="product-content">
                                                    <div class="details">
                                                        <div class="productName">
                                                            <div minfontsize="9" multiline="true" truncate="true" valign="bottom" style="overflow: hidden; font-size: 12px;">
                                                                <span id="adPreViewM_itemHeadline2" style="font-size: 12px; overflow: inherit; text-overflow: clip; white-space: inherit; display: inline-block; height: 18px; vertical-align: bottom; width: 100%;">Summary</span>
                                                            </div>
                                                        </div>
                                                        <div class="product-price not-alone">
                                                            <div class="product-price-prefix inline-wrapper" minfontsize="9" multiline="false" truncate="true" valign="middle" style="overflow: hidden; white-space: nowrap; font-size: 11px;">
                                                                <span id="adPreViewM_pricePrefix" style="font-size: 11px; overflow: inherit; text-overflow: clip; white-space: inherit; display: inline-block; height: auto; vertical-align: middle; width: 100%;">as low as</span>
                                                            </div>
                                                            <div class="product-price-value inline-wrapper" minfontsize="9" multiline="false" truncate="true" valign="middle" style="overflow: hidden; white-space: nowrap; font-size: 11px;">
                                                                <span id="adPreViewM_itemPrice2" style="font-size: 11px; overflow: inherit; text-overflow: clip; white-space: inherit; display: inline-block; height: auto; vertical-align: middle; width: 100%;">Sale price</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="img-btn">
                                                        <div>
                                                            <div class="productImage" scaletype="fill" aligntype="left" style="overflow: hidden;">
                                                                <img id="adPreViewM_itemImage2" src="/themes/facebook/images/default_image.png" width="102" height="85" style="position: inherit; left: -2.5px; top: -8.5px;">
                                                            </div>
                                                            <div class="actions">
                                                                <span class="button inline-wrapper" minfontsize="11" multiline="false" truncate="true" valign="middle" style="overflow: hidden; white-space: nowrap; padding: 0px; position: relative; top: -30px;">
                                                                    <div id="adPreViewM_buttonDiv" class="cta-bg" style="width: 101.5px; height: 26px; position: absolute; border-bottom-color: rgb(0, 69, 142); border-bottom-width: 3px; border-bottom-style: solid; border-bottom-left-radius: 3px; border-bottom-right-radius: 3px; background: rgb(0, 115, 237);"></div>
                                                                    <span id="adPreViewM_button" style="font-size: 15px; overflow: inherit; text-overflow: clip; white-space: inherit; display: inline-block; height: auto; vertical-align: middle; width: 97px; color: rgb(255, 255, 255); position: relative; padding-top: 3px;">Shop now!</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="footer">
                                <div class="logo-wrapper w-disclaimer" style="padding: 2px; position: relative;top: -7px;">
                                    <div class="logo inline-wrapper" scaletype="fit" aligntype="left" style="overflow: hidden;">
                                        <img id="adPreViewM_logo" src="/themes/facebook/images/default_logo.png" width="132" height="49" style="position: inherit; left: 0px; top: 0px;">
                                    </div>
                                    <div class="disclaimer" minfontsize="8" multiline="false" truncate="true" style="overflow: hidden; white-space: nowrap;">
                                        <span style="font-size: 10px; overflow: inherit; text-overflow: clip; white-space: inherit;">Disclaimer</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="adPreViewSingle" style="width: 320px; height: 270px; padding-top: 22px;">
                        <div class="ad-container layout" style="width: 300px; height: 250px;">
                            <div class="content">
                                <div class="column image-container" style="margin: 0px;">
                                    <div class="logo-container ng-hide" flex="1">
                                        <div class="logo align-left" scaletype="fit" aligntype="center"></div>
                                    </div>
                                    <div class="product-image-container" style="width: 134px; height: 248px;">
                                        <div class="product-image noTBorder noBBorder" scaletype="fill" aligntype="center" style="overflow: hidden; width: 133px; height: 247px;">
                                            <img id="adPreViewSingle_itemImage" src="/themes/facebook/images/default_image.png" width="256" height="247" style="position: relative; left: -61.5px; top: 0px;">
                                        </div>
                                        <div class="disclaimer-container ng-hide" >
                                            <div class="disclaimer ng-binding border" valign="middle" minfontsize="8" multiline="false" truncate="true" style="overflow: hidden; white-space: nowrap;">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="column main-container" style="margin: 0px; overflow: hidden;">
                                    <div class="product-info" flex="1" data-interaction="urlchange" data-product-index="0" style="width: 164px; height: 178px;">
                                        <div class="product-info-content right shadow transition" style="width: 159px; height: 168px;">
                                            <div class="product-name" style="width: 153px; height: 35px;">
                                                <div class="product-name-wrapper ng-binding inline-wrapper transition" flex="1" ext-text-fit="" minfontsize="9" valign="middle" multiline="true" truncate="true" style="width: 153px; height: 35px; overflow: hidden; font-size: 14px;">
                                                    <span id="adPreViewSingle_itemHeadline" style="font-size: 14px; overflow: inherit; text-overflow: clip; white-space: inherit; display: inline-block; height: 32px; vertical-align: middle; width: 138px;">Summary</span>
                                                </div>
                                            </div>
                                            <div id="adPreViewSingle_itemSubTitle_div" class="product-subtitle" style="width: 153px; height: 27px; display: none;">
                                                <div class="product-subtitle-content ng-binding inline-wrapper transition" minfontsize="9" multiline="true" truncate="true" valign="middle" style="width: 153px; height: 27px; overflow: hidden;">
                                                    <span id="adPreViewSingle_itemSubTitle" style="font-size: 18px; overflow: inherit; text-overflow: clip; white-space: inherit; display: inline-block; height: 21px; vertical-align: middle; width: 138px;">sub title</span>
                                                </div>
                                                <div class="divider transition" style="width: 153px; height: 1px;"></div>
                                            </div>
                                            <div class="product-price-block" style="width: 153px; height: 56px;">
                                                <div class="product-price transition" style="width: 146px; height: 50px;">
                                                    <div class="product-price-prefix ng-binding inline-wrapper" valign="bottom" minfontsize="9" multiline="false" truncate="true" style="position: relative; top: 8px;text-align: left; width: 136px; height: 13px; overflow: hidden; white-space: nowrap;">
                                                        <span id="adPreViewSingle_pricePrefix" style="font-size: 12px; overflow: inherit; text-overflow: clip; white-space: inherit; display: inline-block; height: 14px; vertical-align: bottom; width: 136px;">as low as</span>
                                                    </div>
                                                    <div class="product-price-value ng-binding no-prefix inline-wrapper" minfontsize="9" multiline="false" truncate="true" style="text-align: left; width: 136px; height: 45px; overflow: hidden; white-space: nowrap;">
                                                        <span id="adPreViewSingle_itemPrice" style="padding-top: 13px; font-size: 20px; overflow: inherit; text-overflow: clip; white-space: inherit; display: inline-block; height: 28px; vertical-align: middle; width: 136px;">Sales price</span>
                                                    </div>
                                                </div>
                                                <div class="divider transition" style="width: 146px; height: 1px;"></div>
                                            </div>
                                            <div class="product-description-container" style="width: 153px; height: 42px; ">
                                                <div class="product-description ng-binding inline-wrapper transition" minfontsize="9" multiline="true" truncate="true" valign="middle" style="width: 153px; height: 42px; overflow: hidden; font-size: 11px;">
                                                    <span id="adPreViewSingle_itemDesc" style="font-size: 11px; overflow: inherit; text-overflow: clip; white-space: inherit; display: inline-block; height: 36px; vertical-align: middle; width: 143px;">Item description</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="headline left" style="width: 164px; height: 25px;">
                                        <div class="headline-content shadow left transition" style="width: 154px; height: 15px; overflow: visible; position: relative; left: -10px;">
                                            <span class="ng-binding inline-wrapper transition" minfontsize="11" multiline="false" valign="middle" truncate="true" title="Fashion Lady Long Colorful Scarf" style="width: 142px; height: 19px; overflow: hidden; white-space: nowrap; font-size: 11px;">
                                                <span id="adPreViewSingle_headline" style="font-size: 11px; overflow: inherit; text-overflow: clip; white-space: inherit; display: inline-block; height: 12px; vertical-align: middle; width: 142px;">Headline text</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="actions inline-wrapper align-right" style="width: 164px; height: 29px; position: relative; top: 40px; left: 65px;">
                                        <span id="adPreViewSingle_buttonSpan" class="button square inline-block valign-middle" style="width: 81px; height: 20px; background-color: #0073ed; border-color: #0073ed; color: #ffffff;">
                                          <span minfontsize="9" multiline="false" truncate="true" class="ng-binding" style="width: 67px; height: 20px; overflow: hidden; white-space: nowrap;">
                                              <span id="adPreViewSingle_button" style="font-size: 14px; overflow: inherit; text-overflow: clip; white-space: inherit; position: relative; top: -35px;">Shop now!</span>
                                          </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="height: 12px; clear: both;">&nbsp;</div>
            </div>
        </div>
    </div>
</div>

<div id="submit_panel" class="borderBlock">
    <div>
        <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
            <div style="height: 36px; color: #9197a3; font-weight: normal;">
                <h1 style="color: #4e5665; font-weight: 700; padding: 0px 0px 0px 12px; line-height: 38px; position: relative;">
                    <?php echo CHtml::submitButton(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'submit'), array('id'=>'form_submit', 'class'=>'greenButton', 'style'=>'font-size: 12px; line-height: 176%;')); ?>
                    <input type="button" value="<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'cancel');?>" class="greenButton" style="font-size: 12px; line-height: 166%;background: -webkit-linear-gradient(gray, gray); background-color: gray; -webkit-box-shadow: inset 0 1px 1px gray; border-color: gray;" onclick=" if(confirm('Are you sure to cancel and back to Advertisement list?')) window.location='<?php echo Yii::app()->createAbsoluteUrl("/marketing/advertisement/AD");?>' " />
                </h1>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<script>

    var maxTrackCount = 5;
    var currentListingID = [];
    var appliedLists = [];
    var adPreviewDefault = new Array();
    adPreviewDefault['itemHeadline'] = 'summary';
    adPreviewDefault['itemPrice'] = 'Sale price';
    adPreviewDefault['itemSubTitle'] = 'Sub title';
    adPreviewDefault['itemDesc'] = 'Item description';
    adPreviewDefault['itemImage'] = '/themes/facebook/images/default_image.png';
    adPreviewDefault['itemPrice'] = '$0.00';
    var listingParams = [];

    function uploadLogoFile()
    {
        var file = $("#logo_upload_file").val();
        var suffix = file.split('.');
        if(suffix.length<=1 || $.inArray(suffix[suffix.length-1].toLowerCase(), ['jpg', 'jpeg', 'png', 'gif'])) {
            alert('<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'select_image_file_to_upload');?>');
            return;
        }

        $.ajaxFileUpload({
            url:'<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/AD/uploadLogo");?>',
            secureuri:false,
            fileElementId:'logo_upload_file',
            dataType:'Text',
            success:function(data){
                var data = $.evalJSON(data)
                if(data['status']=='success')
                {
                    var image = data['data'];
                    $("#logoImage").css('background-image', "url("+image+")");
                    $("#adPreViewM_logo").prop('src', image);
                    $("#logo_value").val(image);
                    $("#logoImage").css('background-size', "100% 100%");
                    $("#removeLogo").css('display', 'inline-block');
                }
                else
                {
                    alert('<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'upload_failed_try_again');?>');
                }
            },
            error:function(data, status, e){
                alert('<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'upload_failed_try_again');?>');
            }
        });
    }

    function CheckInputInt(oInput)
    {
        if('' != oInput.value.replace(/\d{1,}\d{0,}/,''))
        {
            oInput.value = oInput.value.match(/\d{1,}\d{0,}/) == null ? '' :oInput.value.match(/\d{1,}\d{0,}/);
        }
    }

    function updateMoreOptionsUI(id)
    {
        if($("#"+id+"_panel").css('display') == 'none')
        {
            $("#"+id+"_panel").css('display', 'block');
            $("#"+id+"_img").prop('src', '/themes/facebook/images/downArrow.png');
        }
        else
        {
            $("#"+id+"_panel").css('display', 'none');
            $("#"+id+"_img").prop('src', '/themes/facebook/images/rightArrow.png');
        }
    }

    function updateFontColor(id, color)
    {
        if(color.toLowerCase() == "#ffffff")
        {
            $("#"+id).css('color', color);
            $("#"+id).css('background-color', '#000');
        }
        else
        {
            $("#"+id).css('color', color);
            $("#"+id).css('background-color', '#fff');
        }
        $("#"+id).css('border-bottom-color', color);
        $("#"+id+"_value").val(color);
    }

    function updateBackgroundColor(id, color)
    {
        $("#"+id).css('background-color', color);
        $("#"+id+"_value").val(color);
    }

    $(function(){
        $("#removeLogo").click(function(){
            $("#logoImage").css('background-image', "url(/themes/facebook/images/noimage.png)");
            $("#adPreViewM_logo").prop('src', "/themes/facebook/images/default_logo.png");
            $("#logoImage").css('background-size', "");
            $("#removeLogo").css('display', 'none');
            $("#logo_value").val('');
        });

        $("#headline_value").keyup(function(){
            $("#adPreViewM_headline").html($("#headline_value").val());
            $("#adPreViewSingle_headline").html($("#headline_value").val());
        });
        $("#headlineColor").hexColorPicker({
            "container":"dialog",
            "submitCallback":function(color){
                updateFontColor("headlineColor", color);
                $("#adPreViewM_headline").css('color', color);
            }
        });
        $("#headlineBackgroundColor").hexColorPicker({
            "container":"dialog",
            "submitCallback":function(color){
                updateBackgroundColor("headlineBackgroundColor", color);
                $("#adPreViewM_headline").css('background-color', color);
            }
        });
        $("#headlineTextSize_value").keyup(function(){
            CheckInputInt(this);
            $("#adPreViewM_headline").css('font-size', parseInt($("#headlineTextSize_value").val()));
        });
        $("#headlineShadow_value").change(function(){
            if($("#headlineShadow_value").val() == 'true')
                $("#adPreViewM_headline").css('text-shadow', '#000 2px 2px 5px');
            else
                $("#adPreViewM_headline").css('text-shadow', '');
        });

        $("#pricePrefix_value").keyup(function(){
            $("#adPreViewSingle_pricePrefix").html($("#pricePrefix_value").val());
            $("span[id^='adPreViewM_pricePrefix']").html($("#pricePrefix_value").val());
        });
        $("#pricePrefixColor").hexColorPicker({
            "container":"dialog",
            "submitCallback":function(color){
                updateFontColor("pricePrefixColor", color);
                $("#adPreViewSingle_pricePrefix").css('color', color);
                $("span[id^='adPreViewM_pricePrefix']").css('color', color);
            }
        });
        $("#pricePrefixTextSize_value").keyup(function(){
            CheckInputInt(this);
            $("#adPreViewSingle_pricePrefix").css('font-size', parseInt($("#pricePrefixTextSize_value").val()));
            $("span[id^='adPreViewM_pricePrefix']").css('font-size', parseInt($("#pricePrefixTextSize_value").val()));
        });


        $("#priceSuffixColor").hexColorPicker({
            "container":"dialog",
            "submitCallback":function(color){
                updateFontColor("priceSuffixColor", color);
            }
        });

        $("#button_value").keyup(function(){
            $("#adPreViewSingle_button").html($("#button_value").val());
            $("span[id^='adPreViewM_button']").html($("#button_value").val());
        });
        $("#buttonTextColor").hexColorPicker({
            "container":"dialog",
            "submitCallback":function(color){
                updateFontColor("buttonTextColor", color);
                $("#adPreViewSingle_button").css('color', color);
                $("span[id^='adPreViewM_button']").css('color', color);
            }
        });
        $("#buttonColor").hexColorPicker({
            "container":"dialog",
            "submitCallback":function(color){
                updateBackgroundColor("buttonColor", color);
                $("div[id^='adPreViewM_buttonDiv']").css('background-color', color);
                $("span[id^='adPreViewM_button']").css('background-color', color);
                $("#adPreViewSingle_button").css('background-color', color);
                $("#adPreViewSingle_buttonSpan").css('background-color', color);
            }
        });
        $("#buttonShadow_value").change(function(){
            if($("#buttonShadow_value").val() == 'true') {
                $("span[id^='adPreViewM_button']").css('text-shadow', '#000 0px 1px 0px');
                $("#adPreViewSingle_button").css('text-shadow', '#000 0px 1px 0px');
            }
            else {
                $("span[id^='adPreViewM_button']").css('text-shadow', '');
                $("#adPreViewSingle_button").css('text-shadow', '');
            }
        });
        $("#rolloverColor").hexColorPicker({
            "container":"dialog",
            "submitCallback":function(color){
                updateBackgroundColor("rolloverColor", color);
            }
        });

        $("#search_button").click(function(){
            var searchKeyword = $("#search_string").val();
            var searchSite = $("#ebay_site").val();
            var searchCategory = 'all';
            var searchStore = $("#store").val();

            var searchMode = 'normal';
            var searchEngine = 'normal';

            $("#ajaxloading").css("display", "block");

            $.ajax({
                type: "POST",
                url: '<?php echo Yii::app()->createAbsoluteUrl("eBay/eBayListing/searchAppliedListings");?>',
                data: {
                    searchKeyword:searchKeyword,
                    searchSite: searchSite,
                    searchCategory: searchCategory,
                    searchStore: searchStore,
                    searchMode: searchMode,
                    searchEngine: searchEngine,
                    excludeShipLocation: false,
                    searchListType: "<?php echo eBayListingTypeCodeType::FixedPriceItem;?>"
                },
                dataType: "JSON",
                success: function(data, status, xhr) {
                    $("#ajaxloading").css("display", "none");

                    if(data['status']=='success')
                    {
                        if($("#searched_listing_table_div").css('display') == 'none')
                            $("#searched_listing_table_div").css('display', 'block');

                        $("#searched_listing_table tr").remove();
                        for(var i=0;i<data['data'].length;i++)
                        {
                            var temp = data['data'][i];
                            temp = data['data'][i]['title'];
                            data['data'][i]['title'] = "";
                            $("#searched_listing_table").append(
                                "<tr>" +
                                "<td><input type='checkbox' id='searched_listing_id[]' name='searched_listing_id[]' value='"+data['data'][i]['ebay_listing_id']+"' onclick=' ' /></td>" +
                                "<td>"+(data['data'][i]['msku'])+"</td>" +
                                "<td>"+(data['data'][i]['storename'])+"</td>" +
                                "<td><a href='"+(data['data'][i]['viewurl'])+"' target='_blank'>"+(data['data'][i]['ebay_listing_id'])+"</a></td>" +
                                "<td><span title='"+(temp)+"'>"+((temp.length > 10 ? temp.substring(0,10) : temp)+'...')+"</span></td>" +
                                "<td><input type='button' value='<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'add');?>' onclick='addSearchedListingToTrack("+data['data'][i]['ebay_listing_id']+");' /><input id='searched_listing_"+data['data'][i]['ebay_listing_id']+"' type='hidden' value='"+$.toJSON(data['data'][i])+"'></td>"+
                                "</tr>"
                            );
                        }
                        if(data['data'].length>5)
                        {
                            $("#searched_listing_table_div").addClass('applied_listing_table_div');
                        }
                        else
                        {
                            $("#searched_listing_table_div").removeClass('applied_listing_table_div');
                        }
                    }
                    else
                    {
                        alert("<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'search_listing_failed');?>");
                    }
                },
                error: function(data, status, xhr) {
                    $("#ajaxloading").css("display", "none");
                    alert("<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'search_listing_failed');?>");
                }
            });
        });
    });

    function addSearchedListingToTrack(id)
    {
        if(id)
        {
            if($("#applied_listing_result span").length >= maxTrackCount)
            {
                alert("<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'reach_max_track_item_count');?>".replace("%s", maxTrackCount));
                return false;
            }

            addAppliedListingToTrack(id)
        }
        else
        {
            var appliedLists = $("input[id^='searched_listing_id']:checked");
            for(var i=0;i<appliedLists.length;i++)
            {
                if($("#applied_listing_result span").length >= maxTrackCount)
                {
                    alert("<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'reach_max_track_item_count');?>".replace("%s", maxTrackCount));
                    return false;
                }

                addAppliedListingToTrack($(appliedLists[i]).val());
            }
        }
    }

    function addAppliedListingToTrack(id)
    {
        if(id)
        {
            var obj = jQuery.parseJSON($("#searched_listing_"+id).val());
            if(obj == null) return false;
            var appliedList = $("input[id^='applied_listings_value']");
            for(var i=0;i<appliedList.length;i++)
            {
                if($(appliedList[i]).val()==obj.id)
                    return false;
            }
            var spanName = "applied_listing_id_"+obj.ebay_listing_id+"_"+obj.id;
            $("#applied_listing_result").html(
                $("#applied_listing_result").html()+
                "<span id='"+spanName+"' style='padding-right: 15px;'>"+"" +
                "<a href='/ebay/ebaylisting/view/id/"+obj.id+"' title='"+obj.title+"' target='_blank'>"+obj.ebay_listing_id+"</a>"+
                "<input id='applied_listings_value[]' name='applied_listings_value[]' value='"+obj.id+"' type='hidden' />"+
                "<div class='removeAppliedListing' onclick='removeAppliedListing($(\"#"+spanName +"\")[0])' ></div>"+
                "</span>"
            );

            updateAppliedListingPanel();
            //get listing params and save in local cache if needed
            getListingsParams('eBayListing', obj.id);

            return true;
        }
        else
        {
            return false;
        }
    }

    function removeAppliedListing(obj)
    {
        $(obj).remove();
        updateAppliedListingPanel();
        updateADPreview();
    }

    function getListingsParams(type, id)
    {
        if(listingParams["eBayListing_"+id] != undefined) {
            updateADPreview();
            return;
        }

        $("#ajaxloading").css("display", "block");

        $.ajax({
            type: "POST",
            url: '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/AD/getListingParams");?>',
            data: {
                itemType: type,
                id: id
            },
            dataType: "JSON",
            success: function (data, status, xhr) {
                $("#ajaxloading").css("display", "none");
                if(data['status']=='success')
                {
                    listingParams["eBayListing_"+id] = data['data'];
                    updateADPreview();
                }
                else
                {
                    alert("<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_get_product_failed');?>");
                }
            },
            error: function (data, status, xhr) {
                $("#ajaxloading").css("display", "none");
                alert("<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_get_product_failed');?>");
            }
        });
    }

    function updateADPreview()
    {
        var item = $($("#applied_listing_result input")[0]).val();
        var item2 = $($("#applied_listing_result input")[1]).val();
        if(item != undefined)
        {
            if(listingParams["eBayListing_"+item] == undefined)
                item = undefined;
            else
                item = listingParams["eBayListing_"+item];

            if(item2 != undefined && listingParams["eBayListing_"+item2] == undefined)
                item2 = getListingsParams('eBayListing', item2);
            else
                item2 = listingParams["eBayListing_"+item2];
        }

        //single & item1
        if(item != undefined && item['title'] != undefined) {
            $("#adPreViewSingle_itemHeadline").html(item['title']);
            $("#adPreViewM_itemHeadline1").html(item['title']);
            $("#adPreViewSingle_itemDesc").html(item['title']);
        }
        else {
            $("#adPreViewSingle_itemHeadline").html(adPreviewDefault['itemHeadline']);
            $("#adPreViewM_itemHeadline1").html(adPreviewDefault['itemDesc']);
            $("#adPreViewSingle_itemDesc").html(adPreviewDefault['itemDesc']);
        }
        if(item != undefined && item['subtitle'] != undefined) {
            $("#adPreViewSingle_itemSubTitle").html(item['subtitle']);
            $("#adPreViewSingle_itemSubTitle_div").css('display', 'block');
        }
        else {
            $("#adPreViewSingle_itemSubTitle").html('');
            $("#adPreViewSingle_itemSubTitle_div").css('display', 'none');
        }
        if(item != undefined && item['startprice'] != undefined) {
            $("#adPreViewSingle_itemPrice").html(item['startprice']);
            $("#adPreViewM_itemPrice1").html(item['startprice']);
        }
        else {
            $("#adPreViewSingle_itemPrice").html(adPreviewDefault['itemPrice']);
            $("#adPreViewM_itemPrice1").html(adPreviewDefault['itemPrice']);
        }
        if(item != undefined && item['picture'] != undefined) {
            $("#adPreViewSingle_itemImage").prop('src', item['picture']);
            $("#adPreViewM_itemImage1").prop('src', item['picture']);
        }
        else {
            $("#adPreViewSingle_itemImage").prop('src', adPreviewDefault['itemImage']);
            $("#adPreViewM_itemImage1").prop('src', adPreviewDefault['itemImage']);
        }

        //item2
        if(item2 != undefined && item2['title'] != undefined) {
            $("#adPreViewM_itemHeadline2").html(item2['title']);
        }
        else {
            $("#adPreViewM_itemHeadline2").html(adPreviewDefault['itemDesc']);
        }
        if(item2 != undefined && item2['startprice'] != undefined) {
            $("#adPreViewM_itemPrice2").html(item2['startprice']);
        }
        else {
            $("#adPreViewM_itemPrice2").html(adPreviewDefault['itemPrice']);
        }
        if(item2 != undefined && item2['picture'] != undefined) {
            $("#adPreViewM_itemImage2").prop('src', item2['picture']);
        }
        else {
            $("#adPreViewM_itemImage2").prop('src', adPreviewDefault['itemImage']);
        }

        if((item != undefined && item2 != undefined) || (item == undefined && item2 == undefined))
            $("#adPreViewM").css('display', 'block');
        else
            $("#adPreViewM").css('display', 'none');
    }

    function updateAppliedListingPanel()
    {
        if($("span[id^='applied_listing_id_']").length>0)
        {applied_listing_result
            $("#applied_listing_result_empty").css('display', 'none');
            $("#applied_listing_result").css('display', 'block');
        }
        else
        {
            $("#applied_listing_result_empty").css('display', 'block');
            $("#applied_listing_result").css('display', 'none');
        }
    }

    function geteBaySiteCode(siteID)
    {
        var siteText = "";
        switch(parseInt(siteID))
        {
            case <?php echo eBaySiteIdCodeType::US;?>:
                siteText = "<?php echo eBaySiteIdCodeType::getSiteIdCodeTypeText(eBaySiteIdCodeType::US);?>";
                break;
            case <?php echo eBaySiteIdCodeType::eBayMotors;?>:
                siteText = "<?php echo eBaySiteIdCodeType::getSiteIdCodeTypeText(eBaySiteIdCodeType::eBayMotors);?>";
                break;
            case <?php echo eBaySiteIdCodeType::Italy;?>:
                siteText = "<?php echo eBaySiteIdCodeType::getSiteIdCodeTypeText(eBaySiteIdCodeType::Italy);?>";
                break;
            case <?php echo eBaySiteIdCodeType::Belgium_Dutch;?>:
                siteText = "<?php echo eBaySiteIdCodeType::getSiteIdCodeTypeText(eBaySiteIdCodeType::Belgium_Dutch);?>";
                break;
            case <?php echo eBaySiteIdCodeType::Netherlands;?>:
                siteText = "<?php echo eBaySiteIdCodeType::getSiteIdCodeTypeText(eBaySiteIdCodeType::Netherlands);?>";
                break;
            case <?php echo eBaySiteIdCodeType::Australia;?>:
                siteText = "<?php echo eBaySiteIdCodeType::getSiteIdCodeTypeText(eBaySiteIdCodeType::Australia);?>";
                break;
            case <?php echo eBaySiteIdCodeType::Austria;?>:
                siteText = "<?php echo eBaySiteIdCodeType::getSiteIdCodeTypeText(eBaySiteIdCodeType::Austria);?>";
                break;
            case <?php echo eBaySiteIdCodeType::Spain;?>:
                siteText = "<?php echo eBaySiteIdCodeType::getSiteIdCodeTypeText(eBaySiteIdCodeType::Spain);?>";
                break;
            case <?php echo eBaySiteIdCodeType::Switzerland;?>:
                siteText = "<?php echo eBaySiteIdCodeType::getSiteIdCodeTypeText(eBaySiteIdCodeType::Switzerland);?>";
                break;
            /*case <?php echo eBaySiteIdCodeType::Taiwan;?>:
         siteText = "<?php echo eBaySiteIdCodeType::getSiteIdCodeTypeText(eBaySiteIdCodeType::Taiwan);?>";
         break;*/
            case <?php echo eBaySiteIdCodeType::Canada;?>:
                siteText = "<?php echo eBaySiteIdCodeType::getSiteIdCodeTypeText(eBaySiteIdCodeType::Canada);?>";
                break;
            case <?php echo eBaySiteIdCodeType::HongKong;?>:
                siteText = "<?php echo eBaySiteIdCodeType::getSiteIdCodeTypeText(eBaySiteIdCodeType::HongKong);?>";
                break;
            case <?php echo eBaySiteIdCodeType::India;?>:
                siteText = "<?php echo eBaySiteIdCodeType::getSiteIdCodeTypeText(eBaySiteIdCodeType::India);?>";
                break;
            case <?php echo eBaySiteIdCodeType::Ireland;?>:
                siteText = "<?php echo eBaySiteIdCodeType::getSiteIdCodeTypeText(eBaySiteIdCodeType::Ireland);?>";
                break;
            case <?php echo eBaySiteIdCodeType::Malaysia;?>:
                siteText = "<?php echo eBaySiteIdCodeType::getSiteIdCodeTypeText(eBaySiteIdCodeType::Malaysia);?>";
                break;
            case <?php echo eBaySiteIdCodeType::Canada_French;?>:
                siteText = "<?php echo eBaySiteIdCodeType::getSiteIdCodeTypeText(eBaySiteIdCodeType::Canada_French);?>";
                break;
            case <?php echo eBaySiteIdCodeType::Philippines;?>:
                siteText = "<?php echo eBaySiteIdCodeType::getSiteIdCodeTypeText(eBaySiteIdCodeType::Philippines);?>";
                break;
            case <?php echo eBaySiteIdCodeType::Poland;?>:
                siteText = "<?php echo eBaySiteIdCodeType::getSiteIdCodeTypeText(eBaySiteIdCodeType::Poland);?>";
                break;
            case <?php echo eBaySiteIdCodeType::Singapore;?>:
                siteText = "<?php echo eBaySiteIdCodeType::getSiteIdCodeTypeText(eBaySiteIdCodeType::Singapore);?>";
                break;
            /*case <?php echo eBaySiteIdCodeType::Sweden;?>:
         siteText = "<?php echo eBaySiteIdCodeType::getSiteIdCodeTypeText(eBaySiteIdCodeType::Sweden);?>";
         break;
         case <?php echo eBaySiteIdCodeType::China;?>:
         siteText = "<?php echo eBaySiteIdCodeType::getSiteIdCodeTypeText(eBaySiteIdCodeType::China);?>";
         break;*/
            case <?php echo eBaySiteIdCodeType::Belgium_French;?>:
                siteText = "<?php echo eBaySiteIdCodeType::getSiteIdCodeTypeText(eBaySiteIdCodeType::Belgium_French);?>";
                break;
            case <?php echo eBaySiteIdCodeType::UK;?>:
                siteText = "<?php echo eBaySiteIdCodeType::getSiteIdCodeTypeText(eBaySiteIdCodeType::UK);?>";
                break;
            case <?php echo eBaySiteIdCodeType::France;?>:
                siteText = "<?php echo eBaySiteIdCodeType::getSiteIdCodeTypeText(eBaySiteIdCodeType::France);?>";
                break;
            case <?php echo eBaySiteIdCodeType::Germany;?>:
                siteText = "<?php echo eBaySiteIdCodeType::getSiteIdCodeTypeText(eBaySiteIdCodeType::Germany);?>";
                break;
            default :
                siteText = "Unknown Site";
        }

        return siteText;
    }

    function validate()
    {
        var error = "";
        if($("#adName_value").val() == "")
            error += "<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_input_name_warning');?>\n";
        if($("#applied_listing_result input").length<=0)
            error += "<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_applied_listing_warning');?>\n";
        if($("#displayURL_value").val() == "")
            error += "<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_display_url_warning');?>\n";

        if(error.length>0)
        {
            alert(error);
            return false;
        }
        return true;
    }
</script>