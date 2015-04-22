<style>
    #content{
        position: relative;
        top: -5px;
    }

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

    .searchedListingAddAll{
        background-image: url(/themes/facebook/images/NKweBg8DV6y.png);
        background-repeat: no-repeat;
        background-size: auto;
        background-position: -588px -160px;
        height: 12px;
        width: 12px;
        display: inline-block;
        cursor: pointer;
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

    .paddingDetailPanel
    {
        padding: 5px 5px 5px 12px;
    }
</style>

<div>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'target_tracking_form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array(
            'onsubmit'=>' return validate()',
        ),
        'action'=>$this->createAbsoluteUrl('/eBay/eBayTargetAndTrack/trackingSubmit'),
    )); ?>
    <input type="hidden" id="target_track_object_id" name="target_track_object_id" value="<?php echo $model->isNewRecord ? "" : $model->id; ?>" />
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'step_1');?><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'target_and_track_name');?></h1>
                </div>
            </div>
            <div class="clearfix" style="border-top: 1px solid transparent;">
                <div id="search_input_panel" style="width: 100%; padding: 0px; margin: 0px;">
                    <div class="container" style="padding: 5px 12px;">
                        <span><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'input_name');?></span><?php echo CHtml::textField('target_track_name', ($model->isNewRecord ? "" : $model->name), array('size'=>80));?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'step_2');?><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'search_ebay_item');?></h1>
                </div>
            </div>
            <div class="clearfix" style="border-top: 1px solid transparent;">
                <div id="search_input_panel" style="width: 100%; padding: 0px; margin: 0px;">
                    <div class="container" style="padding: 5px 12px;">
                        <?php echo CHtml::textField('search_string', NULL, array('size'=>36));?>
                        <?php echo CHtml::dropDownList('store', NULL, Store::getStoreOptions(Store::PLATFORM_EBAY), array('empty'=>array('all'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'all_stores'))));?>
                        <?php echo CHtml::dropDownList('ebay_site', NULL, eBaySiteIdCodeType::getSiteIdCodeTypeOptions(), array('empty'=>array('all'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'all_ebay_sites'))));?>
                        <?php echo CHtml::dropDownList('ebay_category', NULL, array(), array('empty'=>array('all'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'all_ebay_categories'))));?>
                        <?php echo CHtml::button(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'search'), array('id'=>'search_button', 'name'=>'search_button', 'class'=>'greenButton', 'style'=>'font-size: 12px; line-height: 176%;'));?>
                    </div>
                    <div id="searched_listing_table_div" style="display: none; border-top: 1px solid #e9eaed;">
                        <table id="searched_listing_table" border="0" cellspacing="0" cellpadding="0" width="100%">
                            <thead>
                            <th width="40px">
                                <?php echo CHtml::checkBox('searched_listing_check_all', false, array('id'=>'searched_listing_check_all', 'checked'=>'', /*'onclick'=>'searchedListingCheckAll(this)'*/));?>
                                <div onclick="addSearchedListingToTrack();" class="searchedListingAddAll"></div>
                            </th>
                            <th><?php echo CHtml::label('SKU', NULL);?></th>
                            <th><?php echo CHtml::label(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'stores'), NULL);?></th>
                            <th><?php echo CHtml::label(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ebay_item_id'), NULL);?></th>
                            <th><?php echo CHtml::label(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'title'), NULL);?></th>
                            <th><?php echo CHtml::label(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ebay_sites'), NULL);?></th>
                            <th><?php echo CHtml::label(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'listing_types'), NULL);?></th>
                            <th><?php echo CHtml::label(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'listing_duration'), NULL);?></th>
                            <th width="40px"><?php echo CHtml::label(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'action'), NULL);?></th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="applied_listing_panel" class="borderBlock" style="display: <?php echo $model->isNewRecord ? "none" : "block"; ?>;">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'step_3');?><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'select_ebay_listing_to_track');?></h1>
                </div>
            </div>
            <div id="applied_listing_div" class="clearfix" style="border-top: 1px solid transparent;">
                <div id="applied_listing_result" class="paddingDetailPanel">
                    <?php if(!$model->isNewRecord && !empty($trackingList)) foreach($trackingList as $tracking):?>
                        <?php $spanName = "applied_listing_id_".$tracking['ebay_listing_id']."_".$tracking['id'];?>
                        <span id='<?php echo $spanName;?>' style='padding-right: 15px;'>
                            <a href='/ebay/ebaylisting/view/id/<?php echo $tracking['id'];?>' title='<?php echo $tracking['title'];?>' target='_blank'><?php echo $tracking['ebay_listing_id'];?></a>
                            <input id='applied_listings_value[]' name='applied_listings_value[]' value='<?php echo $tracking['id'];?>' type='hidden' />
                            <div class='removeAppliedListing' onclick="removeAppliedListing('<?php echo $spanName;?>')" style="left: -4px;" ></div>
                        </span>
                    <?php endforeach;?>
                </div>
                <div id="applied_listing_result_empty" class="paddingDetailPanel" style="display: <?php echo $model->isNewRecord ? "block" : "none"; ?>;">No eBay listings applied.</div>
            </div>
        </div>
    </div>

    <div id="target_ebay_item_panel" class="borderBlock" style="display: <?php echo $model->isNewRecord ? "none" : "block"; ?>;">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'step_4');?><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'select_your_target_item');?></h1>
                </div>
            </div>
            <div class="clearfix" style="border-top: 1px solid transparent;">
                <div style="padding: 5px 0px 5px 12px;">
                    <input id="targeteBayItemIdSearch" type="text" size="36" />
                    <?php echo CHtml::button(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'add'), array('id'=>'targeteBayItemSearchButton', 'name'=>'', 'class'=>'greenButton', 'style'=>'font-size: 12px; line-height: 176%;'));?>
                </div>
                <div>
                    <table id="target_ebay_item_table" border="0" cellspacing="0" cellpadding="0" width="100%">
                        <thead>
                        <th><input type="checkbox" id="target_check_all_ebay_item" /></th>
                        <th><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ebay_item_id');?></th>
                        <th><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'title');?></th>
                        <th><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'current_price');?></th>
                        <th><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'seller_name');?></th>
                        <th><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ebay_sites');?></th>
                        <th><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'listing_types');?></th>
                        </thead>
                        <tbody>
                            <?php if(!$model->isNewRecord && !empty($targetList)) foreach($targetList as $target): ?>
                                <tr>
                                    <td><input type='checkbox' checked='checked' id='target_ebay_item_id[]' name='target_ebay_item_id[]' value='<?php echo $target['ebay_listing_id'];?>' onclick='updateTrackPriceRulePanel();' /></td>
                                    <td><?php echo $target['ebay_listing_id'];?></td>
                                    <td><span title='<?php echo $target['title'];?>'><?php echo (strlen($target['title']) > 20 ? substr($target['title'], 0, 20).'...' : $target['title']);?></span></td>
                                    <td><?php echo $target['currency'].' '.sprintf("%1\$.2f", $target['price']);?></td>
                                    <td><?php echo $target['seller'];?></td>
                                    <td><?php echo $target['site'];?></td>
                                    <td><?php echo $target['listtype'];?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="tracking_rule_panel" class="borderBlock" style="display: <?php echo $model->isNewRecord ? "none" : "block"; ?>;">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'step_5');?><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'setup_ebay_tracking_rule');?></h1>
                </div>
            </div>
            <div class="clearfix" style="border-top: 1px solid transparent;">
                <div id="tracking_price_rule" class="paddingDetailPanel">
                    <div>
                        <span><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'target_price_changed_update_tracking_price');?></span>
                        <select id="update_price_target" name="update_price_target">
                            <?php if(!$model->isNewRecord && !empty($updateParam)):?>
                            <?php if($updateParam->price->target == 'target' && count($targetList) <= 1):?>
                                <option value="target"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'target_price');?></option>
                            <?php else: ?>
                                <option value="average" <?php echo $updateParam->price->target == 'average' ? "selected='selected'" : ""; ?>><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'average_price');?></option>
                                <option value="highest" <?php echo $updateParam->price->target == 'highest' ? "selected='selected'" : ""; ?>><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'target_highest_price');?></option>
                                <option value="lowest" <?php echo $updateParam->price->target == 'lowest' ? "selected='selected'" : ""; ?>><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'target_lowest_price');?></option>
                            <?php endif;?>
                            <?php endif;?>
                        </select>
                        <select id="update_price_action" name="update_price_action">
                            <option value="plus" <?php echo !$model->isNewRecord && !empty($updateParam) && $updateParam->price->action == 'plus' ? "selected='selected'" : ""; ?>><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'plus');?></option>
                            <option value="minus" <?php echo !$model->isNewRecord && !empty($updateParam) && $updateParam->price->action == 'minus' ? "selected='selected'" : ""; ?>><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'minus');?></option>
                            <option value="times" <?php echo !$model->isNewRecord && !empty($updateParam) && $updateParam->price->action == 'times' ? "selected='selected'" : ""; ?>><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'multiply');?></option>
                            <option value="divide" <?php echo !$model->isNewRecord && !empty($updateParam) && $updateParam->price->action == 'divide' ? "selected='selected'" : ""; ?>><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'divide');?></option>
                        </select>
                        <input type="text" size="24" id="update_price_value" name="update_price_value" value="<?php echo !$model->isNewRecord && !empty($updateParam) ? $updateParam->price->value : "";?>" onkeyup="CheckInputIntFloat(this);" />
                        <select id="update_price_type" name="update_price_type">
                            <option value="amount" <?php echo !$model->isNewRecord && !empty($updateParam) && $updateParam->price->type == 'amount' ? "selected='selected'" : ""; ?>><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'amount_$');?></option>
                            <option value="percentage" <?php echo !$model->isNewRecord && !empty($updateParam) && $updateParam->price->type == 'percentage' ? "selected='selected'" : ""; ?>><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'percentage_%');?></option>
                        </select>
                    </div>
                    <div style="padding-top: 7px;">
                        <span style="display: inline-block; width: 250px;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'set_highest_price');?></span>
                        <input type="text" size="24" id="update_price_value_highest" name="update_price_value_highest" value="<?php echo !$model->isNewRecord && !empty($updateParam) ? $updateParam->price->highest_value : "";?>" onkeyup="CheckInputIntFloat(this);" />
                    </div>
                    <div style="padding-top: 7px;">
                        <span style="display: inline-block; width: 250px;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'set_lowest_price');?></span>
                        <input type="text" size="24" id="update_price_value_lowest" name="update_price_value_lowest" value="<?php echo !$model->isNewRecord && !empty($updateParam) ? $updateParam->price->lowest_value : "";?>" onkeyup="CheckInputIntFloat(this);" />
                    </div>
                    <div style="padding-top: 7px;">
                        <span class="boldFont" style="display: inline-block; width: 250px;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'target_notification_only');?></span>
                        <input type="checkbox" id="update_price_notification_only" name="update_price_notification_only" <?php echo !$model->isNewRecord && !empty($updateParam) && isset($updateParam->price->notification_only) && $updateParam->price->notification_only ? "checked='checked'" : ""; ?>/>
                    </div>
                    <div style="padding-top: 7px;">
                        <span class="boldFont" style="display: inline-block; width: 250px;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'set_active');?></span>
                        <?php echo CHtml::dropDownList("target_track_active", ($model->isNewRecord ? NULL : $model->is_active), $model->getIsActiveOptions(), array());?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="submit_panel" class="borderBlock" style="display: <?php echo $model->isNewRecord ? "none" : "block"; ?>;">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 12px; line-height: 38px; position: relative;">
                        <input type="submit" id="form_submit" value="<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'submit');?>" class="greenButton" style="font-size: 12px; line-height: 176%;" />
                        <input type="button" id="form_cancel" class="greenButton" style="font-size: 12px; line-height: 176%;" value="<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'cancel');?>" onclick=" window.location.href='<?php echo $this->createAbsoluteUrl('/eBay/eBayTargetAndTrack');?>';" />
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <?php $this->endWidget(); ?>
</div>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.json.min.js"></script>

<script>
    var maxTrackCount = 20;
    var maxTargetCount = 20;

    function count(o){
        var t = typeof o;
        if(t == 'string'){
            return o.length;
        }else if(t == 'object'){
            var n = 0;
            for(var i in o){
                n++;
            }
            return n;
        }
        return false;
    };

    $(function() {
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
                    excludeShipLocation: false
                },
                dataType: "JSON",
                success: function(data, status, xhr) {
                    $("#ajaxloading").css("display", "none");

                    if(data['status']=='success')
                    {
                        if($("#searched_listing_table_div").css('display') == 'none')
                            $("#searched_listing_table_div").css('display', 'block');

                        $("#searched_listing_table tr:gt(0)").remove();
                        for(var i=0;i<data['data'].length;i++)
                        {
                            var temp = data['data'][i];
                            temp = data['data'][i]['title'];
                            data['data'][i]['title'] = "";
                            $("#searched_listing_table tr:last").after(
                                "<tr>" +
                                "<td><input type='checkbox' id='searched_listing_id[]' name='searched_listing_id[]' value='"+data['data'][i]['ebay_listing_id']+"' onclick=' ' /></td>" +
                                "<td>"+(data['data'][i]['msku'])+"</td>" +
                                "<td>"+(data['data'][i]['storename'])+"</td>" +
                                "<td><a href='"+(data['data'][i]['viewurl'])+"' target='_blank'>"+(data['data'][i]['ebay_listing_id'])+"</a></td>" +
                                "<td><span title='"+(temp)+"'>"+((temp.length > 10 ? temp.substring(0,10) : temp)+'...')+"</span></td>" +
                                "<td>"+geteBaySiteCode(data['data'][i]['site_id'])+"</td>" +
                                "<td>"+(data['data'][i]['listtype'])+"</td>" +
                                "<td>"+(data['data'][i]['listduration'])+"</td>" +
                                "<td><input type='button' value='Add' onclick='addSearchedListingToTrack("+data['data'][i]['ebay_listing_id']+");' /><input id='searched_listing_"+data['data'][i]['ebay_listing_id']+"' type='hidden' value='"+$.toJSON(data['data'][i])+"'></td>"+
                                "</tr>"
                            );
                        }
                        $("#searched_listing_check_all").removeAttr('checked');
                        if($("#applied_listing_panel").css('display') == 'none') $("#applied_listing_panel").css('display', 'block');
                        if(data['data'].length>12)
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

        $("#searched_listing_check_all").click(function(){
            //alert($(obj).attr('checked'));return;
            if($(this).prop('checked'))
            {
                $("#searched_listing_table tr input[type='checkbox']").prop('checked', true);
            }
            else
            {
                $("#searched_listing_table tr input[type='checkbox']").removeAttr('checked');
            }
        });

        $("#targeteBayItemSearchButton").click(function(){
            var id = $("#targeteBayItemIdSearch").val();
            if(id.length <= 9)
            {
                alert("<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'please_input_valid_ebay_item_id');?>");
                return;
            }

            //check if exist
            for(var i=0;i<$("input[type='checkbox'][id^='target_ebay_item_id'").length;i++)
            {
                if($($("input[type='checkbox'][id^='target_ebay_item_id'")[i]).val() == id)
                {
                    alert("<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'error_same_ebay_item_already_in_list');?>");
                    return;
                }
            }

            if($("#target_ebay_item_table tr:gt(0)").length >= maxTargetCount)
            {
                alert("<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'reach_max_target_item_count');?>".replace("%s", maxTargetCount));
                return false;
            }

            $("#ajaxloading").css("display", "block");

            $.ajax({
                type: "POST",
                url: '<?php echo Yii::app()->createAbsoluteUrl("eBay/eBayTargetAndTrack/searcheBayItemShoppingAPI");?>',
                data: {
                    id: $("#targeteBayItemIdSearch").val()
                },
                dataType: "JSON",
                success: function (data, status, xhr) {
                    $("#ajaxloading").css("display", "none");
                    if (data['status'] == 'success')
                    {
                        $("#target_ebay_item_table tr:last").after(
                            "<tr>" +
                            "<td><input type='checkbox' checked='checked' id='target_ebay_item_id[]' name='target_ebay_item_id[]' value='"+data['data']['ebay_listing_id']+"' onclick='updateTrackPriceRulePanel();' /></td>" +
                            "<td>"+(data['data']['ebay_listing_id'])+"</td>" +
                            "<td><span title='"+(data['data']['title'])+"'>"+(data['data']['title'].length > 20 ? data['data']['title'].substring(0,20)+'...' : data['data']['title'])+"</span></td>" +
                            "<td>"+(data['data']['currency'])+' '+parseFloat(data['data']['price']).toFixed(2)+"</td>" +
                            "<td>"+(data['data']['seller'])+"</td>" +
                            "<td>"+(data['data']['site'])+"</td>" +
                            "<td>"+(data['data']['listtype'])+"</td>" +
                            "</tr>"
                        );
                        updateTrackPriceRulePanel();
                    }
                    else {
                        alert("<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'fail_target_ebay_item');?>");
                    }
                    $("#targeteBayItemIdSearch").val('');
                },
                error: function (data, status, xhr) {
                    $("#ajaxloading").css("display", "none");
                    alert("<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'fail_target_ebay_item');?>");
                    $("#targeteBayItemIdSearch").val('');
                }
            });
        });

        $("#target_check_all_ebay_item").click(function(){
            if($("#target_check_all_ebay_item").prop('checked'))
            {
                $("#target_ebay_item_table tr input[type='checkbox']").prop('checked', true);
            }
            else
            {
                $("#target_ebay_item_table tr input[type='checkbox']").removeAttr('checked');
            }

            updateTrackPriceRulePanel();
        });
    });

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
                    alert("<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'fail_load_ebay_category');?>".replace("%s", $("#ebay_site option:selected").text()));
                    eBayCategorySelectReset();
                }
            },
            error: function(data, status, xhr) {
                alert("<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'fail_load_ebay_category');?>".replace("%s", $("#ebay_site option:selected").text()));
                eBayCategorySelectReset();
            }
        });
    }

    function eBayCategorySelectReset()
    {
        var allCategory = "<option value=\"all\">All eBay Categories</option>";
        $("#ebay_category option").remove();
        $("#ebay_category").append(allCategory);
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
        $("#"+obj).remove();
        updateAppliedListingPanel();
    }

    function updateAppliedListingPanel()
    {
        if($("span[id^='applied_listing_id_']").length>0)
        {
            $("#applied_listing_result_empty").css('display', 'none');
            $("#target_ebay_item_panel").css('display', 'block');
        }
        else
        {
            $("#applied_listing_result_empty").css('display', 'block');
            $("#target_ebay_item_panel").css('display', 'none');
        }
    }

    function CheckInputIntFloat(oInput)
    {
        if('' != oInput.value.replace(/\d{1,}\.{0,1}\d{0,}/,''))
        {
            oInput.value = oInput.value.match(/\d{1,}\.{0,1}\d{0,}/) == null ? '' :oInput.value.match(/\d{1,}\.{0,1}\d{0,}/);
        }
    }

    function updateTrackPriceRulePanel()
    {
        if($("#target_ebay_item_table tr:gt(0) input:checked:checked").length > 0)
        {
            $("#tracking_rule_panel").css('display', 'block');
            $("#submit_panel").css('display', 'block');

            if($("#target_ebay_item_table tr:gt(0) input:checked:checked").length > 1)
            {
                if($("#update_price_target option").length <= 1)
                {
                    $("#update_price_target option").remove();
                    $("#update_price_target").append("<option value='average'><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'average_price');?></option>"+
                    "<option value='highest'><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'target_highest_price');?></option>"+
                    "<option value='lowest'><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'target_lowest_price');?></option>");
                    $("#update_price_target").val('average');
                }
            }
            else
            {
                if($("#update_price_target").val() != 'target' || $("#update_price_target option").length > 1)
                {
                    $("#update_price_target option").remove();
                    $("#update_price_target").append("<option value='target'><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'target_price');?></option>");
                    $("#update_price_target").val('target');
                }
            }
        }
        else
        {
            $("#tracking_rule_panel").css('display', 'none');
            $("#submit_panel").css('display', 'none');
        }
    }

    function validate()
    {
        var error = "";
        if($("#target_track_name").val() == "")
        {
            error += "<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'please_input_target_track_name');?>";
        }
        if($("span[id^='applied_listing_id_']").length<=0)
        {
            error += "<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'please_add_track_list');?>";
        }
        if($("#target_ebay_item_table tr:gt(0) input[type='checkbox'][checked='checked']").length <= 0)
        {
            error += "<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'please_add_target_list');?>";
        }
        if(!$("#update_price_notification_only").prop('checked') && $("#update_price_value").val() == "")
        {
            error += "<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'please_input_update_price_or_set_notification');?>";
        }
        if(error != "")
        {
            alert(error);
            return false;
        }
        return true;
    }

</script>