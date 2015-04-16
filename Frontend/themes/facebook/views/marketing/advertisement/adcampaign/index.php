<?php
/* @var $this ADCampaignController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    'Marketing'=>array("/marketing/home"),
    'Advertisement'=>array("/marketing/advertisement/home"),
	'AD Campaign',
);

$menu = array();
foreach($dataProvider->rawData as $data)
    $menu[] = array('label'=>'Campaign '.$data['name'], 'url'=>array('/marketing/advertisement/adcampaign/view/id/'.$data['id']));

$this->menu=$menu;/*array(
    array('label'=>'Test Campaign #1', 'url'=>array('/marketing/advertisement/adcampaign/view/id/1')),
    array('label'=>'Test Campaign #2', 'url'=>array('/marketing/advertisement/adcampaign/view/id/2')),
);*/
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
                        <li value="All_but_removed_Campaigns">Change Budget</li>
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
                        <th align="left"><img src="/themes/facebook/images/disabled.png" /></th>
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
                    <?php $this->widget('zii.widgets.CListView', array(
                        'dataProvider'=>$dataProvider,
                        'itemView'=>'_view',
                    )); ?>
                    <tr>
                        <td align="left">&nbsp;</td>
                        <td align="left">&nbsp;</td>
                        <td align="right" class="boldFont">Total</td>
                        <td align="right">&nbsp;</td>
                        <td align="right">&nbsp;</td>
                        <td align="right" class="boldFont">0</td>
                        <td align="right" class="boldFont">0</td>
                        <td align="right" class="boldFont">0%</td>
                        <td align="right" class="boldFont">$0.00</td>
                        <td align="right" class="boldFont">$0.00</td>
                        <td align="right" class="boldFont">0</td>
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