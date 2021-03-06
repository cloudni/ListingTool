<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/4/22
 * Time: 20:16
 */

/* @var $this ADGroupController */
/* @var $model ADGroup */
/* @var $placements array */

$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'menu_marketing')=>array("/marketing/home"),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'display_advertisement')=>array("/marketing/advertisement/home"),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign')=>array('/marketing/advertisement/ADCampaign/index'),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_group')=>array('index'),
    $model->name=>array('view', "id"=>$model->id),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'automatic_placement_report')
);

$this->menu=array(
    array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_group_index'), 'url'=>array('index')),
    array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_group_create'), 'url'=>array('create')),
);
?>

<script type="text/javascript" src="/js/moment/moment.min.js"></script>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="position: relative; float: right;">
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
                        <span>&nbsp;&nbsp;</span>
                        <input type="submit" value="Go" />
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
                <div style="height: 36px; color: #9197a3; font-weight: normal; width: 40%;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 12px; line-height: 38px; position: relative;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'automatic_placement_report_for_ad_group');?><?php echo $model->name;?></h1>
                </div>
            </div>
            <div>
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <thead>
                    <th>&nbsp;</th>
                    <th align="left" style="padding-left: 12px; "><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'automatic_placement');?></th>
                    <th align="left"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'url');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'clicks');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'impressions');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'click_through_rate');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'average_cost_per_click');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'cost');?></th>
                    </thead>
                    <tbody>
                    <?php if(isset($placements) && !empty($placements)):?>
                        <?php foreach($placements as $placement):?>
                            <tr>
                                <td><img domain="<?php echo $placement['domain'];?>" action="<?php echo $placement["group_exclude_id"] ?  "include" : "exclude";?>" src="<?php echo $placement["campaign_exclude_id"] ? "/images/info.gif" : ($placement["group_exclude_id"] ?  "/images/addicon.gif" : "/images/delicon.gif");?>" <?php if(!$placement["campaign_exclude_id"]):?>onclick="updateDomainSetting('<?php echo $placement['domain'];?>', this);"<?php else:?>title="This domain has been excluded by campaign."<?php endif;?> /></td>
                                <td align="left" style="padding-left: 12px; " width="20%"><a href="//<?php echo $placement['display_name'];?>" title="<?php echo $placement['display_name'];?>" target="_blank"><?php echo strlen($placement['display_name']) > 50 ? substr($placement['display_name'], 0, 50).'...' : $placement['display_name'];?></a></td>
                                <td align="left"><span title="<?php echo $placement['domain'];?>"><?php echo strlen($placement['domain']) > 20 ? substr($placement['domain'], 0, 20).'...' : $placement['domain'];?></span></td>
                                <td align="right"><?php echo $placement['clicks'];?></td>
                                <td align="right"><?php echo $placement['impr'];?></td>
                                <td align="right"><?php echo $placement['impr'] ? sprintf("%1\$.2f%%", $placement['clicks'] / $placement['impr'] * 100) : "&nbsp;";?></td>
                                <td align="right"><?php echo $placement['clicks'] ? sprintf("$%1\$.2f", $placement['cost'] / $placement['clicks']) : "&nbsp;";?></td>
                                <td align="right"><?php echo $placement['cost'] ? sprintf("$%1\$.2f", $placement['cost']) : "&nbsp";?></td>
                            </tr>
                            <?php endforeach; ?>
                    <?php endif;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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
            url: '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/ADGroup/updateDomainSetting");?>',
            data: {
                domain: domain,
                action: $(obj).attr("action"),
                ad_campaign_id: <?php echo $model->campaign_id;?>,
                ad_group_id: <?php echo $model->id;?>
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