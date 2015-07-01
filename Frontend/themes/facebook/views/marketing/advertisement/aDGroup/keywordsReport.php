<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/6/19
 * Time: 8:51
 */

/* @var $this ADGroupController */
/* @var $model ADGroup */
/* @var $performances array */

$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'menu_marketing')=>array("/marketing/home"),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'display_advertisement')=>array("/marketing/advertisement/home"),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign')=>array('/marketing/advertisement/ADCampaign/index'),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_group')=>array('index'),
    $model->name=>array('view', "id"=>$model->id),
    'Keywords report'
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
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 12px; line-height: 38px; position: relative;">Keywords Report: <?php echo $model->name;?></h1>
                </div>
            </div>
            <div>
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <thead>
                    <th>&nbsp;</th>
                    <th align="left" style="padding-left: 12px; ">Keywords</th>
                    <th align="left">Status</th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'clicks');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'impressions');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'click_through_rate');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'average_cost_per_click');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'cost');?></th>
                    </thead>
                    <tbody>
                    <?php if(isset($performances) && !empty($performances)):?>
                        <?php foreach($performances as $performance):?>
                            <?php if(!$performance['keyword_text']) continue;?>
                            <tr>
                                <td><img keyword="<?php echo $performance['keyword_text'];?>" action="<?php echo $performance["group_exclude_id"] ?  "include" : "exclude";?>" src="<?php echo $performance["campaign_exclude_id"] ? "/images/info.gif" : ($performance["group_exclude_id"] ?  "/images/addicon.gif" : "/images/delicon.gif");?>" <?php if(!$performance["campaign_exclude_id"]):?>onclick="updateKeywordSetting('<?php echo $performance['keyword_text'];?>', this);"<?php else:?>title="This keyword has been excluded by campaign."<?php endif;?> /></td>
                                <td align="left" style="padding-left: 12px; "><?php echo $performance['keyword_text'];?></td>
                                <td align="left"><?php echo $performance['status'];?></td>
                                <td align="right"><?php echo $performance['clicks'];?></td>
                                <td align="right"><?php echo $performance['impr'];?></td>
                                <td align="right"><?php echo $performance['impr'] ? sprintf("%1\$.2f%%", $performance['clicks'] / $performance['impr'] * 100) : "&nbsp;";?></td>
                                <td align="right"><?php echo $performance['clicks'] ? sprintf("$%1\$.2f", $performance['cost'] / $performance['clicks']) : "&nbsp;";?></td>
                                <td align="right"><?php echo $performance['cost'] ? sprintf("$%1\$.2f", $performance['cost']) : "&nbsp";?></td>
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

    function updateKeywordSetting(keyword, obj)
    {
        if(!confirm("Would you like to "+$(obj).attr("action")+" this keyword?")) return false;
        $("#ajaxloading").css("display", "block");
        $.ajax({
            type: "POST",
            url: '<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/ADGroup/updateKeywordSetting");?>',
            data: {
                keyword: keyword,
                action: $(obj).attr("action"),
                ad_campaign_id: <?php echo $model->campaign_id;?>,
                ad_group_id: <?php echo $model->id;?>
            },
            dataType: "JSON",
            success: function (data, status, xhr) {
                $("#ajaxloading").css("display", "none");
                if(data['status'] == 'success') {
                    if ($("img[keyword='" + keyword + "']").attr("action") == 'include') {
                        $("img[keyword='" + keyword + "']").attr("src", "/images/delicon.gif");
                        $("img[keyword='" + keyword + "']").attr("action", "exclude");
                    }
                    else {
                        $("img[keyword='" + keyword + "']").attr("src", "/images/addicon.gif");
                        $("img[keyword='" + keyword + "']").attr("action", "include");
                    }
                }
                else {
                    alert("Faile to "+action+" keyword: "+keyword+".\nPlease try again later.");
                }
            },
            error: function (data, status, xhr) {
                $("#ajaxloading").css("display", "none");
                alert("Faile to "+$("img[keyword='" + keyword + "']").attr("action")+" keyword: "+keyword+".\nPlease try again later.");
            }
        });
    }
</script>