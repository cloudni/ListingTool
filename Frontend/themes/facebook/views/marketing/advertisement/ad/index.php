<?php
/* @var $this ADController */
/* @var $adCampaign ADCampaign */
/* @var $adGroup ADGroup */
/* @var $campaignList array */
/* @var $adPerformance array */

$this->breadcrumbs=array(
    'Marketing'=>array("/marketing/home"),
    'Advertisement'=>array("/marketing/advertisement/home"),
    'AD Campaign'=>array('/marketing/advertisement/adcampaign/index'),
    'AD Group'=>array('/marketing/advertisement/adgroup'),
    'Ad index'
);

$this->menu=array(
    array('label'=>'Advertisement Index', 'url'=>array('index')),
    array('label'=>'Advertisement Create', 'url'=>array('create')),
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
                    <input type="button" class="boldFont greenButton redButton" value="+ Advertisement" onclick=" window.location='<?php $campaignid = (isset($adCampaign) ? array('campaignid'=>$adCampaign->id) : array()); echo Yii::app()->createAbsoluteUrl("marketing/advertisement/adgroup/create", $campaignid); ?>';" />
                    <?php echo CHtml::dropDownList('campaignList', (isset($adCampaign) ? $adCampaign->id : null), CHtml::listData($campaignList, 'id', 'name'), array('empty'=>'Please select AD campaign to filter', 'style'=>'height: 26px; position: relative; top: 1px; width: 150px;'));?>
                    <input id="menu_campaign_filter_button" type="button" value="All ▼" class="menuButton" onclick="showMenu('menu_campaign_filter');" />
                    <ul id="menu_campaign_filter" class="ui-menu" style="width: 180px;" >
                        <li value="All_Campaigns">All Advertisements</li>
                        <li value="All_enabled_Campaigns">All enabled Advertisements</li>
                        <li value="All_but_removed_Campaigns">All but removed Advertisements</li>
                    </ul>
                    <input id="menu_edit_action_button" type="button" value="Edit ▼" class="menuButton" onclick="showMenu('menu_edit_action');" />
                    <ul id="menu_edit_action" class="ui-menu" >
                        <li value="All_but_removed_Campaigns">Update Advertisement</li>
                        <li value="All_but_removed_Campaigns">Download Report</li>
                    </ul>
                    <input id="menu_segment_action_button" type="button" value="Segment ▼" class="menuButton" onclick="showMenu('menu_segment_action');" style="width: 92px;" />
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
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;">All Advertisement(s)<?php echo isset($adCampaign) ? ", AD Campaign: ".$adCampaign->name : "";?><?php echo isset($adGroup) ? ", AD Group: ".$adGroup->name : "";?></h1>
                </div>
            </div>
            <div>
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <thead>
                    <th align="left"><input type="checkbox" /></th>
                    <th align="left">Advertisement</th>
                    <th align="right">Clicks</th>
                    <th align="right">Impr.</th>
                    <th align="right">CTR</th>
                    <th align="right">Avg. CPC</th>
                    <th align="right">Cost</th>
                    <th align="right">Avg. POS</th>
                    </thead>
                    <tbody>
                    <?php $clickTotal = 0; $imprTotal = 0; $costTotal = 0;?>
                    <?php if(isset($adPerformance) && !empty($adPerformance)):?>
                        <?php foreach($adPerformance as $ad):?>
                            <tr>
                                <td align="left"><input type="checkbox" value="<?php echo $ad['id'];?>" /></th>
                                <td align="left"><a href="<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/ad/view", array('id'=>$ad['id']));?>"><?php echo $ad['name'];?></a></td>
                                <td align="right"><?php echo $ad['clicks'];?></td>
                                <td align="right"><?php echo $ad['impr'];?></td>
                                <td align="right"><?php echo $ad['impr'] ? sprintf("%1\$.2f%%", $ad['clicks'] / $ad['impr'] * 100) : "&nbsp;";?></td>
                                <td align="right"><?php echo $ad['clicks'] ? sprintf("$%1\$.2f", $ad['cost'] / $ad['clicks']) : "&nbsp;";?></td>
                                <td align="right"><?php echo sprintf("$%1\$.2f", $ad['cost']);?></td>
                                <td align="right">&nbsp;</td>
                            </tr>
                            <?php $clickTotal += $ad['clicks']; $imprTotal += $ad['impr']; $costTotal += $ad['cost']; endforeach; ?>
                    <?php endif;?>
                    <tr>
                        <td align="left">&nbsp;</th>
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
            var href = "<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/ad/index/adcampaignid");?>";
            if($("#campaignList").val())
                window.location = href.substring(0, href.length - 5) + "/" + $("#campaignList").val() + href.substring(href.length - 5, href.length);
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
</script>