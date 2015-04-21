<?php
/* @var $this ADCampaignController */
/* @var $campaignPerformance array */

$this->breadcrumbs=array(
    'Marketing'=>array("/marketing/home"),
    'Advertisement'=>array("/marketing/advertisement/home"),
	'AD Campaign',
);

$this->menu=array(
    array('label'=>'Campaign Index', 'url'=>array('index')),
    array('label'=>'Campaign Create', 'url'=>array('create')),
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
                    <input type="button" class="boldFont greenButton redButton" value="+ Campaign" onclick=" window.location = '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/adcampaign/create"); ?>'; " />
                    <input id="menu_campaign_filter_button" type="button" value="All ▼" class="menuButton" onclick="showMenu('menu_campaign_filter');" />
                    <ul id="menu_campaign_filter" class="ui-menu" style="width: 180px;" >
                        <li value="All_Campaigns">All Campaigns</li>
                        <li value="All_enabled_Campaigns">All enabled Campaigns</li>
                        <li value="All_but_removed_Campaigns">All but removed Campaigns</li>
                    </ul>
                    <input id="menu_edit_action_button" type="button" value="Edit ▼" class="menuButton" onclick="showMenu('menu_edit_action');" />
                    <ul id="menu_edit_action" class="ui-menu" >
                        <li value="All_Campaigns">Enable</li>
                        <li value="All_enabled_Campaigns">Pause</li>
                        <li value="All_but_removed_Campaigns">Remove</li>
                        <li class="ui-state-disabled"><hr /></li>
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
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;">All Campaigns</h1>
                </div>
            </div>
            <div>
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <thead>
                        <th align="left"><input type="checkbox" /></th>
                        <th align="center"><img src="/themes/facebook/images/disabled.png" /></th>
                        <th align="right">Campaign</th>
                        <th align="right">Budget</th>
                        <th align="right">Status</th>
                        <th align="right">Clicks</th>
                        <th align="right">Impr.</th>
                        <th align="right">CTR</th>
                        <th align="right">Avg. CPC</th>
                        <th align="right">Cost</th>
                        <th align="right">Avg. POS</th>
                    </thead>
                    <tbody>
                    <?php $clickTotal = 0; $imprTotal = 0; $costTotal = 0; foreach($campaignPerformance as $campaign): ?>
                        <tr>
                            <td align="left"><input type="checkbox" value="<?php echo $campaign['id'];?>" /></td>
                            <td align="center"><img src="<?php echo ADGroup::getStatusImg($campaign['status']);?>" border="0" /></td>
                            <td align="right"><a href="<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/adcampaign/view", array('id'=>$campaign['id']));?>"><?php echo $campaign['name'];?></a></td>
                            <td align="right"><?php echo sprintf("$%1\$.2f", $campaign['budget']);?></td>
                            <td align="right"><?php echo ADCampaign::getStatusText($campaign['status']);?></td>
                            <td align="right"><?php echo $campaign['clicks'];?></td>
                            <td align="right"><?php echo $campaign['impr'];?></td>
                            <td align="right"><?php echo isset($campaign['impr']) ? sprintf("%1\$.2f%%", $campaign['clicks'] / $campaign['impr'] * 100) : "&nbsp;";?></td>
                            <td align="right"><?php echo isset($campaign['clicks']) ? sprintf("$%1\$.2f", $campaign['cost'] / $campaign['clicks']) : "&nbsp;";?></td>
                            <td align="right"><?php echo isset($campaign['cost']) ? sprintf("$%1\$.2f", $campaign['cost']) : "&nbsp;";?></td>
                            <td align="right">&nbsp;</td>
                        </tr>
                    <?php $clickTotal += $campaign['clicks']; $imprTotal += $campaign['impr']; $costTotal += $campaign['cost']; endforeach; ?>
                    <tr>
                        <td align="left">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                        <td align="right" class="boldFont">Total</td>
                        <td align="right">&nbsp;</td>
                        <td align="right">&nbsp;</td>
                        <td align="right" class="boldFont"><?php echo $clickTotal;?></td>
                        <td align="right" class="boldFont"><?php echo $imprTotal;?></td>
                        <td align="right" class="boldFont"><?php echo sprintf("%1\$.2f%%", $clickTotal / $imprTotal * 100);?></td>
                        <td align="right" class="boldFont"><?php echo sprintf("$%1\$.2f", $costTotal / $clickTotal);?></td>
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