<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/4/13
 * Time: 13:45
 */

/* @var $this ADCampaignController */
/* @var $model ADCampaign */
/* @var $performance array */
/* @var $adGroupPerformance array */

$this->breadcrumbs=array(
    'Marketing'=>array("/marketing/home"),
    'Advertisement'=>array("/marketing/advertisement/home"),
    'AD Campaign'=>array('index'),
    $model->name,
);

$this->menu=array(
    array('label'=>'Campaign Index', 'url'=>array('index')),
    array('label'=>'Campaign Create', 'url'=>array('create')),
    array('label'=>'Campaign Update', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Campaign Delete', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('models/ADCampaign','Are you sure you want to delete this Campaign?'))),
);
?>

<script type="text/javascript" src="/js/highcharts/highcharts.js"></script>
<script type="text/javascript" src="/js/highcharts/themes/grid-light.js"></script>
<script type="text/javascript" src="/js/highcharts/modules/exporting.js"></script>

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

<?php if(isset($performance['clicks']) && isset($performance['impr']) && isset($performance['cost'])):?>
<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #fff; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;">AD Campaign Performance</h1>
                </div>
            </div>
            <div>
                <div style="height: 36px; color: #000; font-weight: normal;">
                    <div class="clearfix">
                        <div class="sumDiv">Clicks</div>
                        <div class="sumDiv sumDivBorderLeft">Impr.</div>
                        <div class="sumDiv sumDivBorderLeft">CTR</div>
                        <div class="sumDiv sumDivBorderLeft">Avg. CPC</div>
                        <div class="sumDiv sumDivBorderLeft">Cost</div>
                    </div>
                    <div class="clearfix">
                        <div class="sumDiv sumDivFontBold"><?php echo $performance['clicks'];?></div>
                        <div class="sumDiv sumDivBorderLeft sumDivFontBold"><?php echo $performance['impr'];?></div>
                        <div class="sumDiv sumDivBorderLeft sumDivFontBold"><?php echo sprintf("%1\$.2f%%", $performance['clicks'] / $performance['impr'] * 100);?></div>
                        <div class="sumDiv sumDivBorderLeft sumDivFontBold"><?php echo sprintf("$%1\$.2f", $performance['cost'] / $performance['clicks']);?></div>
                        <div class="sumDiv sumDivBorderLeft sumDivFontBold"><?php echo sprintf("$%1\$.2f", $performance['cost']);?></div>
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
                    <?php echo CHtml::dropDownList('adGroupId', '', CHtml::listData(ADGroup::model()->findAll("campaign_id=:campaign_id and company_id=:company_id" ,array(':campaign_id'=>$model->id, ':company_id' => Yii::app()->session['user']->company_id)), 'id', 'name'), array('empty'=>'All AD Groups', 'style'=>''));?>
                    <select id="dataPoint" name="dataPoint" style="width: 100px;">
                        <option value="clicks">Clicks</option>
                        <option value="impr">Impression</option>
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
<?php endif; ?>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;">AD Campaign Detail: <?php echo $model->name; ?></h1>
                </div>
            </div>
            <div style="display: block;">
                <?php
                $criteria = "";
                $setting = (array)json_decode($model->criteria);
                if(isset($setting['language']))
                {
                    if(!empty($setting['language']))
                        $criteria .= "Language: ".$setting['language']."<br />";
                    else
                        $criteria .= "Language: All Languages."."<br />";
                }
                else
                {
                    $criteria .= "Language: All Languages."."<br />";
                }
                if(isset($setting['location']))
                {
                    if(!empty($setting['location']))
                        $criteria .= "Location: ".$setting['location']."<br />";
                    else
                        $criteria .= "Location: All Countries and Regions."."<br />";
                }
                else
                {
                    $criteria .= "Location: All Countries and Regions."."<br />";
                }
                $schedule = "";
                if(isset($setting['schedule']) && !empty($setting['schedule']))
                {
                    foreach($setting['schedule'] as $period)
                    {
                        $period = (array)$period;
                        $schedule .= $period['day'].' From: '.$period['from_hour'].':'.$period['from_minute'].' To: '.$period['to_hour'].':'.$period['to_minute']."<br />";
                    }
                }
                ?>
                <?php $this->widget('zii.widgets.CDetailView', array(
                    'data'=>$model,
                    'attributes'=>array(
                        'name',
                        array(
                            'name'=>'status',
                            'value'=>ADCampaign::getStatusText($model->status),
                        ),
                        array(
                            'label'=>'Budget',
                            'value'=>sprintf("$%1\$.2f", $model->budget)
                        ),
                        array(
                            'label'=>'Start Datetime',
                            'value'=>date('Y-m-d', $model->start_datetime),
                        ),
                        array(
                            'label'=>'End Datetime',
                            'value'=>isset($model->end_datetime) ? date('Y-m-d', $model->start_datetime) : null,
                        ),
                        array(
                            'label'=>"Criteria",
                            'value'=>$criteria,
                            'type'=>'html',
                        ),
                        array(
                            'label'=>'TimeZone',
                            'value'=>$setting['timezone'],
                        ),
                        array(
                            'label'=>'Schedule',
                            'value'=>!empty($schedule) ? $schedule : 'All Time.',
                            'type'=>'html',
                        ),
                        'note',
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
                    <input type="button" class="boldFont greenButton redButton" value="+ AD Campaign" onclick=" window.location = '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/adcampaign/create"); ?>'; " />
                    <input type="button" class="boldFont greenButton redButton" value="+ AD Group" onclick=" window.location = '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/adgroup/create", array('campaignid'=>$model->id)); ?>'; " />
                    <input id="menu_edit_action_button" type="button" value="Edit ▼" class="menuButton" onclick="showMenu('menu_edit_action');" />
                    <ul id="menu_edit_action" class="ui-menu" >
                        <li onclick="if(confirm('Are you sure to Enable selected AD Group(s)?\nAll advertisement(s) in this AD Group will be enanled?')) updateADGroupStatus(<?php echo ADGroup::Status_Enabled;?>);">Enable</li>
                        <li onclick="if(confirm('Are you sure to Pause selected AD Group(s)?\nAll advertisement(s) in this AD Group will be paused?')) updateADGroupStatus(<?php echo ADGroup::Status_Paused;?>);">Pause</li>
                        <li onclick="if(confirm('Are you sure to Remove selected AD Group(s)?\nAll advertisement(s) in this AD Group will be removed?')) updateADGroupStatus(<?php echo ADGroup::Status_Removed;?>);">Remove</li>
                        <li class="ui-state-disabled"><hr /></li>
                        <li value="All_but_removed_Campaigns" onclick=" window.location = '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/adcampaign/update", array('id'=>$model->id)); ?>'; " >Update Campaign</li>
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

<?php if(!empty($adGroupPerformance)):?>
<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="position: relative; float: right;">
                    <a style="color: #3b5998; font-size: 11px; line-height: 38px; position: relative; margin-right: 10px; padding-right: 5px;" href="<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/adgroup/index", array('adcampaignid'=>$model->id));?>">See All</a>
                </div>
                <div style="height: 36px; color: #9197a3; font-weight: normal; width: 60%;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;">AD Group(s)</h1>
                </div>
            </div>
            <div style="display: block;">
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
                    <?php $clickTotal = 0; $imprTotal = 0; $costTotal = 0; foreach($adGroupPerformance as $adGroup):?>
                        <tr>
                            <td align="left"><input id="adGroupID[]" name="adGroupID[]" type="checkbox" value="<?php echo $adGroup['id'];?>" /><input id="group_<?php echo $adGroup['id'];?>_status" type="hidden" value="<?php echo $adGroup['status'];?>" /></th>
                            <td align="left"><a href="<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/adgroup/view", array('id'=>$adGroup['id']));?>"><?php echo $adGroup['name'];?></a></td>
                            <td align="right"><img id="group_<?php echo $adGroup['id'];?>_img" src="<?php echo ADGroup::getStatusImg($adGroup['status']);?>" border="0" /></td>
                            <td align="left"><?php echo sprintf("$%1\$.2f", $adGroup['default_bid']);?></td>
                            <td align="right"><?php echo isset($adGroup['clicks']) ? $adGroup['clicks'] : "&nbsp;";?></td>
                            <td align="right"><?php echo isset($adGroup['impr']) ? $adGroup['impr'] : "&nbsp;";?></td>
                            <td align="right"><?php echo isset($adGroup['impr']) ? sprintf("%1\$.2f%%", $adGroup['clicks'] / $adGroup['impr'] * 100) : "&nbsp;";?></td>
                            <td align="right"><?php echo isset($adGroup['clicks']) ? sprintf("$%1\$.2f", $adGroup['cost'] / $adGroup['clicks']) : "&nbsp;";?></td>
                            <td align="right"><?php echo isset($adGroup['cost']) ? sprintf("$%1\$.2f", $adGroup['cost']) : "&nbsp;";?></td>
                            <td align="right">&nbsp;</td>
                        </tr>
                    <?php $clickTotal += $adGroup['clicks']; $imprTotal += $adGroup['impr']; $costTotal += $adGroup['cost']; endforeach; ?>
                    <tr>
                        <td align="left">&nbsp;</th>
                        <td align="left">&nbsp;</td>
                        <td align="left">&nbsp;</td>
                        <td align="right" class="boldFont">Total</td>
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
<?php endif;?>

<script>
    var chartCategories = [];
    var series = [];
    var dataName = $("#dataPoint").val();
    var prefix = '';
    var suffix = '';

    $(function() {
        $( "ul[id^='menu_']" ).menu();
        $( "ul[id^='menu_']" ).hide();

        $("#dataPoint").change(updatePerformanceChart);
        $("#groupBy").change(updatePerformanceChart);
        $("#adGroupId").change(updatePerformanceChart);

        updatePerformanceChart();

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

    function updatePerformanceChart() {
        var adGroupId = $("#adGroupId").val();
        var dataPoint = $("#dataPoint").val();
        var groupBy = $("#groupBy").val();

        $.ajax({
            type: "POST",
            url: '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/adcampaign/getPerformanceData");?>',
            data: {
                groupBy: groupBy,
                dataPoint: dataPoint,
                adgroupid: adGroupId
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

    function updateADGroupStatus(statusCode) {
        if ($("input[id^='adGroupID']:checked").length <= 0) return false;

        var updateIDList = [];
        for (var i = 0; i < $("input[id^='adGroupID']:checked").length; i++) {
            if ($("#group_" + $($("input[id^='adGroupID']:checked")[i]).val() + "_status").val() != statusCode) {
                updateIDList.push($($("input[id^='adGroupID']:checked")[i]).val());
            }
        }
        if (updateIDList.length <= 0) return false;

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