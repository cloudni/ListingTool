<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/4/16
 * Time: 11:23
 */

/* @var $this ADAdvertiseController */
/* @var $model ADAdvertise */
/* @var $adCampaignId int */
/* @var $adGroupId int */

$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'menu_marketing')=>array("/marketing/home"),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'display_advertisement')=>array("/marketing/advertisement/home"),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign')=>array('/marketing/advertisement/ADCampaign/index'),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_group')=>array('/marketing/advertisement/aDGroup/index'),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_advertisement')=> array('index'),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'create')
);
?>

<div style="clear: both; width: 100%; ">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="color: #9197a3; font-weight: normal; padding: 12px;">
                    <div style="color: #333; font-size: 15px; margin-bottom: 10px; padding: 0;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'select_an_ad_campaign_and_group');?></div>
                    <?php
                    $campaigns = ADCampaign::model()->findAll(array('select'=>"id, name", "condition"=>"company_id=:company_id", "params"=>array(':company_id' => Yii::app()->session['user']->company_id)));
                    $campaignList = array();
                    foreach($campaigns as $campaign) $campaignList[$campaign->id] = $campaign->name;
                    echo CHtml::dropDownList('campaign', '', $campaignList, array(
                        'empty'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'select_an_ad_campaign_dropdown'),
                        "style"=>"height: 27px; margin-bottom: 10px; margin-right: 20px;",

                    ));
                    echo CHtml::dropDownList('group','', array(),array("style"=>"height: 27px; margin-bottom: 10px;"));
                    ?>
                    <div style="color: #333; font-size: 15px; padding: 0;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'you_will_create_ad_on_next_page');?></div>
                </div>
            </div>
            <div style="display: block;">
            </div>
        </div>
    </div>
</div>

<div id="submit_panel" class="borderBlock">
    <div>
        <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
            <div style="height: 36px; color: #9197a3; font-weight: normal;">
                <h1 style="color: #4e5665; font-weight: 700; padding: 0px 0px 0px 12px; line-height: 38px; position: relative;">
                    <input type="button" id="submit" value="<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'submit');?>" class="greenButton" style="font-size: 12px; line-height: 176%;" />
                    <input type="button" value="<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'cancel');?>" class="greenButton" style="font-size: 12px; line-height: 166%;background: -webkit-linear-gradient(gray, gray); background-color: gray; -webkit-box-shadow: inset 0 1px 1px gray; border-color: gray;" onclick=" if(confirm('Are you sure to cancel and back to Advertisement list?')) window.location='<?php echo Yii::app()->createAbsoluteUrl("/marketing/advertisement/AD");?>' " />
                </h1>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $("#submit").click(function(){
            var error=""
            if($("#campaign").val() == "")
            {
                error += "<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'select_an_ad_campaign_warning');?>\n";
            }
            if($("#group").val() == "")
            {
                error += "<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'select_an_ad_group_warning');?>\n";
            }

            if(error.length>0)
            {
                alert(error);
                return false;
            }

            var location = "<?php echo Yii::app()->createAbsoluteUrl("/marketing/advertisement/AD/create/adcampaignid/campaign_id/adgroupid/group_id");?>";

            window.location = location.replace("campaign_id", $("#campaign").val()).replace("group_id", $("#group").val())
        });

        $("#campaign").change(function(){
            $.ajax({
                type: "POST",
                url: '<?php echo Yii::app()->createAbsoluteUrl('/marketing/advertisement/AD/getDynamicGroupList');?>',
                data: {
                    campaign_id:$("#campaign").val()
                },
                dataType: "JSON",
                success: function(data, status, xhr) {
                    $("#group option").remove();
                    $("#group").html(data);
                },
                error: function(data, status, xhr) {
                    alert(data['msg']);
                }
            });
        });
    });
</script>