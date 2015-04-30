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
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'menu_marketing')=>array("/marketing/home"),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'display_advertisement')=>array("/marketing/advertisement/home"),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign')=>array('index'),
    $model->name,
);

$this->menu=array(
    array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign_index'), 'url'=>array('index')),
    array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign_create'), 'url'=>array('create')),
    array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign_update'), 'url'=>array('update', 'id'=>$model->id)),
    //array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign_remove'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('models/ADCampaign',ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'remove_ad_campaign')))),
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
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign_recently_performance');?></h1>
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
                    <div class="clearfix">
                        <div class="sumDiv sumDivFontBold"><?php echo $performance['clicks'];?></div>
                        <div class="sumDiv sumDivBorderLeft sumDivFontBold"><?php echo $performance['impr'];?></div>
                        <div class="sumDiv sumDivBorderLeft sumDivFontBold"><?php echo $performance['impr'] ? sprintf("%1\$.2f%%", $performance['clicks'] / $performance['impr'] * 100) : "&nbsp;";?></div>
                        <div class="sumDiv sumDivBorderLeft sumDivFontBold"><?php echo $performance['clicks'] ? sprintf("$%1\$.2f", $performance['cost'] / $performance['clicks']) : "&nbsp;";?></div>
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
                    <?php echo CHtml::dropDownList('adGroupId', '', CHtml::listData(ADGroup::model()->findAll("campaign_id=:campaign_id and company_id=:company_id" ,array(':campaign_id'=>$model->id, ':company_id' => Yii::app()->session['user']->company_id)), 'id', 'name'), array('empty'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'all_enabled_ad_group'), 'style'=>''));?>
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
<?php endif; ?>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign_detail');?><?php echo $model->name; ?></h1>
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
                        array(
                            'label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'name'),
                            'value'=>$model->name,
                        ),
                        array(
                            'name'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'status'),
                            'value'=>ADCampaign::getStatusText($model->status),
                        ),
                        array(
                            'label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'budget'),
                            'value'=>sprintf("$%1\$.2f", $model->budget)
                        ),
                        array(
                            'label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign_start_datetime'),
                            'value'=>date('Y-m-d', $model->start_datetime),
                        ),
                        array(
                            'label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign_end_datetime'),
                            'value'=>isset($model->end_datetime) ? date('Y-m-d', $model->start_datetime) : null,
                        ),
                        array(
                            'label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign_criteria'),
                            'value'=>$criteria,
                            'type'=>'html',
                        ),
                        array(
                            'label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign_timezone'),
                            'value'=>isset($setting['timezone']) ? $setting['timezone'] : "",
                        ),
                        array(
                            'label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign_schedule'),
                            'value'=>!empty($schedule) ? $schedule : 'All Time.',
                            'type'=>'html',
                        ),
                        array(
                            'label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'note'),
                            'value'=>$model->note,
                        )
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
                    <input type="button" class="boldFont greenButton redButton" value="+ <?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign');?>" onclick=" window.location = '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/ADCampaign/create"); ?>'; " />
                    <input type="button" class="boldFont greenButton redButton" value="+ <?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_group');?>" onclick=" window.location = '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/ADGroup/create", array('campaignid'=>$model->id)); ?>'; " />
                    <input id="menu_edit_action_button" type="button" value="<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'edit');?> ▼" class="menuButton" onclick="showMenu('menu_edit_action');" />
                    <ul id="menu_edit_action" class="ui-menu" >
                        <li onclick="if(confirm('Are you sure to Enable selected AD Group(s)?\nAll advertisement(s) in this AD Group will be enanled?')) updateADGroupStatus(<?php echo ADGroup::Status_Enabled;?>);"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'enable');?></li>
                        <li onclick="if(confirm('Are you sure to Pause selected AD Group(s)?\nAll advertisement(s) in this AD Group will be paused?')) updateADGroupStatus(<?php echo ADGroup::Status_Paused;?>);"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'pause');?></li>
                        <li onclick="if(confirm('Are you sure to Remove selected AD Group(s)?\nAll advertisement(s) in this AD Group will be removed?')) updateADGroupStatus(<?php echo ADGroup::Status_Removed;?>);"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'remove');?></li>
                        <li class="ui-state-disabled"><hr /></li>
                        <li value="All_but_removed_Campaigns" onclick=" window.location = '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/ADCampaign/update", array('id'=>$model->id)); ?>'; " ><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign_update');?></li>
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
                    <input id="menu_dimensions_action_button" type="button" value="<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'dimension_report');?> ▼" class="menuButton" onclick="showMenu('menu_dimensions_action');" style="width: 142px;" />
                    <ul id="menu_dimensions_action" class="ui-menu" >
                        <li onclick="window.location='<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/ADCampaign/automaticPlacementReport", array('id'=>$model->id));?>';"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'automatic_placement_report');?></li>
                        <li onclick="window.location='<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/ADCampaign/geoGraphicReport", array('id'=>$model->id));?>';"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'geo_graphic_report');?></li>
                        <li onclick="window.location='<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/ADCampaign/destinationURLReport", array('id'=>$model->id));?>';"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'destination_url_report');?></li>
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
                    <a style="color: #3b5998; line-height: 38px; position: relative; margin-right: 10px; padding-right: 5px;" href="<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/ADGroup/index", array('adcampaignid'=>$model->id));?>"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'see_all');?></a>
                </div>
                <div style="height: 36px; color: #9197a3; font-weight: normal; width: 60%;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_group');?></h1>
                </div>
            </div>
            <div style="display: block;">
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <thead>
                    <th align="left"><input id="groupAll" type="checkbox" /></th>
                    <th align="left"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_group');?></th>
                    <th align="left">&nbsp;</th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'default_max_cpc');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'clicks');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'impressions');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'click_through_rate');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'average_cost_per_click');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'cost');?></th>
                    </thead>
                    <tbody>
                    <?php $clickTotal = 0; $imprTotal = 0; $costTotal = 0; foreach($adGroupPerformance as $adGroup):?>
                        <tr>
                            <td align="left"><input id="adGroupID[]" name="adGroupID[]" type="checkbox" value="<?php echo $adGroup['id'];?>" /><input id="group_<?php echo $adGroup['id'];?>_status" type="hidden" value="<?php echo $adGroup['status'];?>" /></th>
                            <td align="left"><a href="<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/ADGroup/view", array('id'=>$adGroup['id']));?>"><?php echo $adGroup['name'];?></a></td>
                            <td align="right"><img id="group_<?php echo $adGroup['id'];?>_img" src="<?php echo ADGroup::getStatusImg($adGroup['status']);?>" border="0" /></td>
                            <td align="left"><?php echo sprintf("$%1\$.2f", $adGroup['default_bid']);?></td>
                            <td align="right"><?php echo isset($adGroup['clicks']) ? $adGroup['clicks'] : "&nbsp;";?></td>
                            <td align="right"><?php echo isset($adGroup['impr']) ? $adGroup['impr'] : "&nbsp;";?></td>
                            <td align="right"><?php echo isset($adGroup['impr']) && $adGroup['impr'] ? sprintf("%1\$.2f%%", $adGroup['clicks'] / $adGroup['impr'] * 100) : "&nbsp;";?></td>
                            <td align="right"><?php echo isset($adGroup['clicks']) && $adGroup['clicks'] ? sprintf("$%1\$.2f", $adGroup['cost'] / $adGroup['clicks']) : "&nbsp;";?></td>
                            <td align="right"><?php echo isset($adGroup['cost']) ? sprintf("$%1\$.2f", $adGroup['cost']) : "&nbsp;";?></td>
                        </tr>
                    <?php $clickTotal += $adGroup['clicks']; $imprTotal += $adGroup['impr']; $costTotal += $adGroup['cost']; endforeach; ?>
                    <tr>
                        <td align="left">&nbsp;</th>
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

        $("#dataPoint1").change(updatePerformanceChart);
        $("#dataPoint2").change(updatePerformanceChart);
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

    function updatePerformanceChart()
    {
        var adCampaignId = $("#adCampaignId").val();
        var dataPoint = $("#dataPoint").val();
        var groupBy = $("#groupBy").val();

        $.ajax({
            type: "POST",
            url: '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/ADCampaign/getPerformanceData");?>',
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

    function updateADGroupStatus(statusCode) {
        if ($("input[id^='adGroupID']:checked").length <= 0) return false;

        var updateIDList = [];
        for (var i = 0; i < $("input[id^='adGroupID']:checked").length; i++) {
            if ($("#group_" + $($("input[id^='adGroupID']:checked")[i]).val() + "_status").val() != statusCode) {
                updateIDList.push($($("input[id^='adGroupID']:checked")[i]).val());
            }
        }
        if (updateIDList.length <= 0) return false;

        $("#ajaxloading").css("display", "block");

        $.ajax({
            type: "POST",
            url: '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/ADGroup/updateGroupStatus");?>',
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