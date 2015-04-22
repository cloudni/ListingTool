<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/4/16
 * Time: 11:12
 */

/* @var $this ADAdvertiseController */
/* @var $model ADAdvertise */
/* @var $lead string */
/* @var $adCampaignId int */
/* @var $adGroupId int */

$this->breadcrumbs=array(
    'Marketing'=>array("/marketing/home"),
    'Advertisement'=>array("/marketing/advertisement/home"),
    'AD Campaign'=>array('/marketing/advertisement/adcampaign/index'),
    'AD Group'=>array('/marketing/advertisement/adgroup/index'),
    'AD' => array('index'),
    'Create'
);
?>

<style>
    .DTMORHD-pb-h {
        position: relative;
        z-index: 1;
    }

    .DTMORHD-ob-f {
        display: inline-block;
        margin-left: 20px;
        white-space: nowrap;
    }

    .DTMORHD-ob-c {
        width: 100%;
        background-color: white;
        border-bottom: 1px solid #ddd;
        margin-top: -11px;
        margin-bottom: 25px;
        margin-left: -20px;
        margin-right: -20px;
        padding: 14px 20px;
        -webkit-font-smoothing: subpixel-antialiased;
    }

    .DTMORHD-pb-f {
        height: 20px;
        width: 20px;
        border-radius: 10px;
        background-color: #b2b2b2;
        font-size: 10px;
        font-family: Arial,Helvetica,sans-serif;
        color: #fff;
        margin-right: -0.35em;
        line-height: 20px;
        text-align: center;
        display: inline-block;
    }

    .aw3ProgressBarV2StepText {
        padding-left: 8px;
        padding-right: 8px;
        vertical-align: -1px;
        /*background-color: white;*/
        display: inline-block;
    }

    .aw3ProgressBarV2StepCell {
        height: inherit;
        min-width: 278px;
        display: inline-block;
        padding: 4px 0;
    }

    .aw3ProgressBarV2StepSelected {
        background-color: #4d90fe;
        background-image: none;
        color: #fff;
    }
</style>

<?php if(isset($lead)):?>
<div style="clear: both; width: 100%; position: relative; top: -3px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 66px; color: #9197a3; font-weight: normal;">
                    <div style="color: #4e5665; font-weight: 700; padding-left: 12px; line-height: 38px; position: relative;">
                        <div>
                            <div class="DTMORHD-ob-c">
                                <?php if($lead=='campaign'):?>
                                    <div class="DTMORHD-ob-f">
                                        <div class="aw3ProgressBarV2StepCell">
                                            <div class="DTMORHD-pb-h">
                                                <div class="DTMORHD-pb-f">1</div>
                                                <div class="aw3ProgressBarV2StepText">Select campaign settings</div>
                                            </div>
                                            <div class="DTMORHD-pb-g"></div>
                                        </div>
                                        <div class="aw3ProgressBarV2StepCell">
                                            <div class="DTMORHD-pb-h">
                                                <div class="DTMORHD-pb-f">2</div>
                                                <div class="aw3ProgressBarV2StepText">Create an ad group</div>
                                            </div>
                                            <div class="DTMORHD-pb-g"></div>
                                        </div>
                                        <div class="aw3ProgressBarV2StepCell DTMORHD-pb-e">
                                            <div class="DTMORHD-pb-h">
                                                <div class="DTMORHD-pb-f aw3ProgressBarV2StepSelected">3</div>
                                                <div class="aw3ProgressBarV2StepText">Create ads</div>
                                            </div>
                                            <div class="DTMORHD-pb-g"></div>
                                        </div>
                                    </div>
                                <?php else:?>
                                    <div class="DTMORHD-ob-f">
                                        <div class="aw3ProgressBarV2StepCell">
                                            <div class="DTMORHD-pb-h">
                                                <div class="DTMORHD-pb-f">1</div>
                                                <div class="aw3ProgressBarV2StepText">Create an ad group</div>
                                            </div>
                                            <div class="DTMORHD-pb-g"></div>
                                        </div>
                                        <div class="aw3ProgressBarV2StepCell DTMORHD-pb-e">
                                            <div class="DTMORHD-pb-h">
                                                <div class="DTMORHD-pb-f aw3ProgressBarV2StepSelected">2</div>
                                                <div class="aw3ProgressBarV2StepText">Create ads</div>
                                            </div>
                                            <div class="DTMORHD-pb-g"></div>
                                        </div>
                                    </div>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
            </div>
        </div>
    </div>
</div>
<?php endif;?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>