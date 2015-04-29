<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/4/15
 * Time: 20:14
 */

/* @var $this ADGroupController */
/* @var $model ADGroup */

$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'menu_marketing')=>array("/marketing/home"),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'display_advertisement')=>array("/marketing/advertisement/home"),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign')=>array('/marketing/advertisement/ADCampaign/index'),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_group')=>array('index'),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'create')
);
?>

<div style="clear: both; width: 100%; ">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="color: #9197a3; font-weight: normal; padding: 12px;">
                    <div style="color: #333; font-size: 15px; margin-bottom: 10px; padding: 0;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'select_an_ad_campaign');?></div>
                    <?php
                        $campaigns = ADCampaign::model()->findAll(array('select'=>"id, name", "condition"=>"company_id=:company_id", "params"=>array(':company_id' => Yii::app()->session['user']->company_id)));
                        $campaignList = array();
                        foreach($campaigns as $campaign) $campaignList[$campaign->id] = $campaign->name;
                        echo CHtml::dropDownList('campaign', '', $campaignList, array('empty'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'dropdown_choose'), "style"=>"height: 27px; margin-bottom: 10px;"));
                    ?>
                    <div style="color: #333; font-size: 15px; padding: 0;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'you_will_create_ad_group_on_next_page');?></div>
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
                    <input type="button" value="<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'cancel');?>" class="greenButton" style="font-size: 12px; line-height: 166%;background: -webkit-linear-gradient(gray, gray); background-color: gray; -webkit-box-shadow: inset 0 1px 1px gray; border-color: gray;" onclick=" if(confirm('Are you sure to cancel and back to AD Group list?')) window.location='<?php echo Yii::app()->createAbsoluteUrl("/marketing/advertisement/ADGroup");?>' " />
                </h1>
            </div>
        </div>
    </div>
</div>

<script language="javascript">
    $(function() {
        $("#submit").click(function(){
            if($("#campaign").val() == "")
            {
                alert("Please choose a campaign to continue!");
                return false;
            }

            var location = "<?php echo Yii::app()->createAbsoluteUrl("/marketing/advertisement/ADGroup/create/campaignid");?>";

            window.location = location.replace("/ADGroup/create/campaignid", "/ADGroup/create/campaignid/"+$("#campaign").val())
        });
    });
</script>