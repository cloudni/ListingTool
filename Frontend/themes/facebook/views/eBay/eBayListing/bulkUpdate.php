<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-11-18
 * Time: 2:57pm
 */

Yii::import('application.vendor.eBay.*');
require_once 'reference.php';

Yii::app()->clientScript->registerCoreScript('jquery');

$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ebay_listing')=>array('index'),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'bulk_update_ebay_listing')
);
?>

<style>
    .padding-top-7 {padding-top: 7px}

    .applied_listing_table_div{
        width: 100%;
        height: 400px;
        overflow-y: scroll;
        overflow-x: auto;
    }

    .update_panel{
        display: block;
        padding-left: 20px;
        margin-top: 8px;;
    }
</style>

<div>

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'bulk_update_form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array(
            'onsubmit'=>' return validate()',
        ),
        'action'=>$this->createAbsoluteUrl('/eBay/eBayListing/bulkUpdateSubmit'),
    )); ?>
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'step_1');?><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'search_ebay_item');?></h1>
                </div>
            </div>
            <div class="clearfix" style="border-top: 1px solid transparent;">
                <div id="search_input_panel" style="width: 100%; padding: 5px; margin: 0px;">
                    <div class="container">
                        <?php echo CHtml::textField('search_string', NULL, array('size'=>48));?>
                        <?php echo CHtml::dropDownList('store', NULL, Store::getStoreOptions(Store::PLATFORM_EBAY), array('empty'=>array('all'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'all_stores'))));?>
                        <?php echo CHtml::dropDownList('ebay_site', NULL, eBaySiteIdCodeType::getSiteIdCodeTypeOptions(), array('empty'=>array('all'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'all_ebay_sites'))));?>
                        <?php echo CHtml::dropDownList('ebay_category', NULL, array(), array('empty'=>array('all'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'all_ebay_categories'))));?>
                        <?php echo CHtml::button(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'search'), array('id'=>'search_button', 'name'=>'search_button'));?><br />
                        <a id="advanced_search_switch">Show Advanced Search...</a>
                    </div>
                    <div id="advanced_search_panel" style="display: none;">
                        <div class="container padding-top-7">
                            <div class="row left span-4">
                                <?php echo CHtml::label('Search Area: ', NULL, array('style'=>'font-weight: bold;'));?>
                            </div>
                            <div class="row left">
                                <?php echo CHtml::checkBox('search_area_sku', true);?><?php echo CHtml::label('SKU ', NULL);?>
                                <?php echo CHtml::checkBox('search_area_title', false);?><?php echo CHtml::label('Tile & Sub Tile ', NULL);?>
                                <?php echo CHtml::checkBox('search_area_description', false);?><?php echo CHtml::label('Description', NULL);?>
                            </div>
                        </div>
                        <div class="container padding-top-7">
                            <div class="row left span-4">
                                <?php echo CHtml::label('Search Engine: ', NULL, array('style'=>'font-weight: bold;'));?>
                            </div>
                            <div class="row left">
                                <?php echo CHtml::radioButton('search_engine', true, array('value'=>'normal'));?><?php echo CHtml::label('Normal ', NULL);?>
                                <?php echo CHtml::radioButton('search_engine', false, array('value'=>'regex'));?><?php echo CHtml::label('Regular Expression', NULL);?>
                            </div>
                        </div>
                        <div class="container padding-top-7">
                            <div class="row left span-4">
                                <?php echo CHtml::label('Search Range: ', NULL, array('style'=>'font-weight: bold;'));?>
                            </div>
                            <div class="row left">
                                <div>
                                    <div class="row left span-3">
                                        <?php echo CHtml::label('Price ', NULL);?>
                                    </div>
                                    <div class="row left">
                                        <?php echo CHtml::label('From $', NULL);?><?php echo CHtml::textField('search_range_price_from', NULL, array('size'=>12));?>
                                        <?php echo CHtml::label('To $', NULL);?><?php echo CHtml::textField('search_range_price_to', NULL, array('size'=>12));?>
                                    </div>
                                </div>
                                <div>
                                    <div class="row left span-3 padding-top-7">
                                        <?php echo CHtml::label('Sold Quantity ', NULL);?>
                                    </div>
                                    <div class="row left padding-top-7">
                                        <?php echo CHtml::label('From   ', NULL);?><?php echo CHtml::textField('search_range_sold_from', NULL, array('size'=>12, 'style'=>'margin-left: 7px;'));?>
                                        <?php echo CHtml::label('To   ', NULL);?><?php echo CHtml::textField('search_range_sold_to', NULL, array('size'=>12, 'style'=>'margin-left: 7px;'));?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container padding-top-7">
                            <div class="row left span-4">
                                <?php echo CHtml::label('Search Level: ', NULL, array('style'=>'font-weight: bold;'));?>
                            </div>
                            <div class="row left">
                                <?php echo CHtml::radioButton('search_level', true, array('value'=>'item'));?><?php echo CHtml::label('Item Level ', NULL);?>
                                <?php echo CHtml::radioButton('search_level', false, array('value'=>'sku'));?><?php echo CHtml::label('SKU Level', NULL);?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="applied_listing_panel" class="borderBlock" style="display: none;">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'step_2');?><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'select_ebay_item_to_update');?></h1>
                </div>
            </div>
            <div id="applied_listing_div" class="clearfix" style="border-top: 1px solid transparent;">
                <table id="applied_listing_table" border="0" cellspacing="0" cellpadding="0" width="100%">
                    <thead>
                    <th><?php echo CHtml::checkBox('applied_listing_check_all', false, array('id'=>'applied_listing_check_all', 'checked'=>'', 'onclick'=>'appliedListingCheckAll(this)'));?></th>
                    <th><?php echo CHtml::label('SKU', NULL);?></th>
                    <th><?php echo CHtml::label(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'stores'), NULL);?></th>
                    <th><?php echo CHtml::label(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ebay_item_id'), NULL);?></th>
                    <th><?php echo CHtml::label(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'title'), NULL);?></th>
                    <th><?php echo CHtml::label(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ebay_sites'), NULL);?></th>
                    <th><?php echo CHtml::label(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'listing_types'), NULL);?></th>
                    <th><?php echo CHtml::label(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'listing_duration'), NULL);?></th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="update_rule_panel" class="borderBlock" style="display: none;">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'step_3');?><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'set_update_rule');?></h1>
                </div>
            </div>
            <div class="clearfix" style="border-top: 1px solid transparent;">
                <div style="padding: 0px 10px 0px 10px;">
                    <h4>
                        <input id="update_price_panel_enable" name="update_price_panel_enable" type="checkbox" checked="checked" onclick="updateRulePanel(this, 'price');"/>
                        <span><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'update');?><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'item_price');?></span>
                    </h4>
                    <div id="update_price_panel" class="update_panel">
                        <select id="update_price_action" name="update_price_action">
                            <option value="Set"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'set');?></option>
                            <option value="plus"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'plus');?></option>
                            <option value="minus"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'minus');?></option>
                            <option value="times"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'multiply');?></option>
                            <option value="divide"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'divide');?></option>
                        </select>
                        <?php echo CHtml::textField('update_price_value', NULL, array('size'=>24, 'onkeyup'=>"CheckInputIntFloat(this)"));?>
                        <select id="update_price_type" name="update_price_type">
                            <option value="amount"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'amount_$');?></option>
                            <option value="percentage"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'percentage_%');?></option>
                        </select>
                    </div>
                    <hr style="margin-top: 7px;" />
                </div>
                <div style="padding: 0px 10px 0px 10px;">
                    <h4>
                        <input id="update_quantity_panel_enable" name="update_quantity_panel_enable" type="checkbox" checked="checked" onclick="updateRulePanel(this, 'quantity');"/>
                        <span><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'update');?><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'item_inventory_level');?></span>
                    </h4>
                    <div id="update_quantity_panel" class="update_panel">
                        <?php echo CHtml::label(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'item_inventory_level').': ', NULL);?>
                        <?php echo CHtml::textField('update_quantity_value', NULL, array('size'=>24, 'onkeyup'=>"CheckInputIntFloat(this)"));?>
                    </div>
                    <hr style="margin-top: 7px;" />
                </div>
                <div style="padding: 0px 10px 0px 10px;">
                    <h4>
                        <input id="update_description_panel_enable" name="update_description_panel_enable" type="checkbox" checked="checked" onclick="updateRulePanel(this, 'description');"/>
                        <span><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'update');?><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'item_description');?></span>
                    </h4>
                    <div id="update_description_panel" class="update_panel" style="clear: both;">
                        <div style="float: left; width: 13%;">
                            <div>
                                <select id="update_description_action" name="update_description_action">
                                    <option value="add"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'add');?></option>
                                    <option value="remove"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'remove');?></option>
                                </select>
                                <img height="16" width="24" border="0" src="/images/help.gif" onmouseout="HideHelp('update_description_action_help');" onmouseover="ShowHelp('update_description_action_help', '<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'update');?><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'item_description');?>', '<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'update_item_description_help');?>')" >
                                <div id="update_description_action_help" style="display: none;"></div>
                            </div>
                            <div style="height: 7px; clear: both;"></div>
                            <div id="update_description_position_help_div">
                                <select id="update_description_position" name="update_description_position">
                                    <option value="prepend"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'prepend');?></option>
                                    <option value="append"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'append');?></option>
                                </select>
                                <img height="16" width="24" border="0" src="/images/help.gif" onmouseout="HideHelp('update_description_position_help');" onmouseover="ShowHelp('update_description_position_help', '<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'add_description_position');?>', '<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'add_description_position_help');?>')" >
                                <div id="update_description_position_help" style="display: none;"></div>
                            </div>
                        </div>
                        <div style="float: left; width: 85%; padding-left: 5px">
                            <?php echo CHtml::textField('update_description_tag', NULL, array('size'=>60, 'onkeyup'=>"value=value.replace(/[^a-zA-Z]/g,'')"));?>
                            <img height="16" width="24" border="0" src="/images/help.gif" onmouseout="HideHelp('d13');" onmouseover="ShowHelp('d13', '<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'content_tag');?>', '<?php echo CHtml::encode(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'content_tag_help'));?>')" >
                            <div id="d13" style="display: none;"></div>
                            <div style="height: 7px;"></div>
                            <div id="update_description_editor"><?php $this->widget('ext.UMeditor.UMeditor', array('initialFrameWidth'=>770, 'initialFrameHeight'=>340, 'htmlOptions'=>array('id'=>'add_description_value')));?></div>
                            <input type="hidden" id="update_description_value" name="update_description_value" />
                        </div>
                    </div>
                    <div style="height: 7px; clear: both;">&nbsp;</div>
                    <hr />
                </div>
            </div>
        </div>
    </div>

    <div id="submit_panel" class="borderBlock" style="display: none;">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;">
                        <?php echo CHtml::submitButton(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'submit'), array('id'=>'form_submit', 'class'=>'greenButton', 'style'=>'font-size: 12px; line-height: 176%;')); ?>
                        <?php echo CHtml::checkBox('verifyonly', true);?>
                        <?php echo CHtml::label(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'verify_result_first'), NULL);?>
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <?php $this->endWidget(); ?>
</div>

<script>
    $(function(){
        $("#advanced_search_switch").click(function(){
            if($("#advanced_search_panel").css('display') == 'none')
            {
                $("#advanced_search_panel").css('display', 'block');
                $("#advanced_search_switch").html('Hide Advanced Search...');
            }
            else
            {
                $("#advanced_search_panel").css('display', 'none');
                $("#advanced_search_switch").html('Show Advanced Search...');
            }
        });

        $("#ebay_site").change(function(){
            if($("#ebay_site").val() == 'all')
            {
                eBayCategorySelectReset();
            }
            else
            {
                var categoris = geteBayCategoriesBySite($("#ebay_site").val());
            }
        });

        $("#search_button").click(function(){
            var searchKeyword = $("#search_string").val();
            var searchSite = $("#ebay_site").val();
            var searchCategory = $("#ebay_category").val();
            var searchStore = $("#store").val();

            var searchMode = $("#advanced_search_panel").css('display') == 'none' ? 'normal' : 'advanced';
            var searchEngine = $("#search_engine").val();

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
                    searchEngine: searchEngine
                },
                dataType: "JSON",
                success: function(data, status, xhr) {
                    $("#ajaxloading").css("display", "none");
                    if(data['status']=='success')
                    {
                        if($("#applied_listing_panel").css('display') == 'none')
                        {
                            $("#applied_listing_panel").css('display', 'block');
                        }
                        $("#applied_listing_table tr:gt(0)").remove()
                        for(var i=0;i<data['data'].length;i++)
                        {
                            $("#applied_listing_table tr:last").after(
                                "<tr>" +
                                    "<td><input type='checkbox' id='applied_listing[]' name='applied_listing[]' value='"+data['data'][i]['ebay_listing_id']+"' onclick='updateRuleAndSubmitPanel();' /></td>" +
                                    "<td>"+(data['data'][i]['msku'])+"</td>" +
                                    "<td>"+(data['data'][i]['store_id'])+"</td>" +
                                    "<td><a href='"+(data['data'][i]['viewurl'])+"' target='_blank'>"+(data['data'][i]['ebay_listing_id'])+"</a></td>" +
                                    "<td><span title='"+(data['data'][i]['title'])+"'>"+((data['data'][i]['title'].length > 20 ? data['data'][i]['title'].substring(0,20) : data['data'][i]['title'])+'...')+"</span></td>" +
                                    "<td>"+geteBaySiteCode(data['data'][i]['site_id'])+"</td>" +
                                    "<td>"+(data['data'][i]['listtype'])+"</td>" +
                                    "<td>"+(data['data'][i]['listduration'])+"</td>" +
                                "</tr>"
                            );
                        }
                        $("#applied_listing_check_all").removeAttr('checked');
                        if(data['data'].length>15)
                        {
                            $("#applied_listing_div").addClass('applied_listing_table_div');
                        }
                        else
                        {
                            $("#applied_listing_div").removeClass('applied_listing_table_div');
                        }
                    }
                    else
                    {
                        alert("Search Listing Failed!\n"+data['msg']+"\nPlease try again.");
                    }
                },
                error: function(data, status, xhr) {
                    $("#ajaxloading").css("display", "none");
                    alert("Search Listing Failed!\nPlease try again.");
                }
            });
        });

        $("#update_description_action").change(function(){
            if($("#update_description_action").val() == 'add')
            {
                $("#update_description_position_help_div").css("display", "");
                $("#update_description_editor").css("display", "");
            }
            else
            {
                $("#update_description_position_help_div").css("display", "none");
                $("#update_description_editor").css("display", "none");
            }
        });
    });

    function eBayCategorySelectReset()
    {
        var allCategory = "<option value=\"all\">All eBay Categories</option>";
        $("#ebay_category option").remove();
        $("#ebay_category").append(allCategory);
    }

    function geteBayCategoriesBySite(eBaySiteId)
    {
        $.ajax({
            type: "POST",
            url: '<?php echo Yii::app()->createAbsoluteUrl("eBay/eBayListing/geteBayCategories");?>',
            data: {
                site_id:eBaySiteId
            },
            dataType: "JSON",
            success: function(data, status, xhr) {
                if(data['status']=='success')
                {
                    eBayCategorySelectReset();
                    for(var i=0;i<data['data'].length;i++)
                    {
                        $("#ebay_category").append("<option value=\""+data['data'][i]['id']+"\">"+data['data'][i]['name']+"</option>");
                    }
                }
                else
                {
                    alert('Failed to load categories for site: '+ $("#ebay_site option:selected").text()+"\n"+data['msg']);
                    eBayCategorySelectReset();
                }
            },
            error: function(data, status, xhr) {
                alert('Failed to load categories for site: '+ $("#ebay_site option:selected").text());
                eBayCategorySelectReset();
            }
        });
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

    function appliedListingCheckAll(obj)
    {
        //alert($(obj).attr('checked'));return;
        if($(obj).prop('checked'))
        {
            $("#applied_listing_table tr input").prop('checked', true);
        }
        else
        {
            $("#applied_listing_table tr input").removeAttr('checked');
        }
        updateRuleAndSubmitPanel();
    }

    function updateRuleAndSubmitPanel()
    {
        if($("#applied_listing_table tr:gt(0) input:checkbox:checked").length <= 0)
        {
            $("#update_rule_panel").css('display', 'none');
            $("#submit_panel").css('display', 'none');
            $("#form_submit").attr('disabled',"true");
        }
        else
        {
            $("#update_rule_panel").css('display', 'block');
            $("#submit_panel").css('display', 'block');
            $("#form_submit").removeAttr('disabled');
        }
    }

    function validate()
    {
        var errorStr = "";
        var panelEnabled = false;

        if($("#applied_listing_table tr:gt(0) input:checked:checked").length<=0)
        {
            errorStr += "Please select eBay listing to update.\n";
        }

        if($("#update_price_panel_enable").prop('checked'))
        {
            panelEnabled = true;
            if($("#update_price_value").val() == "")
            {
                errorStr += "Please input price update amount/percent.\n";
            }
        }

        if($("#update_quantity_panel_enable").prop('checked'))
        {
            panelEnabled = true;
            if($("#update_quantity_value").val() == "")
            {
                errorStr += "Please input Inventory Level to update.\n";
            }
        }

        if($("#update_description_panel_enable").prop('checked'))
        {
            panelEnabled = true;
            if($("#update_description_tag").val() == "")
            {
                errorStr += "Please input description tag to update.\n";
            }
            else
            {
                $("#update_description_value").val(UM.getEditor('add_description_value').getContent());
            }
        }

        if(!panelEnabled)
        {
            alert("None update rule has been set!\nPlease select at least one rule to contiune!");
            return false;
        }
        if(errorStr.length>0)
        {
            alert(errorStr);
            return false;
        }

        return true;
    }

    function updateRulePanel(obj, id)
    {
        if($(obj).prop('checked'))
        {
            $("#update_"+id+"_panel").css('display', 'block');

        }
        else
        {
            $("#update_"+id+"_panel").css('display', 'none');
        }
    }

    function CheckInputIntFloat(oInput)
    {
        if('' != oInput.value.replace(/\d{1,}\.{0,1}\d{0,}/,''))
        {
            oInput.value = oInput.value.match(/\d{1,}\.{0,1}\d{0,}/) == null ? '' :oInput.value.match(/\d{1,}\.{0,1}\d{0,}/);
        }
    }
</script>