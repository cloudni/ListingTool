<?php
/* @var $this ADGroupController */
/* @var $adCampaign ADCampaign */
/* @var $adGroupPerformance array */
/* @var $campaignList array */

$this->breadcrumbs=array(
    'Marketing'=>array("/marketing/home"),
    'Advertisement'=>array("/marketing/advertisement/home"),
    'AD Campaign'=>array('/marketing/advertisement/adcampaign/index'),
    'AD Group',
);

$this->menu=array(
    array('label'=>'AD Group Index', 'url'=>array('index')),
    array('label'=>'AD Group Create', 'url'=>array('create')),
);
?>

<style>
    .ui-menu { position: absolute; z-index: 1; min-width: 122px; }

    .redButton {
        -webkit-border-radius: 2px;
        font-size: 14px;
        height: 26px;
        background-color: #DD4B3B;
        color: #FFF;
        font-weight: bold;
        background: -webkit-linear-gradient(#DD4B3B, #DD4B3B);
        -webkit-box-shadow: inset 0 1px 1px #DD4B3B;
        position: relative;
        top: 1px;
    }

    .menuButton{
        height: 25px;
        min-width: 52px;
        text-align: left;
    }
</style>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock" style="border: none;">
        <div>
            <div style="background: #e9eaed; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <input type="button" class="boldFont greenButton redButton" value="+ AD Group" onclick=" window.location='<?php $campaignid = (isset($adCampaign) ? array('campaignid'=>$adCampaign->id) : array()); echo Yii::app()->createAbsoluteUrl("marketing/advertisement/adgroup/create", $campaignid); ?>';" />
                    <?php echo CHtml::dropDownList('campaignList', (isset($adCampaign) ? $adCampaign->id : null), CHtml::listData($campaignList, 'id', 'name'), array('empty'=>'Please select AD campaign to filter', 'style'=>'height: 26px; position: relative; top: 1px; width: 150px;'));?>
                    <input id="menu_campaign_filter_button" type="button" value="All ▼" disabled class="menuButton" onclick="showMenu('menu_campaign_filter');" />
                    <ul id="menu_campaign_filter" class="ui-menu" style="width: 180px;" >
                        <li value="All_Campaigns">All AD Groups</li>
                        <li value="All_enabled_Campaigns">All enabled AD Groups</li>
                        <li value="All_but_removed_Campaigns">All but removed AD Groups</li>
                    </ul>
                    <input id="menu_edit_action_button" type="button" value="Edit ▼" class="menuButton" onclick="showMenu('menu_edit_action');" />
                    <ul id="menu_edit_action" class="ui-menu" >
                        <li onclick="if(confirm('Are you sure to Enable selected AD Group(s)?\nAll advertisement(s) in this AD Group will be enanled?')) updateADGroupStatus(<?php echo ADGroup::Status_Enabled;?>);">Enable</li>
                        <li onclick="if(confirm('Are you sure to Pause selected AD Group(s)?\nAll advertisement(s) in this AD Group will be paused?')) updateADGroupStatus(<?php echo ADGroup::Status_Paused;?>);">Pause</li>
                        <li onclick="if(confirm('Are you sure to Remove selected AD Group(s)?\nAll advertisement(s) in this AD Group will be removed?')) updateADGroupStatus(<?php echo ADGroup::Status_Removed;?>);">Remove</li>
                        <li class="ui-state-disabled"><hr /></li>
                        <li value="All_but_removed_Campaigns">Change Bid</li>
                        <li value="All_but_removed_Campaigns">Download Report</li>
                    </ul>
                    <input id="menu_segment_action_button" type="button" value="Segment ▼" disabled class="menuButton" onclick="showMenu('menu_segment_action');" style="width: 92px;" />
                    <ul id="menu_segment_action" class="ui-menu" >
                        <li value="All_Campaigns">None</li>
                        <li value="All_enabled_Campaigns">
                            Time
                            <ul>
                                <li>Day</li>
                                <li>Week</li>
                                <li>Month</li>
                                <li>Quarter</li>
                                <li>Year</li>
                            </ul>
                        </li>
                        <li value="All_but_removed_Campaigns">Click Type</li>
                        <li value="All_but_removed_Campaigns">Device</li>
                    </ul>
                </div>
            </div>
            <div>

            </div>
        </div>
    </div>
</div>

<div style="clear: both; width: 100%; position: relative; top: -20px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;">All AD Groups<?php echo isset($adCampaign) ? " in AD Campaign: ".$adCampaign->name : "";?></h1>
                </div>
            </div>
            <div>
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <thead>
                    <th align="left"><input id="groupAll" type="checkbox" /></th>
                    <th align="left">AD Group</th>
                    <th align="left">&nbsp;</th>
                    <th align="right">Default Max. CPC</th>
                    <th align="right">Clicks</th>
                    <th align="right">Impr.</th>
                    <th align="right">CTR</th>
                    <th align="right">Avg. CPC</th>
                    <th align="right">Cost</th>
                    <th align="right">Avg. POS</th>
                    </thead>
                    <tbody>
                    <?php $clickTotal = 0; $imprTotal = 0; $costTotal = 0;?>
                    <?php if(isset($adGroupPerformance) && !empty($adGroupPerformance)):?>
                    <?php foreach($adGroupPerformance as $adGroup):?>
                        <tr>
                            <td align="left"><input id="adGroupID[]" name="adGroupID[]" type="checkbox" value="<?php echo $adGroup['id'];?>" /><input id="group_<?php echo $adGroup['id'];?>_status" type="hidden" value="<?php echo $adGroup['status'];?>" /></th>
                            <td align="left"><a href="<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/adgroup/view", array('id'=>$adGroup['id']));?>"><?php echo $adGroup['name'];?></a></td>
                            <td align="right"><img id="group_<?php echo $adGroup['id'];?>_img" src="<?php echo ADGroup::getStatusImg($adGroup['status']);?>" border="0" /></td>
                            <td align="left"><?php echo sprintf("$%1\$.2f", $adGroup['default_bid']);?></td>
                            <td align="right"><?php echo $adGroup['clicks'];?></td>
                            <td align="right"><?php echo $adGroup['impr'];?></td>
                            <td align="right"><?php echo $adGroup['impr'] ? sprintf("%1\$.2f%%", $adGroup['clicks'] / $adGroup['impr'] * 100) : "&nbsp;";?></td>
                            <td align="right"><?php echo $adGroup['clicks'] ? sprintf("$%1\$.2f", $adGroup['cost'] / $adGroup['clicks']) : "&nbsp;";?></td>
                            <td align="right"><?php echo sprintf("$%1\$.2f", $adGroup['cost']);?></td>
                            <td align="right">&nbsp;</td>
                        </tr>
                        <?php $clickTotal += $adGroup['clicks']; $imprTotal += $adGroup['impr']; $costTotal += $adGroup['cost']; endforeach; ?>
                    <?php endif;?>
                    <tr>
                        <td align="left">&nbsp;</th>
                        <td align="left">&nbsp;</td>
                        <td align="left">&nbsp;</td>
                        <td align="right" class="boldFont">Total</td>
                        <td align="right" class="boldFont"><?php echo $clickTotal;?></td>
                        <td align="right" class="boldFont"><?php echo $imprTotal;?></td>
                        <td align="right" class="boldFont"><?php echo $imprTotal ? sprintf("%1\$.2f%%", $clickTotal / $imprTotal * 100) : "&nbsp;";?></td>
                        <td align="right" class="boldFont"><?php echo $clickTotal ? sprintf("$%1\$.2f", $costTotal / $clickTotal) : "&nbsp;";?></td>
                        <td align="right" class="boldFont"><?php echo sprintf("$%1\$.2f", $costTotal);?></td>
                        <td align="right" class="boldFont">&nbsp;</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $( "ul[id^='menu_']" ).menu();
        $( "ul[id^='menu_']" ).hide();

        $("#campaignList").change(function(){
            var href = "<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/adgroup/index/adcampaignid");?>";
            if($("#campaignList").val())
                window.location = href.substring(0, href.length - 5) + "/" + $("#campaignList").val() + href.substring(href.length - 5, href.length);
        });

        $("#groupAll").click(function(){
            if($("#groupAll").prop('checked'))
                $("input[id^='adGroupID']").prop('checked', true);
            else
                $("input[id^='adGroupID']").removeAttr('checked');
        });
    });

    $("#page").click(function(){
        $( "ul[id^='menu_']" ).hide();
    });

    function showMenu(id)
    {
        $( "ul[id^='menu_']" ).hide();
        var position = $("#"+id+"_button").position();
        $( "#"+id).css("left", position.left);
        $( "#"+id ).show();
        event.stopPropagation();
    }

    function updateADGroupStatus(statusCode) {
        if ($("input[id^='adGroupID']:checked").length <= 0) return false;

        var updateIDList = [];
        for (var i = 0; i < $("input[id^='adGroupID']:checked").length; i++) {
            if ($("#group_" + $($("input[id^='adGroupID']:checked")[i]).val() + "_status").val() != statusCode) {
                updateIDList.push($($("input[id^='adGroupID']:checked")[i]).val());
            }
        }
        if (updateIDList.length <= 0) return false;

        $("#ajaxloading").css("display", "block");

        $.ajax({
            type: "POST",
            url: '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/adgroup/updateGroupStatus");?>',
            data: {
                status:statusCode,
                idList: updateIDList
            },
            dataType: "JSON",
            success: function(data, status, xhr) {
                $("#ajaxloading").css("display", "none");
                if(data['status']=='success')
                {
                    for(var i=0;i<data['data'].length;i++)
                    {
                        $("#group_"+data['data'][i]+"_status").val(statusCode);
                        switch (statusCode)
                        {
                            case <?php echo ADCampaign::Status_Eligible;?>:
                                $("#group_"+data['data'][i]+"_img").prop('src', '/themes/facebook/images/enabled.png');
                                break;
                            case <?php echo ADCampaign::Status_Paused;?>:
                                $("#group_"+data['data'][i]+"_img").prop('src', '/themes/facebook/images/pause.gif');
                                break;
                            case <?php echo ADCampaign::Status_Removed;?>:
                                $("#group_"+data['data'][i]+"_img").prop('src', '/themes/facebook/images/removed.png');
                                break;
                        }
                    }
                }
                else
                {
                    alert("Update Status Failed!\n"+data['msg']+"\nPlease try again.");
                }
            },
            error: function(data, status, xhr) {
                $("#ajaxloading").css("display", "none");
                alert("Search Listing Failed!\nPlease try again.");
            }
        });
    }
</script>