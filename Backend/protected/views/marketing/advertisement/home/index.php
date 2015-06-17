<?php
/* @var $this HomeController */
/* @var $company Company */

$this->breadcrumbs=array(
	'Home',
);
?>
<h1>Please input user name to search: </h1>

<div>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'adcampaign_form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
    )); ?>
    <input type="text" id="user" name="user" size="40" maxlength="40" />
    <?php echo CHtml::submitButton('Search'); ?>
    <?php $this->endWidget(); ?>
</div>

<style>
    .sumDiv{
        float: left; width: 19%; padding-left: 3px;
    }

    .sumDivBorderLeft{
        border-left: 1px solid #d2d3d6;
    }

    .sumDivFontBold{
        font-size: 14px; font-weight: bold;
    }

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
</style>

<?php if(!empty($company)): ?>
<script type="text/javascript" src="/js/highcharts/highcharts.js"></script>
<script type="text/javascript" src="/js/highcharts/themes/grid-light.js"></script>
<script type="text/javascript" src="/js/highcharts/modules/exporting.js"></script>
<script type="text/javascript" src="/js/moment/moment.min.js"></script>

<div class="clear" style="margin-top: 10px;">
    <hr />
    <div><h1><?php echo $company->name;?></h1></div>
    <div style="clear: both; width: 100%; position: relative; top: -5px;">
        <div class="borderBlock">
            <div>
                <div style="background: #fff; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                    <div style="height: 36px; color: #000; font-weight: normal;">
                        <div class="clearfix">
                            <div class="sumDiv">Clicks</div>
                            <div class="sumDiv sumDivBorderLeft">Impressions</div>
                            <div class="sumDiv sumDivBorderLeft">CTR %</div>
                            <div class="sumDiv sumDivBorderLeft">Avg. CPC</div>
                            <div class="sumDiv sumDivBorderLeft">Cost</div>
                        </div>
                        <div class="clearfix" id="performance_all">
                            <div class="sumDiv sumDivFontBold" id="clicks">&nbsp;</div>
                            <div class="sumDiv sumDivBorderLeft sumDivFontBold" id="impressions">&nbsp;</div>
                            <div class="sumDiv sumDivBorderLeft sumDivFontBold" id="ctr">&nbsp;</div>
                            <div class="sumDiv sumDivBorderLeft sumDivFontBold" id="cpc">&nbsp;</div>
                            <div class="sumDiv sumDivBorderLeft sumDivFontBold" id="cost">&nbsp;</div>
                        </div>
                    </div>
                </div>
                <div>
                </div>
            </div>
        </div>
    </div>

    <div style="clear: both; width: 100%; position: relative; top: 10px;">
        <div class="borderBlock">
            <div>
                <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; border-top: 1px solid #e9eaed; font-size: 12px; padding: 12px 12px 0px 12px;">
                    <div style="position: relative; float: right; top: -7px;">
                        <select id="performanceDateRange" name="performanceDateRange" style="height: 24px; position: relative; top: 7px; margin-right: 7px; display: block;">
                            <option value="custom">Custom</option>
                            <option value="this_week">This Week</option>
                            <option value="last_7_days">Last 7 Days</option>
                            <option value="last_week">Last Week</option>
                            <option value="last_14_days" selected>Last 14 days</option>
                            <option value="this_month">This Month</option>
                            <option value="last_30_days">Last 30 Days</option>
                            <option value="last_month">Last Month</option>
                        </select>
                        <div id="customPerformanceDateRange" style="position: relative; top: 7px; margin-right: 7px; display: none;">
                            <span>Custom&nbsp;</span>
                            <input id="cusFromDate" name="cusFromDate" type="text" size="8" readonly >
                            <span>&nbsp;-&nbsp;</span>
                            <input id="cusEndDate" name="cusEndDate" type="text" size="8" readonly >
                        </div>
                    </div>
                    <div style="height: 36px; color: #9197a3; font-weight: normal; width: 60%;">
                        <?php echo CHtml::dropDownList('adCampaignId', '', CHtml::listData(ADCampaign::model()->findAll("company_id=:company_id" ,array(':company_id' => $company->id)), 'id', 'name'), array('empty'=>'All enabled AD Campaigns', 'style'=>'height: 24px;'));?>
                        <div style="display: inline-block; width: 10px; height: 10px; background-color: #058dc7; position: relative; left: 100px; z-index: 1;"></div>
                        <select id="dataPoint1" name="dataPoint1" style="width: 120px; height: 24px;">
                            <option value="clicks">Clicks</option>
                            <option value="impr">Impressions</option>
                            <option value="ctr">CTR</option>
                            <option value="cpc">Avg. CPC</option>
                            <option value="cost">Cost</option>
                        </select>
                        <span>VS.</span>
                        <select id="dataPoint2" name="dataPoint2" style="width: 120px; height: 24px;">
                            <option value="none">None</option>
                            <option value="clicks">Clicks</option>
                            <option value="impr">Impressions</option>
                            <option value="ctr">CTR</option>
                            <option value="cpc">Avg. CPC</option>
                            <option value="cost">Cost</option>
                        </select>
                        <div style="display: inline-block; width: 10px; height: 10px; background-color: #ed7e17; position: relative; left: -37px; z-index: 1;"></div>
                    </div>
                </div>
                <div>
                    <div id="chartContainer" style="min-width:700px;height:400px; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>

    <div style="clear: both; width: 100%; position: relative; top: 10px;">
        <div class="borderBlock">
            <div>
                <div style="border-bottom: 1px solid #e9eaed; font-size: 12px;">
                    <div style="position: relative; float: right;">
                    </div>
                    <div style="height: 36px; color: #9197a3; font-weight: normal; width: 60%;">
                        <h1 style="color: #4e5665; font-weight: 700; line-height: 38px; position: relative; display: inline-block;">All enabled AD Campaigns</h1>
                    </div>
                </div>
                <div>
                    <table cellpadding="0" cellspacing="0" border="0" width="100%" id="campaign_performance">
                        <thead>
                        <th align="right">AD Campaign</th>
                        <th align="right">Status</th>
                        <th align="right">Budget</th>
                        <th align="right">Clicks</th>
                        <th align="right">Impressions</th>
                        <th align="right">CTR</th>
                        <th align="right">Avg. CPC</th>
                        <th align="right">Cost</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

    <script>
        $(function () {
            $("#dataPoint1").change(updatePerformanceChart);
            $("#dataPoint2").change(updatePerformanceChart);
            $("#adCampaignId").change(updatePerformanceChart);

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

            updatePerformanceStatistic();
        });

        function updatePerformanceStatistic(startDate, endDate)
        {
            $("#ajaxloading").css("display", "block");
            $.ajax({
                type: "POST",
                url: '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/home/getPerformanceStatistic");?>',
                data: {
                    company_id: <?php echo $company->id;?>,
                    start: startDate,
                    end: endDate
                },
                dataType: "JSON",
                success: function (data, status, xhr) {
                    $("#ajaxloading").css("display", "none");

                    if(data['status'] == 'success') {
                        updatePerformanceAll(data['all']);
                        updatePerformanceChartV2(data['chart']);
                        updatePerformanceADCampaign(data['adcampaign']);
                    }
                    else {
                        alert("Faile to load performance data.\nPlease try again later.");
                    }
                },
                error: function (data, status, xhr) {
                    $("#ajaxloading").css("display", "none");
                    alert("Faile to load performance data.\nPlease try again later.");
                }
            });
        }

        function updatePerformanceAll(all)
        {
            if(all['clicks']!=undefined)
                $("#performance_all div[id='clicks']").html(all['clicks']);
            else
                $("#performance_all div[id='clicks']").html('0');
            if(all['impr']!=undefined)
                $("#performance_all div[id='impressions']").html(all['impr']);
            else
                $("#performance_all div[id='impressions']").html('0');
            if(all['impr']!=undefined && all['impr']!=0)
                $("#performance_all div[id='ctr']").html((all['clicks']/all['impr']*100).toFixed(2)+'%');
            else
                $("#performance_all div[id='ctr']").html('&nbsp;');
            if(all['clicks']!=undefined && all['clicks']!=0)
                $("#performance_all div[id='cpc']").html('$'+(all['cost']/all['clicks']).toFixed(2));
            else
                $("#performance_all div[id='cpc']").html('&nbsp;');
            if(all['cost']!=undefined)
                $("#performance_all div[id='cost']").html('$'+parseFloat(all['cost']).toFixed(2));
            else
                $("#performance_all div[id='cost']").html('&nbsp;');
        }

        function getCampaignStatusImg(status)
        {
            switch(status)
            {
                case '<?php echo ADCampaign::Status_Eligible;?>':
                    return "/images/facebook/enabled.png";
                case '<?php echo ADCampaign::Status_Paused;?>':
                    return "/images/facebook/pause.gif";
                case '<?php echo ADCampaign::Status_Pending;?>':
                    return "/images/waiting.png";
                case '<?php echo ADCampaign::Status_Suspended;?>':
                    return "/images/facebook/pause.gif";
                case '<?php echo ADCampaign::Status_LimitedByBudget;?>':
                    return "/images/facebook/pause.gif";
                case '<?php echo ADCampaign::Status_Removed;?>':
                    return "/images/facebook/removed.png";
                case '<?php echo ADCampaign::Stauts_Ended;?>':
                    return "/images/facebook/disabled.png";
            }
        }

        function updatePerformanceADCampaign(data)
        {
            var totalClicks = 0;
            var totalImpr = 0;
            var totalCost = 0;
            var url = '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/adcampaign/view", array('id'=>'replace_id'));?>';

            $("#campaign_performance tr:gt(0)").remove();
            for(var i=0;i<data.length;i++)
            {
                var line = "<tr>"+
                    "<td align='right'><a target='_blank' href='"+url.replace('replace_id', data[i]['id'])+"'>"+data[i]['name']+"</a></td>"+
                    "<td align='center'><img id='campaign_"+data[i]['id']+"_img' src='"+getCampaignStatusImg(data[i]['status'])+"' border='0' "+(data[i]['status'] == '<?php echo ADCampaign::Status_Pending;?>' ? "style='width: 14px; position: relative; left: -3px;'" : '')+" /></td>"+
                    "<td align='right'>"+"$"+parseFloat(data[i]['budget']).toFixed(2)+"</td>"+
                    "<td align='right'>"+(parseInt(data[i]['clicks']) > 0 ? data[i]['clicks'] : 0)+"</td>"+
                    "<td align='right'>"+(parseInt(data[i]['impr']) > 0 ? data[i]['impr'] : 0)+"</td>"+
                    "<td align='right'>"+(parseInt(data[i]['impr']) > 0 ? (data[i]['clicks']/data[i]['impr']*100).toFixed(2)+'%' : '&nbsp')+"</td>"+
                    "<td align='right'>"+(parseInt(data[i]['clicks']) > 0 ? "$"+parseFloat(data[i]['cost']/data[i]['clicks']).toFixed(2) : '&nbsp;')+"</td>"+
                    "<td align='right'>"+(parseFloat(data[i]['cost']) > 0 ? "$"+parseFloat(data[i]['cost']).toFixed(2) : '&nbsp;')+"</td>"+
                    "</tr>";
                totalClicks += data[i]['clicks'] != null ? parseInt(data[i]['clicks']) : 0;
                totalImpr += data[i]['impr'] != null ? parseInt(data[i]['impr']) : 0;
                totalCost += data[i]['cost'] != null ? parseFloat(data[i]['cost']) : 0;
                $("#campaign_performance").append(line);
            }

            $("#campaign_performance").append("<tr>"+
            "<td align='left'>&nbsp;</th>"+
            "<td align='left'>&nbsp;</td>"+
            "<td align='right' class='boldFont' style='font-weight: bold;'>Total</td>"+
            "<td align='right' class='boldFont' style='font-weight: bold;'>"+totalClicks+"</td>"+
            "<td align='right' class='boldFont' style='font-weight: bold;'>"+totalImpr+"</td>"+
            "<td align='right' class='boldFont' style='font-weight: bold;'>"+(totalImpr > 0 ? (totalClicks/totalImpr*100).toFixed(2)+'%' : '&nbsp')+"</td>"+
            "<td align='right' class='boldFont' style='font-weight: bold;'>"+(totalClicks > 0 ? '$'+(totalCost/totalClicks).toFixed(2) : '&nbsp;')+"</td>"+
            "<td align='right' class='boldFont' style='font-weight: bold;'>"+(totalCost > 0 ? '$'+parseFloat(totalCost).toFixed(2) : '&nbsp;')+"</td>"+
            "</tr>");
        }

        function updatePerformanceChartV2(chart)
        {
            var chartCategories = [];
            var series = new Array;
            var dataPoint1Format = '';
            var dataPoint1Text = '';
            var dataPoint2Format = '';
            var dataPoint2Text = '';
            var dataPoint1Prefix = '';
            var dataPoint1Suffix = '';
            var dataPoint2Prefix = '';
            var dataPoint2Suffix = '';
            var dataPoint1Color = '#058dc7';
            var dataPoint2Color = '#ed7e17';

            series['clicks'] = new Array;
            series['impr'] = new Array;
            series['ctr'] = new Array;
            series['cpc'] = new Array;
            series['cost'] = new Array;
            for(var key in chart)
            {
                chartCategories.push(key);
                series['clicks'].push(parseInt(chart[key]['clicks']));
                series['impr'].push(parseInt(chart[key]['impr']));
                series['ctr'].push(parseFloat(chart[key]['ctr']));
                series['cpc'].push(parseFloat(chart[key]['cpc']));
                series['cost'].push(parseFloat(chart[key]['cost']));
            }

            switch($("#dataPoint1").val())
            {
                case 'clicks':
                    dataPoint1Format = '{value}';
                    dataPoint1Text = 'Clicks';
                    dataPoint1Prefix = '';
                    dataPoint1Suffix = '';
                    break;
                case 'impr':
                    dataPoint1Format = '{value}';
                    dataPoint1Text = 'Impressions';
                    dataPoint1Prefix = '';
                    dataPoint1Suffix = '';
                    break;
                case 'ctr':
                    dataPoint1Format = '{value}%';
                    dataPoint1Text = 'CTR';
                    dataPoint1Prefix = '';
                    dataPoint1Suffix = '%';
                    break;
                case 'cpc':
                    dataPoint1Format = '${value}';
                    dataPoint1Text = 'Avg. CPC';
                    dataPoint1Prefix = '$';
                    dataPoint1Suffix = '';
                    break;
                case 'cost':
                    dataPoint1Format = '${value}';
                    dataPoint1Text = 'Cost';
                    dataPoint1Prefix = '$';
                    dataPoint1Suffix = '';
                    break;
            }

            switch($("#dataPoint2").val())
            {
                case 'clicks':
                    dataPoint2Format = '{value}';
                    dataPoint2Text = 'Clicks';
                    dataPoint2Prefix = '';
                    dataPoint2Suffix = '';
                    break;
                case 'impr':
                    dataPoint2Format = '{value}';
                    dataPoint2Text = 'Impressions';
                    dataPoint2Prefix = '';
                    dataPoint2Suffix = '';
                    break;
                case 'ctr':
                    dataPoint2Format = '{value}%';
                    dataPoint2Text = 'CTR';
                    dataPoint2Prefix = '';
                    dataPoint2Suffix = '%';
                    break;
                case 'cpc':
                    dataPoint2Format = '${value}';
                    dataPoint2Text = 'Avg. CPC';
                    dataPoint2Prefix = '$';
                    dataPoint2Suffix = '';
                    break;
                case 'cost':
                    dataPoint2Format = '${value}';
                    dataPoint2Text = 'Cost';
                    dataPoint2Prefix = '$';
                    dataPoint2Suffix = '';
                    break;
            }

            if($("#dataPoint2").val() != 'none') {
                $('#chartContainer').highcharts({
                    title: {
                        text: '',
                        x: -20 //center
                    },
                    subtitle: {
                        text: '',
                        x: -20
                    },
                    xAxis: {
                        categories: chartCategories
                    },
                    yAxis: [{ // Primary yAxis
                        labels: {
                            format: dataPoint1Format,
                            style: {
                                color: dataPoint1Color
                            }
                        },
                        title: {
                            text: dataPoint1Text,
                            style: {
                                color: dataPoint1Color
                            }
                        }
                    }, { // Secondary yAxis
                        title: {
                            text: dataPoint2Text,
                            style: {
                                color: dataPoint2Color
                            }
                        },
                        labels: {
                            format: dataPoint2Format,
                            style: {
                                color: dataPoint2Color
                            }
                        },
                        opposite: true
                    }],
                    legend: {
                        layout: 'vertical',
                        align: 'left',
                        x: 60,
                        verticalAlign: 'top',
                        y: 60,
                        floating: true,
                        backgroundColor: '#FFFFFF'
                    },
                    series: [{
                        name: dataPoint1Text,
                        color: dataPoint1Color,
                        type: 'line',
                        yAxis: 0,
                        data: series[$("#dataPoint1").val()],
                        tooltip: {
                            valueSuffix: dataPoint1Suffix,
                            valuePrefix: dataPoint1Prefix
                        }

                    }, {
                        name: dataPoint2Text,
                        color: dataPoint2Color,
                        type: 'line',
                        yAxis: 1,
                        data: series[$("#dataPoint2").val()],
                        tooltip: {
                            valueSuffix: dataPoint2Suffix,
                            valuePrefix: dataPoint2Prefix
                        }
                    }]
                });
            }
            else {
                $('#chartContainer').highcharts({
                    title: {
                        text: '',
                        x: -20 //center
                    },
                    subtitle: {
                        text: '',
                        x: -20
                    },
                    xAxis: {
                        categories: chartCategories
                    },
                    yAxis: {
                        title: {
                            text: dataPoint1Text,
                            style: {
                                color: dataPoint1Color
                            }
                        },
                        plotLines: [{
                            value: 1,
                            width: 1,
                            color: dataPoint1Color
                        }]
                    },
                    tooltip: {
                        valuePrefix: dataPoint1Prefix,
                        valueSuffix: dataPoint1Suffix
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'left',
                        x: 60,
                        verticalAlign: 'top',
                        y: 60,
                        floating: true,
                        backgroundColor: '#FFFFFF'
                    },
                    series: [ {name: dataPoint1Text, color: dataPoint1Color, data: series[$("#dataPoint1").val()]} ]
                });
            }
        }

        function updatePerformanceChart()
        {
            var today = moment();
            var startDate;
            var endDate;
            switch ($("#performanceDateRange").val())
            {
                case 'custom':
                    startDate = $("#cusFromDate").val();
                    endDate = $("#cusEndDate").val();
                    break;
                case 'this_week':
                    startDate = moment().weekday(0).format("YYYY-MM-DD");
                    endDate = moment().format("YYYY-MM-DD");
                    break;
                case 'last_7_days':
                    startDate = moment().subtract(7, 'days').format("YYYY-MM-DD");
                    endDate = moment().format("YYYY-MM-DD");
                    break;
                case 'last_week':
                    startDate = moment().weekday(0).subtract(7,'days').format("YYYY-MM-DD");
                    endDate = moment().weekday(6).subtract(7,'days').format("YYYY-MM-DD");
                    break;
                case 'last_14_days':
                    startDate = moment().subtract(14, 'days').format("YYYY-MM-DD");
                    endDate = moment().format("YYYY-MM-DD");
                    break;
                case 'this_month':
                    startDate = moment().startOf("month").format("YYYY-MM-DD");
                    endDate = moment().format("YYYY-MM-DD");
                    break;
                case 'last_30_days':
                    startDate = moment().subtract(30, 'days').format("YYYY-MM-DD");
                    endDate = moment().format("YYYY-MM-DD");
                    break;
                case 'last_month':
                    startDate = moment().month(moment().month()-1).startOf("month").format("YYYY-MM-DD")
                    endDate = moment().month(moment().month()-1).endOf("month").format("YYYY-MM-DD");
                    break;
                default :
                    startDate = moment().subtract(14, 'days').format("YYYY-MM-DD");
                    endDate = moment().format("YYYY-MM-DD");
                    break;
            }

            if(startDate.length<=0 || endDate.length<=0)
            {
                startDate = moment().subtract(14, 'days').format("YYYY-MM-DD");
                endDate = moment().format("YYYY-MM-DD");
            }

            $("#ajaxloading").css("display", "block");
            $.ajax({
                type: "POST",
                url: '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/home/getPerformanceData");?>',
                data: {
                    start: startDate,
                    end: endDate,
                    company_id: <?php echo $company->id;?>,
                    adcampaignid: $("#adCampaignId").val()
                },
                dataType: "JSON",
                success: function (data, status, xhr) {
                    $("#ajaxloading").css("display", "none");
                    var chartCategories = [];
                    var series = new Array;
                    var dataPoint1Format = '';
                    var dataPoint1Text = '';
                    var dataPoint2Format = '';
                    var dataPoint2Text = '';
                    var dataPoint1Prefix = '';
                    var dataPoint1Suffix = '';
                    var dataPoint2Prefix = '';
                    var dataPoint2Suffix = '';
                    var dataPoint1Color = '#058dc7';
                    var dataPoint2Color = '#ed7e17';

                    series['clicks'] = new Array;
                    series['impr'] = new Array;
                    series['ctr'] = new Array;
                    series['cpc'] = new Array;
                    series['cost'] = new Array;
                    for(var key in data)
                    {
                        chartCategories.push(key);
                        series['clicks'].push(parseInt(data[key]['clicks']));
                        series['impr'].push(parseInt(data[key]['impr']));
                        series['ctr'].push(parseFloat(data[key]['ctr']));
                        series['cpc'].push(parseFloat(data[key]['cpc']));
                        series['cost'].push(parseFloat(data[key]['cost']));
                    }

                    switch($("#dataPoint1").val())
                    {
                        case 'clicks':
                            dataPoint1Format = '{value}';
                            dataPoint1Text = 'Clicks';
                            dataPoint1Prefix = '';
                            dataPoint1Suffix = '';
                            break;
                        case 'impr':
                            dataPoint1Format = '{value}';
                            dataPoint1Text = 'Impressions';
                            dataPoint1Prefix = '';
                            dataPoint1Suffix = '';
                            break;
                        case 'ctr':
                            dataPoint1Format = '{value}%';
                            dataPoint1Text = 'CTR';
                            dataPoint1Prefix = '';
                            dataPoint1Suffix = '%';
                            break;
                        case 'cpc':
                            dataPoint1Format = '${value}';
                            dataPoint1Text = 'Avg. CPC';
                            dataPoint1Prefix = '$';
                            dataPoint1Suffix = '';
                            break;
                        case 'cost':
                            dataPoint1Format = '${value}';
                            dataPoint1Text = 'Cost';
                            dataPoint1Prefix = '$';
                            dataPoint1Suffix = '';
                            break;
                    }

                    switch($("#dataPoint2").val())
                    {
                        case 'clicks':
                            dataPoint2Format = '{value}';
                            dataPoint2Text = 'Clicks';
                            dataPoint2Prefix = '';
                            dataPoint2Suffix = '';
                            break;
                        case 'impr':
                            dataPoint2Format = '{value}';
                            dataPoint2Text = 'Impressions';
                            dataPoint2Prefix = '';
                            dataPoint2Suffix = '';
                            break;
                        case 'ctr':
                            dataPoint2Format = '{value}%';
                            dataPoint2Text = 'CTR';
                            dataPoint2Prefix = '';
                            dataPoint2Suffix = '%';
                            break;
                        case 'cpc':
                            dataPoint2Format = '${value}';
                            dataPoint2Text = 'Avg. CPC';
                            dataPoint2Prefix = '$';
                            dataPoint2Suffix = '';
                            break;
                        case 'cost':
                            dataPoint2Format = '${value}';
                            dataPoint2Text = 'Cost';
                            dataPoint2Prefix = '$';
                            dataPoint2Suffix = '';
                            break;
                    }

                    if($("#dataPoint2").val() != 'none') {
                        $('#chartContainer').highcharts({
                            title: {
                                text: '',
                                x: -20 //center
                            },
                            subtitle: {
                                text: '',
                                x: -20
                            },
                            xAxis: {
                                categories: chartCategories
                            },
                            yAxis: [{ // Primary yAxis
                                labels: {
                                    format: dataPoint1Format,
                                    style: {
                                        color: dataPoint1Color
                                    }
                                },
                                title: {
                                    text: dataPoint1Text,
                                    style: {
                                        color: dataPoint1Color
                                    }
                                }
                            }, { // Secondary yAxis
                                title: {
                                    text: dataPoint2Text,
                                    style: {
                                        color: dataPoint2Color
                                    }
                                },
                                labels: {
                                    format: dataPoint2Format,
                                    style: {
                                        color: dataPoint2Color
                                    }
                                },
                                opposite: true
                            }],
                            legend: {
                                layout: 'vertical',
                                align: 'left',
                                x: 60,
                                verticalAlign: 'top',
                                y: 60,
                                floating: true,
                                backgroundColor: '#FFFFFF'
                            },
                            series: [{
                                name: dataPoint1Text,
                                color: dataPoint1Color,
                                type: 'line',
                                yAxis: 0,
                                data: series[$("#dataPoint1").val()],
                                tooltip: {
                                    valueSuffix: dataPoint1Suffix,
                                    valuePrefix: dataPoint1Prefix
                                }

                            }, {
                                name: dataPoint2Text,
                                color: dataPoint2Color,
                                type: 'line',
                                yAxis: 1,
                                data: series[$("#dataPoint2").val()],
                                tooltip: {
                                    valueSuffix: dataPoint2Suffix,
                                    valuePrefix: dataPoint2Prefix
                                }
                            }]
                        });
                    }
                    else {
                        $('#chartContainer').highcharts({
                            title: {
                                text: '',
                                x: -20 //center
                            },
                            subtitle: {
                                text: '',
                                x: -20
                            },
                            xAxis: {
                                categories: chartCategories
                            },
                            yAxis: {
                                title: {
                                    text: dataPoint1Text,
                                    style: {
                                        color: dataPoint1Color
                                    }
                                },
                                plotLines: [{
                                    value: 1,
                                    width: 1,
                                    color: dataPoint1Color
                                }]
                            },
                            tooltip: {
                                valuePrefix: dataPoint1Prefix,
                                valueSuffix: dataPoint1Suffix
                            },
                            legend: {
                                layout: 'vertical',
                                align: 'left',
                                x: 60,
                                verticalAlign: 'top',
                                y: 60,
                                floating: true,
                                backgroundColor: '#FFFFFF'
                            },
                            series: [ {name: dataPoint1Text, color: dataPoint1Color, data: series[$("#dataPoint1").val()]} ]
                        });
                    }
                },
                error: function (data, status, xhr) {
                    $("#ajaxloading").css("display", "none");
                    alert("Faile to load performance data.\nPlease try again later.")
                }
            });
        }
    </script>
<?php endif;?>