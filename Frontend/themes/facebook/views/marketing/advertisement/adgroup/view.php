<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/4/15
 * Time: 23:55
 */

/* @var $this ADGroupController */
/* @var $model ADGroup */
/* @var $performance array */
/* @var $adPerformance array */

$this->breadcrumbs=array(
    'Marketing'=>array("/marketing/home"),
    'Advertisement'=>array("/marketing/advertisement/home"),
    'AD Campaign'=>array('/marketing/advertisement/adcampaign'),
    'AD Group'=>array('index'),
    $model->name,
);

$this->menu=array(
    array('label'=>'AD Group Index', 'url'=>array('index')),
    array('label'=>'AD Group Create', 'url'=>array('create')),
    array('label'=>'AD Group Update', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'AD Group Delete', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('models/ADGroup','Are you sure you want to delete this AD Group?'))),
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
                        <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;">AD Group <?php echo $model->name;?> Performance</h1>
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
                        <?php echo CHtml::dropDownList('advertisementId', '', CHtml::listData(ADAdvertise::model()->findAll("ad_group_id=:group_id and company_id=:company_id" ,array(':group_id'=>$model->id, ':company_id' => Yii::app()->session['user']->company_id)), 'id', 'name'), array('empty'=>'All Advertisements', 'style'=>''));?>
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
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;">AD Group: <?php echo $model->name; ?></h1>
                </div>
            </div>
            <div style="display: block;">
                <?php
                $criteria = "";
                $setting = (array)json_decode($model->criteria);
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
                            'label'=>'Default Bid',
                            'value'=>sprintf("$%1\$.2f", $model->default_bid)
                        ),
                        array(
                            'label'=>"Keywords",
                            'value'=>($setting['keywords'] ? str_replace(ADGroup::Criteria_Separator, "<br />", $setting['keywords']) : ""),
                            'type'=>'html',
                        ),
                        array(
                            'label'=>"Placements",
                            'value'=>($setting['placements'] ? str_replace(ADGroup::Criteria_Separator, "<br />", $setting['placements']) : ""),
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
                    <input type="button" class="boldFont greenButton redButton" value="+ AD Group" onclick=" window.location = '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/adgroup/create", array('campaignid'=>$model->adCampaign->id)); ?>'; " />
                    <input type="button" class="boldFont greenButton redButton" value="+ Advertisement" onclick=" window.location = '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/ad/create", array('adcampaignid'=>$model->adCampaign->id, 'adgroupid'=>$model->id)); ?>'; " />
                    <?php if(!empty($adPerformance)):?>
                    <input id="menu_edit_action_button" type="button" value="Edit ▼" class="menuButton" onclick="showMenu('menu_edit_action');" />
                    <ul id="menu_edit_action" class="ui-menu" >
                        <li value="All_Campaigns">Enable</li>
                        <li value="All_enabled_Campaigns">Pause</li>
                        <li value="All_but_removed_Campaigns">Remove</li>
                        <li class="ui-state-disabled"><hr /></li>
                        <li value="All_but_removed_Campaigns" onclick=" window.location = '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/adgroup/update", array('id'=>$model->id)); ?>'; " >Update AD Group</li>
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
                    <?php endif;?>
                </div>
            </div>
            <div>

            </div>
        </div>
    </div>
</div>

<?php if(!empty($adPerformance)):?>
    <div style="clear: both; width: 100%; position: relative; top: -5px;">
        <div class="borderBlock">
            <div>
                <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px; clear: both; width: 100%;">
                    <div style="position: relative; float: right;">
                        <a style="color: #3b5998; font-size: 11px; line-height: 38px; position: relative; margin-right: 10px; padding-right: 5px;" href="<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/ad/index", array('adcampaignid'=>$model->adCampaign->id, 'adgroupid'=>$model->id));?>">See All</a>
                    </div>
                    <div style="height: 36px; color: #9197a3; font-weight: normal; width: 60%;">
                        <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;">Advertisement(s)</h1>
                    </div>
                </div>
                <div style="display: block;">
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
                        <?php $clickTotal = 0; $imprTotal = 0; $costTotal = 0; foreach($adPerformance as $ad):?>
                            <tr>
                                <td align="left"><input type="checkbox" value="<?php echo $ad['id'];?>" /></th>
                                <td align="left"><a href="<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/ad/view", array('id'=>$ad['id']));?>"><?php echo $ad['name'];?></a></td>
                                <td align="right"><?php echo isset($ad['clicks']) ? $ad['clicks'] : "&nbsp;";?></td>
                                <td align="right"><?php echo isset($ad['impr']) ? $ad['impr'] : "&nbsp;";?></td>
                                <td align="right"><?php echo isset($ad['impr']) ? sprintf("%1\$.2f%%", $ad['clicks'] / $ad['impr'] * 100) : "&nbsp;";?></td>
                                <td align="right"><?php echo isset($ad['clicks']) ? sprintf("$%1\$.2f", $ad['cost'] / $ad['clicks']) : "&nbsp;";?></td>
                                <td align="right"><?php echo isset($ad['cost']) ? sprintf("$%1\$.2f", $ad['cost']) : "&nbsp;";?></td>
                                <td align="right">&nbsp;</td>
                            </tr>
                            <?php $clickTotal += $ad['clicks']; $imprTotal += $ad['impr']; $costTotal += $ad['cost']; endforeach; ?>
                        <tr>
                            <td align="left">&nbsp;</th>
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
        $("#advertisementId").change(updatePerformanceChart);

        updatePerformanceChart();
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
        var advertisementId = $("#advertisementId").val();
        var dataPoint = $("#dataPoint").val();
        var groupBy = $("#groupBy").val();

        $.ajax({
            type: "POST",
            url: '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/adgroup/getPerformanceData");?>',
            data: {
                groupBy: groupBy,
                dataPoint: dataPoint,
                advertisementId: advertisementId
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