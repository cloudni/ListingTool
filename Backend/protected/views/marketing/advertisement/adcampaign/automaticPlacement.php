<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/6/16
 * Time: 22:03
 */

/* @var $this ADCampaignController */
/* @var $model ADCampaign */
/* @var $placements array */

$this->breadcrumbs=array(
    'Automatic placement report'
);
?>

<script type="text/javascript" src="/js/moment/moment.min.js"></script>

<div>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'ad_form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
    'htmlOptions'=>array(
    ),
));
?>
<select id="performanceDateRange" name="performanceDateRange" style="position: relative; top: 7px; margin-right: 7px; display: block;">
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
    <span>&nbsp;&nbsp;</span>
    <input type="submit" value="Go" />
</div>
<?php $this->endWidget(); ?>
</div>

<div style="clear: both; width: 100%; position: relative; top: 15px;">
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <thead>
        <th align="left">&nbsp;</th>
        <th align="left" style="padding-left: 12px; ">Automatic placement</th>
        <th align="left">URL</th>
        <th align="right">Clicks</th>
        <th align="right">Impressions</th>
        <th align="right">CTR</th>
        <th align="right">Avg. CPC</th>
        <th align="right">Cost</th>
        </thead>
        <tbody>
        <?php $totalClicks = $totalImpr = $totalCost = 0;?>
        <?php if(isset($placements) && !empty($placements)):?>
            <?php foreach($placements as $placement):?>
                <tr>
                    <td><img domain="<?php echo $placement['domain'];?>" action="<?php echo $placement["campaign_exclude_id"] ?  "include" : "exclude";?>" src="<?php echo $placement["campaign_exclude_id"] ?  "/images/addicon.gif" : "/images/delicon.gif";?>" onclick="updateDomainSetting('<?php echo $placement['domain'];?>', this);" /></td>
                    <td align="left" style="padding-left: 12px; " width="20%"><a href="//<?php echo $placement['display_name'];?>" title="<?php echo $placement['display_name'];?>" target="_blank"><?php echo strlen($placement['display_name']) > 50 ? substr($placement['display_name'], 0, 50).'...' : $placement['display_name'];?></a></td>
                    <td align="left"><span title="<?php echo $placement['domain'];?>"><?php echo substr($placement['domain'], 0, 30).'...';?></span></td>
                    <td align="right"><?php echo $placement['clicks'];?></td>
                    <td align="right"><?php echo $placement['impr'];?></td>
                    <td align="right"><?php echo $placement['impr'] ? sprintf("%1\$.2f%%", $placement['clicks'] / $placement['impr'] * 100) : "&nbsp;";?></td>
                    <td align="right"><?php echo $placement['clicks'] ? sprintf("$%1\$.2f", $placement['cost'] / $placement['clicks']) : "&nbsp;";?></td>
                    <td align="right"><?php echo $placement['cost'] ? sprintf("$%1\$.2f", $placement['cost']) : "&nbsp";?></td>
                </tr>
                <?php $totalClicks += $placement['clicks']; $totalImpr += $placement['impr']; $totalCost += $placement['cost'];?>
            <?php endforeach; ?>
        <?php endif;?>
        <tr>
            <td>&nbsp;</td>
            <td align="left" style="padding-left: 12px; font-weight: bold; " width="20%">Total</td>
            <td align="left"></td>
            <td align="right" style="font-weight: bold; "><?php echo $totalClicks;?></td>
            <td align="right" style="font-weight: bold; "><?php echo $totalImpr;?></td>
            <td align="right" style="font-weight: bold; "><?php echo $totalImpr ? sprintf("%1\$.2f%%", $totalClicks / $totalImpr * 100) : "&nbsp;";?></td>
            <td align="right" style="font-weight: bold; "><?php echo $totalClicks ? sprintf("$%1\$.2f", $totalCost / $totalClicks) : "&nbsp;";?></td>
            <td align="right" style="font-weight: bold; "><?php echo $totalCost ? sprintf("$%1\$.2f", $totalCost) : "&nbsp";?></td>
        </tr>
        </tbody>
    </table>
</div>

<script>
    $(function() {
        $("#cusFromDate").datepicker({
            dateFormat: "yy-mm-dd",
            maxDate: "-1D"
        });

        $("#cusEndDate").datepicker({
            dateFormat: "yy-mm-dd",
            maxDate: "today"
        });

        $("#performanceDateRange").change(function () {
            var today = moment();
            switch ($("#performanceDateRange").val()) {
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
                    updatePerformanceStatistic(moment().weekday(0).subtract(7, 'days').format("YYYY-MM-DD"), moment().weekday(6).subtract(7, 'days').format("YYYY-MM-DD"));
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
                    updatePerformanceStatistic(moment().month(moment().month() - 1).startOf("month").format("YYYY-MM-DD"), moment().month(moment().month() - 1).endOf("month").format("YYYY-MM-DD"));
                    break;
                default :
                    updatePerformanceStatistic(moment().subtract(14, 'days').format("YYYY-MM-DD"), moment().format("YYYY-MM-DD"));
                    break;
            }
        });
    });

    function updatePerformanceStatistic(startDate, endDate)
    {
        $("#cusFromDate").val(startDate);
        $("#cusEndDate").val(endDate);

        $("#ad_form").submit();
    }

    function updateDomainSetting(domain, obj)
    {
        if(!confirm("Would you like to "+$(obj).attr("action")+" this domain?")) return false;
        $("#ajaxloading").css("display", "block");
        $.ajax({
            type: "POST",
            url: '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/adcampaign/updateDomainSetting");?>',
            data: {
                domain: domain,
                action: $(obj).attr("action"),
                ad_campaign_id: <?php echo $model->id;?>
            },
            dataType: "JSON",
            success: function (data, status, xhr) {
                $("#ajaxloading").css("display", "none");
                if(data['status'] == 'success') {
                    if ($("img[domain='" + domain + "']").attr("action") == 'include') {
                        $("img[domain='" + domain + "']").attr("src", "/images/delicon.gif");
                        $("img[domain='" + domain + "']").attr("action", "exclude");
                    }
                    else {
                        $("img[domain='" + domain + "']").attr("src", "/images/addicon.gif");
                        $("img[domain='" + domain + "']").attr("action", "include");
                    }
                }
                else {
                    alert("Faile to "+action+" domain: "+domain+".\nPlease try again later.");
                }
            },
            error: function (data, status, xhr) {
                $("#ajaxloading").css("display", "none");
                alert("Faile to "+$("img[domain='" + domain + "']").attr("action")+" domain: "+domain+".\nPlease try again later.");
            }
        });
    }
</script>