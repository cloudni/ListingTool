<?php
/* @var $this ADController */
/* @var $campaignList array */

$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'menu_marketing')=>array("/marketing/home"),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'display_advertisement')=>array("/marketing/advertisement/home"),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign')=>array('/marketing/advertisement/ADCampaign/index'),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_group')=>array('/marketing/advertisement/aDGroup/index'),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement')
);

$this->menu=array(
    array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_index'), 'url'=>array('index')),
    array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_create'), 'url'=>array('create')),
);
?>

<script type="text/javascript" src="/js/moment/moment.min.js"></script>

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
                    <input type="button" class="boldFont greenButton redButton" value="+ <?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement');?>" onclick=" window.location='<?php $campaignid = (isset($adCampaign) ? array('campaignid'=>$adCampaign->id) : array()); echo Yii::app()->createAbsoluteUrl("marketing/advertisement/ADGroup/create", $campaignid); ?>';" />
                    <?php echo CHtml::dropDownList('campaignList', (isset($adCampaign) ? $adCampaign->id : null), CHtml::listData($campaignList, 'id', 'name'), array('empty'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'dropdown_choose_campaign'), 'style'=>'height: 26px; width: 170px;'));?>
                    <select id="ad_group_list" name="ad_group_list" style="height: 26px; position: relative; top: 1px; width: 190px;">

                    </select>
                    <input id="menu_campaign_filter_button" type="button" value="All ▼" disabled class="menuButton" onclick="showMenu('menu_campaign_filter');" />
                    <ul id="menu_campaign_filter" class="ui-menu" style="width: 180px;" >
                        <li value="All_Campaigns">All Advertisements</li>
                        <li value="All_enabled_Campaigns">All enabled Advertisements</li>
                        <li value="All_but_removed_Campaigns">All but removed Advertisements</li>
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
                        <li class="ui-state-disabled"><hr /></li>
                        <li value="All_but_removed_Campaigns">Download Report</li>
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
                <div style="position: relative; float: right;">
                    <select id="performanceDateRange" name="performanceDateRange" style="position: relative; top: 7px; margin-right: 7px; display: block;">
                        <option value="custom"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'custom');?></option>
                        <option value="this_week"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'this_week');?></option>
                        <option value="last_7_days"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'last_7_days');?></option>
                        <option value="last_week"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'last_week');?></option>
                        <option value="last_14_days" selected><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'last_14_days');?></option>
                        <option value="this_month"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'this_month');?></option>
                        <option value="last_30_days"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'last_30_days');?></option>
                        <option value="last_month"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'last_month');?></option>
                    </select>
                    <div id="customPerformanceDateRange" style="position: relative; top: 7px; margin-right: 7px; display: none;">
                        <span><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'custom');?>&nbsp;</span>
                        <input id="cusFromDate" name="cusFromDate" type="text" size="8" readonly >
                        <span>&nbsp;-&nbsp;</span>
                        <input id="cusEndDate" name="cusEndDate" type="text" size="8" readonly >
                    </div>
                </div>
                <div style="height: 36px; color: #9197a3; font-weight: normal; width: 40%;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 12px; line-height: 38px; position: relative;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_all');?>&nbsp;&nbsp;<?php echo isset($adCampaign) ? sprintf(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_under_campaign'), $adCampaign->name) : "";?>&nbsp;&nbsp;<?php echo isset($adGroup) ? sprintf(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_under_ad_group'), $adGroup->name) : "";?></h1>
                </div>
            </div>
            <div>
                <table cellpadding="0" cellspacing="0" border="0" width="100%" id="ad_performance">
                    <thead>
                    <th align="left" style="padding-left: 12px; "><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'clicks');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'impressions');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'click_through_rate');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'average_cost_per_click');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'cost');?></th>
                    </thead>
                    <tbody>

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
            $("#ajaxloading").css("display", "block");
            $.ajax({
                type: "POST",
                url: '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/AD/getADGroupList");?>',
                data: {
                    adcampaignid: $("#campaignList").val()
                },
                dataType: "JSON",
                success: function (data, status, xhr) {
                    $("#ajaxloading").css("display", "none");
                    if(status == 'success')
                    {
                        $("#ad_group_list option").remove();
                        $("#ad_group_list").append("<option value=''><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'dropdown_choose_ad_group');?></option>");
                        $.each(data['data'],function(n,value){
                            $("#ad_group_list").append("<option value='"+n+"'>"+value+"</option>");
                        });
                        updatePerformanceStatistic();
                    }
                    else
                        alert("Faile to get AD Group List.\nPlease try again later.")
                },
                error: function (data, status, xhr) {
                    $("#ajaxloading").css("display", "none");
                    alert("Faile to get AD Group List.\nPlease try again later.")
                }
            });
        });

        $("#cusFromDate").datepicker({
            dateFormat: "yy-mm-dd",
            maxDate:"-1D",
            onSelect:function(dateText){
                if($("#cusFromDate").val().length> 0 && $("#cusEndDate").val().length> 0)
                    updatePerformanceStatistic($("#cusFromDate").val(), $("#cusEndDate").val());
            }
        });

        $("#cusEndDate").datepicker({
            dateFormat: "yy-mm-dd",
            maxDate:"today",
            onSelect:function(dateText){
                if($("#cusFromDate").val().length> 0 && $("#cusEndDate").val().length> 0)
                    updatePerformanceStatistic($("#cusFromDate").val(), $("#cusEndDate").val());
            }
        });

        $("#page").click(function(){
            $( "ul[id^='menu_']" ).hide();
        });

        $("#performanceDateRange").change(function(){
            var today = moment();
            switch ($("#performanceDateRange").val())
            {
                case 'custom':
                    $("#performanceDateRange").css('display', 'none');
                    $("#customPerformanceDateRange").css('display', 'block');
                    return;
                    break;
                case 'this_week':
                    updatePerformanceStatistic(moment().weekday(0).format("YYYY-MM-DD"), moment().format("YYYY-MM-DD"));
                    break;
                case 'last_7_days':
                    updatePerformanceStatistic(moment().subtract(7, 'days').format("YYYY-MM-DD"), moment().format("YYYY-MM-DD"));
                    break;
                case 'last_week':
                    updatePerformanceStatistic(moment().weekday(0).subtract(7,'days').format("YYYY-MM-DD"), moment().weekday(6).subtract(7,'days').format("YYYY-MM-DD"));
                    break;
                case 'last_14_days':
                    updatePerformanceStatistic(moment().subtract(14, 'days').format("YYYY-MM-DD"), moment().format("YYYY-MM-DD"));
                    break;
                case 'this_month':
                    updatePerformanceStatistic(moment().startOf("month").format("YYYY-MM-DD"), moment().format("YYYY-MM-DD"));
                    break;
                case 'last_30_days':
                    updatePerformanceStatistic(moment().subtract(30, 'days').format("YYYY-MM-DD"), moment().format("YYYY-MM-DD"));
                    break;
                case 'last_month':
                    updatePerformanceStatistic(moment().month(moment().month()-1).startOf("month").format("YYYY-MM-DD"), moment().month(moment().month()-1).endOf("month").format("YYYY-MM-DD"));
                    break;
                default :
                    updatePerformanceStatistic(moment().subtract(14, 'days').format("YYYY-MM-DD"), moment().format("YYYY-MM-DD"));
                    break;
            }
        });

        $("#ad_group_list").change(function(){
            $("#performanceDateRange").change();
        });

        $("#campaignList").change();
    });

    function updatePerformanceStatistic(startDate, endDate)
    {
        $("#ajaxloading").css("display", "block");
        $.ajax({
            type: "POST",
            url: '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/AD/getIndexPerformance");?>',
            data: {
                start: startDate,
                end: endDate,
                adcampaignid: $("#campaignList").val(),
                adgroupid: $("#ad_group_list").val()
            },
            dataType: "JSON",
            success: function (data, status, xhr) {
                $("#ajaxloading").css("display", "none");
                updatePerformanceAll(data['data']);
            },
            error: function (data, status, xhr) {
                $("#ajaxloading").css("display", "none");
                alert("Faile to load performance data.\nPlease try again later.")
            }
        });
    }

    function updatePerformanceAll(data)
    {
        var totalClicks = 0;
        var totalImpr = 0;
        var totalCost = 0;
        var url = '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/AD/view", array('id'=>'replace_id'));?>';

        $("#ad_performance tr:gt(0)").remove();
        for(var i=0;i<data.length;i++)
        {
            var line = "<tr>"+
                "<td align='right'><a href='"+url.replace('replace_id', data[i]['id'])+"'>"+data[i]['name']+"</a></td>"+
                "<td align='right'>"+(parseInt(data[i]['clicks']) > 0 ? data[i]['clicks'] : 0)+"</td>"+
                "<td align='right'>"+(parseInt(data[i]['impr']) > 0 ? data[i]['impr'] : 0)+"</td>"+
                "<td align='right'>"+(parseInt(data[i]['impr']) > 0 ? (data[i]['clicks']/data[i]['impr']*100).toFixed(2)+'%' : '&nbsp')+"</td>"+
                "<td align='right'>"+(parseInt(data[i]['clicks']) > 0 ? "$"+parseFloat(data[i]['cost']/data[i]['clicks']).toFixed(2) : '&nbsp;')+"</td>"+
                "<td align='right'>"+(parseFloat(data[i]['cost']) > 0 ? "$"+parseFloat(data[i]['cost']).toFixed(2) : '&nbsp;')+"</td>"+
                "</tr>";
            totalClicks += data[i]['clicks'] != null ? parseInt(data[i]['clicks']) : 0;
            totalImpr += data[i]['impr'] != null ? parseInt(data[i]['impr']) : 0;
            totalCost += data[i]['cost'] != null ? parseFloat(data[i]['cost']) : 0;
            $("#ad_performance").append(line);
        }

        $("#ad_performance").append("<tr>"+
        "<td align='right' class='boldFont'><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'total');?></td>"+
        "<td align='right' class='boldFont'>"+totalClicks+"</td>"+
        "<td align='right' class='boldFont'>"+totalImpr+"</td>"+
        "<td align='right' class='boldFont'>"+(totalImpr > 0 ? (totalClicks/totalImpr*100).toFixed(2)+'%' : '&nbsp')+"</td>"+
        "<td align='right' class='boldFont'>"+(totalClicks > 0 ? '$'+(totalCost/totalClicks).toFixed(2) : '&nbsp;')+"</td>"+
        "<td align='right' class='boldFont'>"+(totalCost > 0 ? '$'+parseFloat(totalCost).toFixed(2) : '&nbsp;')+"</td>"+
        "</tr>");
    }

    function showMenu(id)
    {
        $( "ul[id^='menu_']" ).hide();
        var position = $("#"+id+"_button").position();
        $( "#"+id).css("left", position.left);
        $( "#"+id ).show();
        event.stopPropagation();
    }
</script>