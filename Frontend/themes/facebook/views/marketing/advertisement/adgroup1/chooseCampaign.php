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
    'Marketing'=>array("/marketing/home"),
    'Advertisement'=>array("/marketing/advertisement/home"),
    'AD Campaign'=>array('/marketing/advertisement/adcampaign/index'),
    'AD Group'=>array('index'),
    'Create'
);
?>

<div style="clear: both; width: 100%; ">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="color: #9197a3; font-weight: normal; padding: 12px;">
                    <div style="color: #333; font-size: 15px; margin-bottom: 10px; padding: 0;">Select a campaign</div>
                    <?php
                        $campaigns = ADCampaign::model()->findAll(array('select'=>"id, name", "condition"=>"company_id=:company_id", "params"=>array(':company_id' => Yii::app()->session['user']->company_id)));
                        $campaignList = array();
                        foreach($campaigns as $campaign) $campaignList[$campaign->id] = $campaign->name;
                        echo CHtml::dropDownList('campaign', '', $campaignList, array('empty'=>"Choose...", "style"=>"height: 27px; margin-bottom: 10px;"));
                    ?>
                    <div style="color: #333; font-size: 15px; padding: 0;">You'll start creating your new ad group on the next page.</div>
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
                    <input type="button" value="<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'cancel');?>" class="greenButton" style="font-size: 12px; line-height: 166%;background: -webkit-linear-gradient(gray, gray); background-color: gray; -webkit-box-shadow: inset 0 1px 1px gray; border-color: gray;" onclick=" if(confirm('Are you sure to cancel and back to AD Group list?')) window.location='<?php echo Yii::app()->createAbsoluteUrl("/marketing/advertisement/adgroup");?>' " />
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

            var location = "<?php echo Yii::app()->createAbsoluteUrl("/marketing/advertisement/adgroup/create/campaignid");?>";

            window.location = location.replace("/adgroup/create/campaignid", "/adgroup/create/campaignid/"+$("#campaign").val())
        });
    });
</script>