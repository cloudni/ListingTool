<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/4/18
 * Time: 21:05
 */

/* @var $this ADController */
/* @var $model ADAdvertise */

$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'menu_marketing')=>array("/marketing/home"),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'display_advertisement')=>array("/marketing/advertisement/home"),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign')=>array('/marketing/advertisement/ADCampaign/index'),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_group')=>array('/marketing/advertisement/adgroup'),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement')=> array('index'),
    $model->name,
);

$this->menu=array(
    array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_index'), 'url'=>array('index')),
    array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_create'), 'url'=>array('create')),
    array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_update'), 'url'=>array('update', 'id'=>$model->id)),
    //array('label'=>'AD Delete', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('models/ADAdvertisement','Are you sure you want to delete this Advertisement?'))),
);
?>

<script type="text/javascript" src="/js/highcharts/highcharts.js"></script>
<script type="text/javascript" src="/js/highcharts/themes/grid-light.js"></script>
<script type="text/javascript" src="/js/highcharts/modules/exporting.js"></script>
<script type="text/javascript" src="/js/moment/moment.min.js"></script>

<style>
    table.detail-view th, table.detail-view td
    {
        font-size: 12px;
    }

    .sumDiv{
        float: left; width: 19%; padding-left: 3px;
    }

    .sumDivBorderLeft{
        border-left: 1px solid #d2d3d6;
    }

    .sumDivFontBold{
        font-size: 14px; font-weight: bold;
    }

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
    <div class="borderBlock">
        <div>
            <div style="background: #fff; border-bottom: 1px solid #e9eaed; font-size: 12px;">
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
                <div style="height: 36px; color: #9197a3; font-weight: normal; width: 40%">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;"><?php echo sprintf(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_recently_performance'), $model->name);?></h1>
                </div>
            </div>
            <div>
                <div style="height: 36px; color: #000; font-weight: normal;">
                    <div class="clearfix">
                        <div class="sumDiv"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'clicks');?></div>
                        <div class="sumDiv sumDivBorderLeft"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'impressions');?></div>
                        <div class="sumDiv sumDivBorderLeft"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'click_through_rate');?></div>
                        <div class="sumDiv sumDivBorderLeft"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'average_cost_per_click');?></div>
                        <div class="sumDiv sumDivBorderLeft"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'cost');?></div>
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
        </div>
    </div>
</div>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px; padding: 12px 12px 0px 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <?php $variations = ADAdvertiseVariation::model()->findAll("ad_advertise_id=:ad_id and company_id=:company_id" ,array(':ad_id'=>$model->id, ':company_id' => Yii::app()->session['user']->company_id));
                    $variationList = array();
                    foreach($variations as $variation) $variationList[] = array('id'=>$variation->id, 'name'=>$variation->width.' x '.$variation->height.' ('.ADAdvertiseVariation::getCodeText($variation['code']).')');
                    echo CHtml::dropDownList('advariationId', '', CHtml::listData($variationList, 'id', 'name'), array('empty'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_all'), 'style'=>''));?>
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
                </div>
            </div>
            <div>
                <div id="chartContainer" style="min-width:700px;height:400px; width: 100%;"></div>
            </div>
        </div>
    </div>
</div>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement');?>: <?php echo $model->name; ?></h1>
                </div>
            </div>
            <div style="display: block;">
                <?php $this->widget('zii.widgets.CDetailView', array(
                    'data'=>$model,
                    'attributes'=>array(
                        array(
                            'label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'name'),
                            'value'=>$model->name,
                        ),
                        array(
                            'label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'note'),
                            'value'=>$model->note,
                        ),
                    ),
                )); ?>
            </div>
        </div>
    </div>
</div>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock" style="border: none;">
        <div>
            <div style="background: #e9eaed; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 26px; color: #9197a3; font-weight: normal;">
                    <input type="button" class="boldFont greenButton redButton" value="+ <?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement');?>" onclick=" window.location = '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/AD/create", array('adcampaignid'=>$model->adCampaign->id, 'adgroupid'=>$model->id)); ?>'; " />
                    <input id="menu_edit_action_button" type="button" value="<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'edit');?> ▼" class="menuButton" onclick="showMenu('menu_edit_action');" />
                    <?php if(!empty($adVariationPerformance)):?>
                    <ul id="menu_edit_action" class="ui-menu" >
                        <li onclick="if(confirm('Are you sure to Enable selected AD Variation(s)?')) updateADVariationStatus(<?php echo ADAdvertiseVariation::Status_Enabled;?>);"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'enable');?></li>
                        <li onclick="if(confirm('Are you sure to Pause selected AD Variation(s)?')) updateADVariationStatus(<?php echo ADAdvertiseVariation::Status_Paused;?>);"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'pause');?></li>
                        <li onclick="if(confirm('Are you sure to Remove selected AD Variation(s)?')) updateADVariationStatus(<?php echo ADAdvertiseVariation::Status_Removed;?>);"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'remove');?></li>
                        <li class="ui-state-disabled"><hr /></li>
                        <li value="All_but_removed_Campaigns" onclick=" window.location = '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/AD/update", array('id'=>$model->id)); ?>'; " >Update Advertisement</li>
                        <li value="All_but_removed_Campaigns"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'download_report');?></li>
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
                    <?php endif;?>
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
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px; clear: both; width: 100%;">
                <div style="height: 36px; color: #9197a3; font-weight: normal; width: 60%;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_variation');?></h1>
                </div>
            </div>
            <div style="display: block;">
                <table cellpadding="0" cellspacing="0" border="0" width="100%" id="ad_variation_performance">
                    <thead>
                    <th align="left"><input id="adVariationAll" type="checkbox" /></th>
                    <th align="left"><img src="/themes/facebook/images/disabled.png" border="0" /></th>
                    <th align="left"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement_variation');?></th>
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

        $("#dataPoint1").change(updatePerformanceChart);
        $("#dataPoint2").change(updatePerformanceChart);
        $("#groupBy").change(updatePerformanceChart);
        $("#advariationId").change(updatePerformanceChart);

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

        $("#adVariationAll").click(function(){
            if($("#adVariationAll").prop('checked'))
                $("input[id^='ad_variation_id']").prop('checked', true);
            else
                $("input[id^='ad_variation_id']").removeAttr('checked');
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
            url: '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/AD/getPerformanceStatistic");?>',
            data: {
                start: startDate,
                end: endDate,
                advertisementid: <?php echo $model->id;?>,
                advariationid: $("#advariationId").val()
            },
            dataType: "JSON",
            success: function (data, status, xhr) {
                $("#ajaxloading").css("display", "none");
                updatePerformanceAll(data['all']);
                updatePerformanceChartV2(data['chart']);
                updatePerformanceADVariation(data['advariation']);
            },
            error: function (data, status, xhr) {
                $("#ajaxloading").css("display", "none");
                alert("Faile to load performance data.\nPlease try again later.")
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
    }

    function updatePerformanceADVariation(data)
    {
        var totalClicks = 0;
        var totalImpr = 0;
        var totalCost = 0;
        var url = '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/AD/view", array('id'=>'replace_id'));?>';
        var codeName = {<?php echo ADAdvertiseVariation::Code_Flash;?>:"<?php echo ADAdvertiseVariation::getCodeText(ADAdvertiseVariation::Code_Flash);?>", <?php echo ADAdvertiseVariation::Code_Html5;?>:"<?php echo ADAdvertiseVariation::getCodeText(ADAdvertiseVariation::Code_Html5);?>"};

        $("#ad_variation_performance tr:gt(0)").remove();
        for(var i=0;i<data.length;i++)
        {
            var line = "<tr>"+
                "<td align='left'><input type='checkbox' id='ad_variation_id[]' name='ad_variation_id[]' value='"+ data[i]['id']+"' /><input id='variation_"+ data[i]['id']+"_status' type='hidden' value='"+ data[i]['status']+"' /></td>"+
                "<td align='left'><img id='variation_"+ data[i]['id']+"_img' src='"+getStatusImg(data[i]['status'])+"' border='0' /></td>"+
                "<td align='left'>"+ data[i]['width']+" x "+ data[i]['height']+"("+ codeName[data[i]['code']]+")</td>"+
                "<td align='right'>"+(parseInt(data[i]['clicks']) > 0 ? data[i]['clicks'] : 0)+"</td>"+
                "<td align='right'>"+(parseInt(data[i]['impr']) > 0 ? data[i]['impr'] : 0)+"</td>"+
                "<td align='right'>"+(parseInt(data[i]['impr']) > 0 ? (data[i]['clicks']/data[i]['impr']*100).toFixed(2)+'%' : '&nbsp')+"</td>"+
                "<td align='right'>"+(parseInt(data[i]['clicks']) > 0 ? "$"+parseFloat(data[i]['clicks']/data[i]['cost']).toFixed(2) : '&nbsp;')+"</td>"+
                "<td align='right'>"+(parseFloat(data[i]['cost']) > 0 ? "$"+parseFloat(data[i]['cost']).toFixed(2) : '&nbsp;')+"</td>"+
                "</tr>";
            totalClicks += data[i]['clicks'] != null ? parseInt(data[i]['clicks']) : 0;
            totalImpr += data[i]['impr'] != null ? parseInt(data[i]['impr']) : 0;
            totalCost += data[i]['cost'] != null ? parseFloat(data[i]['cost']) : 0;
            $("#ad_variation_performance").append(line);
        }
        $("#ad_variation_performance").append("<tr>"+
        "<td align='left'>&nbsp;</td>"+
        "<td align='right' class='boldFont'><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'total');?></td>"+
        "<td align='left'>&nbsp;</td>"+
        "<td align='right' class='boldFont'>"+totalClicks+"</td>"+
        "<td align='right' class='boldFont'>"+totalImpr+"</td>"+
        "<td align='right' class='boldFont'>"+(totalImpr > 0 ? (totalClicks/totalImpr*100).toFixed(2)+'%' : '&nbsp')+"</td>"+
        "<td align='right' class='boldFont'>"+(totalClicks > 0 ? '$'+(totalCost/totalClicks).toFixed(2) : '&nbsp;')+"</td>"+
        "<td align='right' class='boldFont'>"+(totalCost > 0 ? '$'+parseFloat(totalCost).toFixed(2) : '&nbsp;')+"</td>"+
        "</tr>");
    }

    function getStatusImg(status)
    {
        switch(status)
        {
            case '<?php echo ADAdvertiseVariation::Status_Enabled;?>':
                return "/themes/facebook/images/enabled.png";
            case '<?php echo ADAdvertiseVariation::Status_Paused;?>':
                return "/themes/facebook/images/pause.gif";
            case '<?php echo ADAdvertiseVariation::Status_Removed;?>':
                return "/themes/facebook/images/removed.png";
            default:
                return "/themes/facebook/images/disabled.png";
                break;
        }
    }

    function showMenu(id)
    {
        $( "ul[id^='menu_']" ).hide();
        var position = $("#"+id+"_button").position();
        $( "#"+id).css("left", position.left);
        $( "#"+id ).show();
        event.stopPropagation();
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

        $.ajax({
            type: "POST",
            url: '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/AD/getPerformanceData");?>',
            data: {
                start: startDate,
                end: endDate,
                advertisementid: <?php echo $model->id;?>,
                advariationid: $("#advariationId").val()
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

    function updateADVariationStatus(statusCode) {
        if ($("input[id^='ad_variation_id']:checked").length <= 0) return false;

        var updateIDList = [];
        for (var i = 0; i < $("input[id^='ad_variation_id']:checked").length; i++) {
            if ($("#group_" + $($("input[id^='ad_variation_id']:checked")[i]).val() + "_status").val() != statusCode) {
                updateIDList.push($($("input[id^='ad_variation_id']:checked")[i]).val());
            }
        }
        if (updateIDList.length <= 0) return false;

        $("#ajaxloading").css("display", "block");

        $.ajax({
            type: "POST",
            url: '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/AD/updateVariationStatus");?>',
            data: {
                status: statusCode,
                idList: updateIDList
            },
            dataType: "JSON",
            success: function (data, status, xhr) {
                $("#ajaxloading").css("display", "none");
                if (data['status'] == 'success') {
                    for (var i = 0; i < data['data'].length; i++) {
                        $("#variation_" + data['data'][i] + "_status").val(statusCode);
                        switch (statusCode) {
                            case <?php echo ADCampaign::Status_Eligible;?>:
                                $("#variation_" + data['data'][i] + "_img").prop('src', '/themes/facebook/images/enabled.png');
                                break;
                            case <?php echo ADCampaign::Status_Paused;?>:
                                $("#variation_" + data['data'][i] + "_img").prop('src', '/themes/facebook/images/pause.gif');
                                break;
                            case <?php echo ADCampaign::Status_Removed;?>:
                                $("#variation_" + data['data'][i] + "_img").prop('src', '/themes/facebook/images/removed.png');
                                break;
                        }
                    }
                }
                else {
                    alert("Update Status Failed!\n" + data['msg'] + "\nPlease try again.");
                }
            },
            error: function (data, status, xhr) {
                $("#ajaxloading").css("display", "none");
                alert("Search Listing Failed!\nPlease try again.");
            }
        });
    }
</script>