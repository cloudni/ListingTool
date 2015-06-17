<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/6/17
 * Time: 11:53
 */

/* @var $this ADCampaignController */
/* @var $model ADCampaign */
/* @var $geos array */

$this->breadcrumbs=array(
    'Geo graphic report'
);
?>

<script type="text/javascript" src="/js/moment/moment.min.js"></script>

<div>
    <h4 style="display: inline-block;">Please choose time segment: </h4>
    <select id="performanceDateRange" name="performanceDateRange" style="height: 24px; margin-right: 7px; display: inline-block;">
        <option value="custom">Custom</option>
        <option value="this_week">This Week</option>
        <option value="last_7_days" selected>Last 7 Days</option>
        <option value="last_week">Last Week</option>
        <option value="last_14_days">Last 14 days</option>
        <option value="this_month">This Month</option>
        <option value="last_30_days">Last 30 Days</option>
        <option value="last_month">Last Month</option>
    </select>
    <div id="customPerformanceDateRange" style="margin-right: 7px; display: none;">
        <input id="cusFromDate" name="cusFromDate" type="text" size="8" readonly style="height: 18px;" >
        <span>&nbsp;-&nbsp;</span>
        <input id="cusEndDate" name="cusEndDate" type="text" size="8" readonly style="height: 18px;">
    </div>
    <input type="button" value="Go" style="height: 24px;" id="goButton" />
</div>

<div style="clear: both; width: 100%;">
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <thead>
        <th align="left" style="padding-left: 12px; ">City</th>
        <th align="left">Region</th>
        <th align="left">Country</th>
        <th align="left">Location Type</th>
        <th align="right">Clicks</th>
        <th align="right">Impressions</th>
        <th align="right">CTR</th>
        <th align="right">Avg. CPC</th>
        <th align="right">Cost</th>
        </thead>
        <tbody>
        <?php if(!empty($geos)):?>
            <?php foreach($geos as $geo):?>
                <tr>
                    <td align="left" style="padding-left: 12px; "><?php echo (int)$geo["city_criteria_id"] ? GoogleAdWordsGeographicalTargeting::getByCriteriaId($geo["city_criteria_id"])->name : $geo["city_criteria_id"];?></td>
                    <td align="left"><?php echo (int)$geo["region_criteria_id"] ? GoogleAdWordsGeographicalTargeting::getByCriteriaId($geo["region_criteria_id"])->name : $geo["region_criteria_id"];?></td>
                    <td align="left"><?php echo (int)$geo["country_criteria_id"] ? GoogleAdWordsGeographicalTargeting::getByCriteriaId($geo["country_criteria_id"])->name : $geo["country_criteria_id"];?></td>
                    <td align="left"><?php echo $geo["location_type"];?></td>
                    <td align="right"><?php echo $geo["clicks"];?></td>
                    <td align="right"><?php echo $geo["impressions"];?></td>
                    <td align="right"><?php echo !empty($geo["impressions"]) && !empty($geo["clicks"]) ? sprintf("%1\$.2f", $geo["clicks"] / $geo["impressions"] * 100).'%' : "&nbsp;";?></td>
                    <td align="right"><?php echo !empty($geo["clicks"]) ? sprintf("$%1\$.2f", $geo["cost"] / $geo["clicks"]) : "&nbsp;" ;?></td>
                    <td align="right"><?php echo sprintf("$%1\$.2f", $geo["cost"]);?></td>
                </tr>
            <?php endforeach;?>
        <?php endif;?>
        </tbody>
    </table>
</div>

<script>
    $(function() {
        $("#cusFromDate").datepicker({
            dateFormat: "yy-mm-dd",
            maxDate:"-1D",
            onSelect:function(dateText){

            }
        });

        $("#cusEndDate").datepicker({
            dateFormat: "yy-mm-dd",
            maxDate:"today",
            onSelect:function(dateText){

            }
        });

        $("#performanceDateRange").change(function () {
            var today = moment();
            switch ($("#performanceDateRange").val()) {
                case 'custom':
                    $("#performanceDateRange").css('display', 'none');
                    $("#customPerformanceDateRange").css('display', 'inline-block');
                    return;
                    break;
                default :
                    break;
            }
        });

        $("#goButton").click(function(){
            var today = moment();
            var start = "";
            var end = "";
            switch ($("#performanceDateRange").val())
            {
                case 'custom':
                    if($("#cusFromDate").val().length> 0 && $("#cusEndDate").val().length> 0)
                        start = $("#cusFromDate").val(); end = $("#cusEndDate").val();
                    break;
                case 'this_week':
                    start = moment().weekday(0).format("YYYY-MM-DD"); end = moment().format("YYYY-MM-DD");
                    break;
                case 'last_7_days':
                    start = moment().subtract(7, 'days').format("YYYY-MM-DD"); end = moment().format("YYYY-MM-DD");
                    break;
                case 'last_week':
                    start = moment().weekday(0).subtract(7,'days').format("YYYY-MM-DD"); end = moment().weekday(6).subtract(7,'days').format("YYYY-MM-DD");
                    break;
                case 'last_14_days':
                    start = moment().subtract(14, 'days').format("YYYY-MM-DD"); end = moment().format("YYYY-MM-DD");
                    break;
                case 'this_month':
                    start = moment().startOf("month").format("YYYY-MM-DD"); end = moment().format("YYYY-MM-DD");
                    break;
                case 'last_30_days':
                    start = moment().subtract(30, 'days').format("YYYY-MM-DD"); end = moment().format("YYYY-MM-DD");
                    break;
                case 'last_month':
                    start = moment().month(moment().month()-1).startOf("month").format("YYYY-MM-DD"); end = moment().month(moment().month()-1).endOf("month").format("YYYY-MM-DD");
                    break;
                default :
                    start = moment().subtract(14, 'days').format("YYYY-MM-DD"); end = moment().format("YYYY-MM-DD");
                    break;
            }

            var URL  = "<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/ADCampaign/geoGraphicReport", array('id'=>$model->id, 'start'=>'starttime', 'end'=>'endtime'));?>";
            window.location = URL.replace('starttime', start).replace('endtime', end);
        });
    });
</script>