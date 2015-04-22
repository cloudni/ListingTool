<?php
/* @var $this HomeController */
/* @var $performance array */
/* @var $campaignPerformance array */
/* @var $adGroupPerformance array */

$this->breadcrumbs=array(
    'Marketing',
    'Advertisement'
);
?>

<script type="text/javascript" src="/js/highcharts/highcharts.js"></script>
<script type="text/javascript" src="/js/highcharts/themes/grid-light.js"></script>
<script type="text/javascript" src="/js/highcharts/modules/exporting.js"></script>

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

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #fff; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #000; font-weight: normal;">
                    <div class="clearfix">
                        <div class="sumDiv">Clicks</div>
                        <div class="sumDiv sumDivBorderLeft">Impr.</div>
                        <div class="sumDiv sumDivBorderLeft">CTR</div>
                        <div class="sumDiv sumDivBorderLeft">Avg. CPC</div>
                        <div class="sumDiv sumDivBorderLeft">Cost</div>
                    </div>
                    <div class="clearfix">
                        <div class="sumDiv sumDivFontBold"><?php echo isset($performance['clicks']) ? $performance['clicks'] : "&nbsp;";?></div>
                        <div class="sumDiv sumDivBorderLeft sumDivFontBold"><?php echo isset($performance['impr']) ? $performance['impr'] : "&nbsp";?></div>
                        <div class="sumDiv sumDivBorderLeft sumDivFontBold"><?php echo isset($performance['impr']) && $performance['impr'] ? sprintf("%1\$.2f%%", $performance['clicks'] / $performance['impr'] * 100) : "&nbsp";?></div>
                        <div class="sumDiv sumDivBorderLeft sumDivFontBold"><?php echo isset($performance['clicks']) && $performance['clicks'] ? sprintf("$%1\$.2f", $performance['cost'] / $performance['clicks']) : "&nbsp;";?></div>
                        <div class="sumDiv sumDivBorderLeft sumDivFontBold"><?php echo isset($performance['cost']) ? sprintf("$%1\$.2f", $performance['cost']) : "&nbsp;";?></div>
                    </div>
                </div>
            </div>
            <div>
            </div>
        </div>
    </div>
</div>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px; padding: 12px 12px 0px 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <?php echo CHtml::dropDownList('adCampaignId', '', CHtml::listData(ADCampaign::model()->findAll("company_id=:company_id" ,array(':company_id' => Yii::app()->session['user']->company_id)), 'id', 'name'), array('empty'=>'All AD Campaigns', 'style'=>''));?>
                    <select id="dataPoint" name="dataPoint" style="width: 100px;">
                        <option value="clicks">Clicks</option>
                        <option value="impr">Impr.</option>
                        <option value="ctr">CTR</option>
                        <option value="cpc">Avg. CPC</option>
                        <option value="cost">Cost</option>
                    </select>
                    <?php echo CHtml::dropDownList("groupBy", '', ADCampaign::getGroupByOptions(), array());?>
                </div>
            </div>
            <div>
                <div id="chartContainer" style="min-width:700px;height:400px; width: 100%;"></div>
            </div>
        </div>
    </div>
</div>

<div style="clear: both; width: 100%; position: relative; top: -12px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="position: relative; float: right;">
                    <a style="color: #3b5998; font-size: 11px; line-height: 38px; position: relative; margin-right: 10px; padding-right: 5px;" href="<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/adcampaign/index");?>">See All</a>
                </div>
                <div style="height: 36px; color: #9197a3; font-weight: normal; width: 60%;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative; display: inline-block;">All Enabled AD Campaigns</h1>
                    <input type="button" class="boldFont greenButton redButton" value="+ AD Campaign" onclick=" window.location = '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/adcampaign/create"); ?>'; " />
                </div>
            </div>
            <div>
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <thead>
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
                        <td align="right" class="boldFont">&nbsp;</td>
                        <td align="right" class="boldFont">Total</td>
                        <td align="right" class="boldFont">&nbsp;</td>
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

<div style="clear: both; width: 100%; position: relative; top: -20px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="position: relative; float: right;">
                    <a style="color: #3b5998; font-size: 11px; line-height: 38px; position: relative; margin-right: 10px; padding-right: 5px;" href="<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/adgroup/index");?>">See All</a>
                </div>
                <div style="height: 36px; color: #9197a3; font-weight: normal; width: 60%">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative; display: inline-block;">All Enabled AD Groups</h1>
                    <input type="button" class="boldFont greenButton redButton" value="+ AD Group" onclick=" window.location='<?php $campaignid = (isset($adCampaign) ? array('campaignid'=>$adCampaign->id) : array()); echo Yii::app()->createAbsoluteUrl("marketing/advertisement/adgroup/create", $campaignid); ?>';" />
                </div>
            </div>
            <div>
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <thead>
                    <th align="left">AD Group</th>
                    <th align="left">Status</th>
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
                                <td align="left"><a href="<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/adgroup/view", array('id'=>$adGroup['id']));?>"><?php echo $adGroup['name'];?></a></td>
                                <td align="right"><?php echo ADGroup::getStatusText($adGroup['status']);?></td>
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

    var chartCategories = [];
    var series = [];
    var dataName = $("#dataPoint").val();
    var prefix = '';
    var suffix = '';

    $(function () {
        $("#dataPoint").change(updatePerformanceChart);
        $("#groupBy").change(updatePerformanceChart);
        $("#adCampaignId").change(updatePerformanceChart);

        updatePerformanceChart();
    });

    function updatePerformanceChart()
    {
        var adCampaignId = $("#adCampaignId").val();
        var dataPoint = $("#dataPoint").val();
        var groupBy = $("#groupBy").val();

        $.ajax({
            type: "POST",
            url: '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/home/getPerformanceData");?>',
            data: {
                groupBy: groupBy,
                dataPoint: dataPoint,
                adcampaignid: adCampaignId
            },
            dataType: "JSON",
            success: function (data, status, xhr) {
                var chartCategories = [];
                var series = [];
                var dataName = $("#dataPoint").val();
                var prefix = '';
                var suffix = '';

                switch(dataName)
                {
                    case 'clicks':
                        break;
                    case 'impr':
                        break;
                    case 'ctr':
                        suffix = '%';
                        break;
                    case 'cpc':
                        prefix = '$';
                        break;
                    case 'cost':
                        prefix = '$';
                        break;
                }

                for(var key in data)
                {
                    chartCategories.push(key);

                    switch(dataName)
                    {
                        case 'clicks':
                            series.push(parseInt(data[key][dataName]));
                            break;
                        case 'impr':
                            series.push(parseInt(data[key][dataName]));
                            break;
                        case 'ctr':
                            suffix = '%';
                            series.push(parseFloat(data[key][dataName]));
                            break;
                        case 'cpc':
                            prefix = '$';
                            series.push(parseFloat(data[key][dataName]));
                            break;
                        case 'cost':
                            prefix = '$';
                            series.push(parseFloat(data[key][dataName]));
                            break;
                    }
                }

                $('#chartContainer').highcharts({
                    title: {
                        text: 'Advertisement Overall Performance for ' + dataName,
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
                            text: ''
                        },
                        plotLines: [{
                            value: 1,
                            width: 1,
                            color: '#808080'
                        }]
                    },
                    tooltip: {
                        valuePrefix: prefix,
                        valueSuffix: suffix
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle',
                        borderWidth: 0
                    },
                    series: [ {name: dataName, data: series} ]
                });
            },
            error: function (data, status, xhr) {
                alert("Faile to load performance data.\nPlease try again later.")
            }
        });
    }
</script>
