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
    'eBay Listings'=>array('index'),
    'Bulk Update'
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
        position: relative;
        top: -10px;
    }
</style>

<style>
    #page { background-color: #e9eaed;border: none; }
</style>

<div style="padding: 5px 20px;">
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
    <h1>eBay Listings Bulk Update</h1>
    <hr/>
    <div>
        <h3>Step 1: Search eBay Listing</h3>
        <div id="search_input_panel">
            <div class="container">
                <?php echo CHtml::textField('search_string', NULL, array('size'=>48));?>
                <?php echo CHtml::dropDownList('store', NULL, Store::getStoreOptions(Store::PLATFORM_EBAY), array('empty'=>array('all'=>'All Stores')));?>
                <?php echo CHtml::dropDownList('ebay_site', NULL, eBaySiteIdCodeType::getSiteIdCodeTypeOptions(), array('empty'=>array('all'=>'All eBay Sites')));?>
                <?php echo CHtml::dropDownList('ebay_category', NULL, array(), array('empty'=>array('all'=>'All eBay Categories')));?>
                <?php echo CHtml::button('Search', array('id'=>'search_button', 'name'=>'search_button'));?><br />
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

    <div id="applied_listing_panel" class="padding-top-7" style="display: none;">
        <hr/>
        <h3>Step 2: Select Applied eBay List</h3>
        <div id="applied_listing_div">
            <table id="applied_listing_table" border="0" cellspacing="0" cellpadding="0" width="100%">
                <thead>
                <th><?php echo CHtml::checkBox('applied_listing_check_all', false, array('id'=>'applied_listing_check_all', 'checked'=>'', 'onclick'=>'appliedListingCheckAll(this)'));?></th>
                <th><?php echo CHtml::label('SKU', NULL);?></th>
                <th><?php echo CHtml::label('Store', NULL);?></th>
                <th><?php echo CHtml::label('eBay Id', NULL);?></th>
                <th><?php echo CHtml::label('Title', NULL);?></th>
                <th><?php echo CHtml::label('eBay Site', NULL);?></th>
                <th><?php echo CHtml::label('eBay Listing Type', NULL);?></th>
                <th><?php echo CHtml::label('Duration', NULL);?></th>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div id="update_rule_panel" class="padding-top-7" style="display: none;">
        <hr/>
        <h3>Step 3: Set Update Rule</h3>
        <div style="padding: 0px 10px 0px 10px;">
            <h4>
                <input id="update_price_panel_enable" name="update_price_panel_enable" type="checkbox" checked="checked" onclick="updateRulePanel(this, 'price');"/>
                <span>Update Price:</span>
            </h4>
            <div id="update_price_panel" class="update_panel">
                <select id="update_price_action" name="update_price_action">
                    <option value="Set">Set</option>
                    <option value="plus">+</option>
                    <option value="minus">-</option>
                    <option value="times">*</option>
                    <option value="divide">/</option>
                </select>
                <?php echo CHtml::textField('update_price_value', NULL, array('size'=>24, 'onkeyup'=>"CheckInputIntFloat(this)"));?>
                <select id="update_price_type" name="update_price_type">
                    <option value="amount">Amount($)</option>
                    <option value="percentage">Percentage(%)</option>
                </select>
            </div>
            <hr style="margin-top: 7px;" />
        </div>
        <div style="padding: 0px 10px 0px 10px;">
            <h4>
                <input id="update_quantity_panel_enable" name="update_quantity_panel_enable" type="checkbox" checked="checked" onclick="updateRulePanel(this, 'quantity');"/>
                <span>Update Quantity:</span>
            </h4>
            <div id="update_quantity_panel" class="update_panel">
                <?php echo CHtml::label('Inventory Level: ', NULL);?>
                <?php echo CHtml::textField('update_quantity_value', NULL, array('size'=>24, 'onkeyup'=>"CheckInputIntFloat(this)"));?>
            </div>
            <hr style="margin-top: 7px;" />
        </div>
        <div style="padding: 0px 10px 0px 10px;">
            <h4>
                <input id="update_description_panel_enable" name="update_description_panel_enable" type="checkbox" checked="checked" onclick="updateRulePanel(this, 'description');"/>
                <span>Update Description:</span>
            </h4>
            <div id="update_quantity_panel" class="update_panel" style="clear: both;">
                <div style="float: left; width: 13%;">
                    <div>
                        <select id="update_description_action" name="update_description_action">
                            <option value="add">Add</option>
                            <option value="remove">Remove</option>
                        </select>
                        <img height="16" width="24" border="0" src="/images/help.gif" onmouseout="HideHelp('update_description_action_help');" onmouseover="ShowHelp('update_description_action_help', 'Update Description', 'Add to or Remove from listing Description')" >
                        <div id="update_description_action_help" style="display: none;"></div>
                    </div>
                    <div style="height: 7px;"></div>
                    <div id="update_description_position_help_div">
                        <select id="update_description_position" name="update_description_position">
                            <option value="prepend">Prepend</option>
                            <option value="append">Append</option>
                        </select>
                        <img height="16" width="24" border="0" src="/images/help.gif" onmouseout="HideHelp('update_description_position_help');" onmouseover="ShowHelp('update_description_position_help', 'Add Position', 'Prepend(head) or Append(end) to listing Description')" >
                        <div id="update_description_position_help" style="display: none;"></div>
                    </div>
                </div>
                <div style="float: left; width: 85%; padding-left: 5px">
                    <?php echo CHtml::textField('update_description_tag', NULL, array('size'=>60, 'onkeyup'=>"value=value.replace(/[^a-zA-Z]/g,'')"));?>
                    <img height="16" width="24" border="0" src="/images/help.gif" onmouseout="HideHelp('d13');" onmouseover="ShowHelp('d13', 'Content Tag', 'Add/Remove content in this tag.<br />If you type SampleTag, will add or remove content within \<SampleTag\>\</SampleTag\>')" >
                    <div id="d13" style="display: none;"></div>
                    <div style="height: 7px;"></div>
                    <?php $this->widget('ext.UMeditor.UMeditor', array('initialFrameWidth'=>770, 'initialFrameHeight'=>340, 'htmlOptions'=>array('id'=>'add_description_value')));?>
                    <input type="hidden" id="update_description_value" name="update_description_value" />
                </div>
            </div>
            <hr style="margin-top: 7px;" />
        </div>
    </div>

    <div id="submit_panel" class="padding-top-7" style="display: none;">
        <?php echo CHtml::submitButton('Submit', array('id'=>'form_submit')); ?>
        <?php echo CHtml::checkBox('verifyonly', true);?>
        <?php echo CHtml::label('Verify Result First', NULL);?>
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
            }
            else
            {
                $("#update_description_position_help_div").css("display", "none");
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
        if($(obj).attr('checked') == 'checked')
        {
            $("#applied_listing_table tr input").attr('checked', 'checked');

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

        if($("#update_price_panel_enable").attr('checked') == 'checked')
        {
            panelEnabled = true;
            if($("#update_price_value").val() == "")
            {
                errorStr += "Please input price update amount/percent.\n";
            }
        }

        if($("#update_quantity_panel_enable").attr('checked') == 'checked')
        {
            panelEnabled = true;
            if($("#update_quantity_value").val() == "")
            {
                errorStr += "Please input Inventory Level to update.\n";
            }
        }

        if($("#update_description_panel_enable").attr('checked') == 'checked')
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
        if($(obj).attr('checked') == 'checked')
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