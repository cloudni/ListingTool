<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/4/15
 * Time: 22:35
 */

/* @var $this ADGroupController */
/* @var $model ADGroup */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'ad_group_form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
    'htmlOptions'=>array(
        'onsubmit'=>' return validate()',
    ),
));

$setting = (array)json_decode($model->criteria);
?>

<div style="clear: both; width: 100%; position: relative; top: -5px; ">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal; display: none;">
                </div>
            </div>
            <div style="padding: 12px;">
                <div style="clear: both; width: 100%;">
                    <div style="float: left; width: 20%; text-align: right;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'name');?>: </div>
                    <div style="float: left; width: auto; text-align: left; padding-left: 12px;">
                        <input type="text" id="adgroup_name" name="adgroup[name]" size="60" maxlength="50" <?php if(!$model->isNewRecord) echo 'disabled';?> value="<?php echo $model->name;?>" />
                    </div>
                </div>
                <div style="clear: both; width: 100%; padding-top: 12px;">
                    <div style="float: left; width: 20%; text-align: right;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'default_max_cpc');?>: </div>
                    <div style="float: left; width: auto; text-align: left; padding-left: 12px;">
                        <input type="text" id="adgroup_default_bid" name="adgroup[default_bid]" size="11" maxlength="10" style="text-align: right;" onkeyup="CheckInputFloat(this);" value="<?php echo sprintf("%1\$.2f", $model->default_bid);?>" />
                        <span class="adCampaignBudgetCurrency">$</span>
                    </div>
                </div>
                <div style="clear: both; width: 100%; padding-top: 12px;">
                    <div style="float: left; width: 20%; text-align: right;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_group_keywords');?>: </div>
                    <div style="float: left; width: 70%; text-align: left; padding-left: 12px;">
                        <div>
                            <span style="position: relative; top: -4px;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_group_keyword_one_per_line');?></span>
                            <img height="16" width="24" border="0" src="/images/help.gif" onmouseout="HideHelp('d13');" onmouseover="ShowHelp('d13', '<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_group_keywords_help_title');?>', '<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_group_keywords_help_content');?>')" >
                            <div id="d13" style="display: none;"></div>
                        </div>
                        <textarea id="keywords" name="keywords" rows="10" style="width: 100%;"><?php echo $model->isNewRecord ? "" : str_replace(ADGroup::Criteria_Separator, "\n", $setting['keywords']);?></textarea>
                    </div>
                </div>
                <div style="clear: both; width: 100%; padding-top: 12px;">
                    <div style="float: left; width: 20%; text-align: right;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_group_placements');?>: </div>
                    <div style="float: left; width: 70%; text-align: left; padding-left: 12px;">
                        <div>
                            <span style="position: relative; top: -4px;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_group_placement_one_per_line');?></span>
                            <img height="16" width="24" border="0" src="/images/help.gif" onmouseout="HideHelp('d14');" onmouseover="ShowHelp('d14', '<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_group_placements_help_title');?>', '<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_group_placements_help_content');?>')" >
                            <div id="d14" style="display: none;"></div>
                        </div>
                        <textarea id="placements" name="placements" rows="10" style="width: 100%;"><?php echo $model->isNewRecord ? "" : str_replace(ADGroup::Criteria_Separator, "\n", $setting['placements']);?></textarea>
                    </div>
                </div>
                <div style="height: 12px; clear: both;">&nbsp;</div>
            </div>
        </div>
    </div>
</div>

<div id="submit_panel" class="borderBlock">
    <div>
        <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
            <div style="height: 36px; color: #9197a3; font-weight: normal;">
                <h1 style="color: #4e5665; font-weight: 700; padding: 0px 0px 0px 12px; line-height: 38px; position: relative;">
                    <?php echo CHtml::submitButton(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'submit'), array('id'=>'form_submit', 'class'=>'greenButton', 'style'=>'font-size: 12px; line-height: 176%;')); ?>
                    <input type="button" value="<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'cancel');?>" class="greenButton" style="font-size: 12px; line-height: 166%;background: -webkit-linear-gradient(gray, gray); background-color: gray; -webkit-box-shadow: inset 0 1px 1px gray; border-color: gray;" onclick=" if(confirm('Are you sure to cancel and back to AD Group list?')) window.location='<?php echo Yii::app()->createAbsoluteUrl("/marketing/advertisement/adgroup");?>' " />
                </h1>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<script>

    function CheckInputFloat(oInput)
    {
        if('' != oInput.value.replace(/\d{1,}\.{0,1}\d{0,}/,''))
        {
            oInput.value = oInput.value.match(/\d{1,}\.{0,1}\d{0,}/) == null ? '' :oInput.value.match(/\d{1,}\.{0,1}\d{0,}/);
        }
    }

    function validate()
    {

    }
</script>