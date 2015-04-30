<?php
/* @var $this HomeController */
/* @var $performance array */
/* @var $campaignPerformance array */
/* @var $adGroupPerformance array */

$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'menu_marketing'),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'display_advertisement')
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
                        <div class="sumDiv"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'clicks');?></div>
                        <div class="sumDiv sumDivBorderLeft"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'impressions');?></div>
                        <div class="sumDiv sumDivBorderLeft"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'click_through_rate');?></div>
                        <div class="sumDiv sumDivBorderLeft"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'average_cost_per_click');?></div>
                        <div class="sumDiv sumDivBorderLeft"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'cost');?></div>
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
                    <?php echo CHtml::dropDownList('adCampaignId', '', CHtml::listData(ADCampaign::model()->findAll("company_id=:company_id" ,array(':company_id' => Yii::app()->session['user']->company_id)), 'id', 'name'), array('empty'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'all_enabled_ad_campaign'), 'style'=>''));?>
                    <div style="display: inline-block; width: 10px; height: 10px; background-color: #058dc7; position: relative; left: 100px; z-index: 1;"></div>
                    <select id="dataPoint1" name="dataPoint1" style="width: 120px;">
                        <option value="clicks"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'clicks');?></option>
                        <option value="impr"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'impressions');?></option>
                        <option value="ctr"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'click_through_rate');?></option>
                        <option value="cpc"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'average_cost_per_click');?></option>
                        <option value="cost"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'cost');?></option>
                    </select>
                    <span>VS.</span>
                    <select id="dataPoint2" name="dataPoint2" style="width: 120px;">
                        <option value="none"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'none');?></option>
                        <option value="clicks"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'clicks');?></option>
                        <option value="impr"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'impressions');?></option>
                        <option value="ctr"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'click_through_rate');?></option>
                        <option value="cpc"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'average_cost_per_click');?></option>
                        <option value="cost"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'cost');?></option>
                    </select>
                    <div style="display: inline-block; width: 10px; height: 10px; background-color: #ed7e17; position: relative; left: -37px; z-index: 1;"></div>
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
                    <a style="color: #3b5998; line-height: 38px; position: relative; margin-right: 10px; padding-right: 5px;" href="<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/ADCampaign/index");?>"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'see_all');?></a>
                </div>
                <div style="height: 36px; color: #9197a3; font-weight: normal; width: 60%;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative; display: inline-block;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'all_enabled_ad_campaign');?></h1>
                    <input type="button" class="boldFont greenButton redButton" value="+ <?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign');?>" onclick=" window.location = '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/ADCampaign/create"); ?>'; " />
                </div>
            </div>
            <div>
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <thead>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'budget');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'status');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'clicks');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'impressions');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'click_through_rate');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'average_cost_per_click');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'cost');?></th>
                    </thead>
                    <tbody>
                    <?php $clickTotal = 0; $imprTotal = 0; $costTotal = 0; foreach($campaignPerformance as $campaign): ?>
                        <tr>
                            <td align="right"><a href="<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/ADCampaign/view", array('id'=>$campaign['id']));?>"><?php echo $campaign['name'];?></a></td>
                            <td align="right"><?php echo sprintf("$%1\$.2f", $campaign['budget']);?></td>
                            <td align="right"><?php echo ADCampaign::getStatusText($campaign['status']);?></td>
                            <td align="right"><?php echo $campaign['clicks'];?></td>
                            <td align="right"><?php echo $campaign['impr'];?></td>
                            <td align="right"><?php echo isset($campaign['impr']) ? sprintf("%1\$.2f%%", $campaign['clicks'] / $campaign['impr'] * 100) : "&nbsp;";?></td>
                            <td align="right"><?php echo isset($campaign['clicks']) ? sprintf("$%1\$.2f", $campaign['cost'] / $campaign['clicks']) : "&nbsp;";?></td>
                            <td align="right"><?php echo isset($campaign['cost']) ? sprintf("$%1\$.2f", $campaign['cost']) : "&nbsp;";?></td>
                            </tr>
                        <?php $clickTotal += $campaign['clicks']; $imprTotal += $campaign['impr']; $costTotal += $campaign['cost']; endforeach; ?>
                    <tr>
                        <td align="right" class="boldFont">&nbsp;</td>
                        <td align="right" class="boldFont"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'total');?></td>
                        <td align="right" class="boldFont">&nbsp;</td>
                        <td align="right" class="boldFont"><?php echo $clickTotal;?></td>
                        <td align="right" class="boldFont"><?php echo $imprTotal;?></td>
                        <td align="right" class="boldFont"><?php echo $imprTotal ? sprintf("%1\$.2f%%", $clickTotal / $imprTotal * 100) : "&nbsp;";?></td>
                        <td align="right" class="boldFont"><?php echo $clickTotal ? sprintf("$%1\$.2f", $costTotal / $clickTotal) : "&nbsp;";?></td>
                        <td align="right" class="boldFont"><?php echo sprintf("$%1\$.2f", $costTotal);?></td>
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
                    <a style="color: #3b5998; line-height: 38px; position: relative; margin-right: 10px; padding-right: 5px;" href="<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/ADGroup/index");?>"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'see_all');?></a>
                </div>
                <div style="height: 36px; color: #9197a3; font-weight: normal; width: 60%">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative; display: inline-block;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'all_enabled_ad_group');?></h1>
                    <input type="button" class="boldFont greenButton redButton" value="+ <?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_group');?>" onclick=" window.location='<?php $campaignid = (isset($adCampaign) ? array('campaignid'=>$adCampaign->id) : array()); echo Yii::app()->createAbsoluteUrl("marketing/advertisement/ADGroup/create", $campaignid); ?>';" />
                </div>
            </div>
            <div>
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <thead>
                    <th align="left"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_group');?></th>
                    <th align="left"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'status');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'default_max_cpc');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'clicks');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'impressions');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'click_through_rate');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'average_cost_per_click');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'cost');?></th>
                    </thead>
                    <tbody>
                    <?php $clickTotal = 0; $imprTotal = 0; $costTotal = 0;?>
                    <?php if(isset($adGroupPerformance) && !empty($adGroupPerformance)):?>
                        <?php foreach($adGroupPerformance as $adGroup):?>
                            <tr>
                                <td align="left"><a href="<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/ADGroup/view", array('id'=>$adGroup['id']));?>"><?php echo $adGroup['name'];?></a></td>
                                <td align="right"><?php echo ADGroup::getStatusText($adGroup['status']);?></td>
                                <td align="left"><?php echo sprintf("$%1\$.2f", $adGroup['default_bid']);?></td>
                                <td align="right"><?php echo $adGroup['clicks'];?></td>
                                <td align="right"><?php echo $adGroup['impr'];?></td>
                                <td align="right"><?php echo $adGroup['impr'] ? sprintf("%1\$.2f%%", $adGroup['clicks'] / $adGroup['impr'] * 100) : "&nbsp;";?></td>
                                <td align="right"><?php echo $adGroup['clicks'] ? sprintf("$%1\$.2f", $adGroup['cost'] / $adGroup['clicks']) : "&nbsp;";?></td>
                                <td align="right"><?php echo sprintf("$%1\$.2f", $adGroup['cost']);?></td>
                                </tr>
                            <?php $clickTotal += $adGroup['clicks']; $imprTotal += $adGroup['impr']; $costTotal += $adGroup['cost']; endforeach; ?>
                    <?php endif;?>
                    <tr>
                        <td align="left">&nbsp;</td>
                        <td align="left">&nbsp;</td>
                        <td align="right" class="boldFont"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'total');?></td>
                        <td align="right" class="boldFont"><?php echo $clickTotal;?></td>
                        <td align="right" class="boldFont"><?php echo $imprTotal;?></td>
                        <td align="right" class="boldFont"><?php echo $imprTotal ? sprintf("%1\$.2f%%", $clickTotal / $imprTotal * 100) : "&nbsp;";?></td>
                        <td align="right" class="boldFont"><?php echo $clickTotal ? sprintf("$%1\$.2f", $costTotal / $clickTotal) : "&nbsp;";?></td>
                        <td align="right" class="boldFont"><?php echo sprintf("$%1\$.2f", $costTotal);?></td>
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
        $("#dataPoint1").change(updatePerformanceChart);
        $("#dataPoint2").change(updatePerformanceChart);
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
                        dataPoint1Text = '<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'clicks');?>';
                        dataPoint1Prefix = '';
                        dataPoint1Suffix = '';
                        break;
                    case 'impr':
                        dataPoint1Format = '{value}';
                        dataPoint1Text = '<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'impressions');?>';
                        dataPoint1Prefix = '';
                        dataPoint1Suffix = '';
                        break;
                    case 'ctr':
                        dataPoint1Format = '{value}%';
                        dataPoint1Text = '<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'click_through_rate');?>';
                        dataPoint1Prefix = '';
                        dataPoint1Suffix = '%';
                        break;
                    case 'cpc':
                        dataPoint1Format = '${value}';
                        dataPoint1Text = '<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'average_cost_per_click');?>';
                        dataPoint1Prefix = '$';
                        dataPoint1Suffix = '';
                        break;
                    case 'cost':
                        dataPoint1Format = '${value}';
                        dataPoint1Text = '<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'cost');?>';
                        dataPoint1Prefix = '$';
                        dataPoint1Suffix = '';
                        break;
                }

                switch($("#dataPoint2").val())
                {
                    case 'clicks':
                        dataPoint2Format = '{value}';
                        dataPoint2Text = '<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'clicks');?>';
                        dataPoint2Prefix = '';
                        dataPoint2Suffix = '';
                        break;
                    case 'impr':
                        dataPoint2Format = '{value}';
                        dataPoint2Text = '<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'impressions');?>';
                        dataPoint2Prefix = '';
                        dataPoint2Suffix = '';
                        break;
                    case 'ctr':
                        dataPoint2Format = '{value}%';
                        dataPoint2Text = '<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'click_through_rate');?>';
                        dataPoint2Prefix = '';
                        dataPoint2Suffix = '%';
                        break;
                    case 'cpc':
                        dataPoint2Format = '${value}';
                        dataPoint2Text = '<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'average_cost_per_click');?>';
                        dataPoint2Prefix = '$';
                        dataPoint2Suffix = '';
                        break;
                    case 'cost':
                        dataPoint2Format = '${value}';
                        dataPoint2Text = '<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'cost');?>';
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
                alert("Faile to load performance data.\nPlease try again later.")
            }
        });
    }
</script>
