<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/4/16
 * Time: 14:01
 */

/* @var $this ADAdvertiseController */
/* @var $model ADAdvertise */
/* @var $form CActiveForm */
?>

<style>
    .DabE-j {
        border-style: solid;
        border-width: 2px;
        border-color: gray;
        background-image: url(/themes/facebook/images/noimage.png);
        background-repeat: repeat;
        width: 60px;
        height: 50px;
        position: relative;
    }

    .removeButton{
        background-image: url(/themes/facebook/images/NKweBg8DV6y.png);
        background-repeat: no-repeat;
        background-size: auto;
        background-position: -509px -160px;
        height: 12px;
        width: 12px;
        display: inline-block;
        cursor: pointer;
        display: inline-block;
    }
</style>

<div style="clear: both; width: 100%; position: relative; top: -5px; ">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal; display: none;">
                </div>
            </div>
            <div style="clear: both; width: 100%;">
                <div style="padding: 12px; float: left; width: 60%;">
                    <div style="width: 80%;clear: both;">
                        <h1>Logo</h1>
                        <div style="padding-top: 7px; clear: both;">
                            <table cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td style="width: 80px; padding: 0px;" align="left">
                                        <div class="DabE-j" style="float: left;">

                                        </div>
                                    </td>
                                    <td style="  vertical-align: bottom; padding: 0px;">
                                        <div class="removeButton" style="display: none;"></div>
                                        <input type="button" value="Upload Logo" style="margin-left: 7px;" />
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr />
                    <div style="width: 80%;clear: both;">
                        <h1>Headline (optional)</h1>
                        <div style="padding-top: 5px;"><input type="text" value="" size="40" style="height: 22px;" maxlength="25" /></div>
                        <div style="display: block; padding-top: 5px;">
                            <img id="headlineOptions_img" src="/themes/facebook/images/rightArrow.png" />
                            <span id="headlineOptions" style="position: relative; top: -6px; cursor: pointer;">More Options</span>
                        </div>
                        <div style="display: block; padding-top: 5px; padding-left: 7px;">
                            <div style="display: block; clear: both; height: 18px;">
                                <div style="float: left">Headline color (optional)</div>
                                <div style="float: right;">ss</div>
                            </div>
                            <div style="display: block; clear: both; padding-top: 5px; height: 18px;">
                                <div style="float: left">Headline background color (optional)</div>
                                <div style="float: right;">ss</div>
                            </div>
                            <div style="display: block; clear: both; padding-top: 5px; height: 18px;">
                                <div style="float: left">Headline text size (optional)</div>
                                <div style="float: right;"><input type="text" size="15" maxlength="5" /></div>
                            </div>
                            <div style="display: block; clear: both; padding-top: 5px; height: 18px;">
                                <div style="float: left">Headline shadow (optional)</div>
                                <div style="float: right;">
                                    <select>
                                        <option>Include shadow</option>
                                        <option selected>No shadow</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="height: 12px; clear: both;">&nbsp;</div>
                    <hr />
                    <div style="width: 80%;clear: both;">
                        <h1>Price prefix (optional)</h1>
                        <div style="padding-top: 5px;"><input type="text" value="" size="40" style="height: 22px;" maxlength="25" /></div>
                        <div style="display: block; padding-top: 5px;">
                            <img id="pricePrefixOptions_img" src="/themes/facebook/images/rightArrow.png" />
                            <span id="pricePrefixOptions" style="position: relative; top: -6px; cursor: pointer;">More Options</span>
                        </div>
                        <div style="display: block; padding-top: 5px; padding-left: 7px;">
                            <div style="display: block; clear: both; height: 18px;">
                                <div style="float: left">Price prefix color (optional)</div>
                                <div style="float: right;">ss</div>
                            </div>
                            <div style="display: block; clear: both; padding-top: 5px; height: 18px;">
                                <div style="float: left">Price prefix text size (optional)</div>
                                <div style="float: right;"><input type="text" size="15" maxlength="5" /></div>
                            </div>
                        </div>
                    </div>
                    <div style="height: 12px; clear: both;">&nbsp;</div>
                    <hr />
                    <div style="width: 80%;clear: both;">
                        <h1>Price suffix (optional)</h1>
                        <div style="padding-top: 5px;"><input type="text" value="" size="40" style="height: 22px;" maxlength="25" /></div>
                        <div style="display: block; padding-top: 5px;">
                            <img id="priceSuffixOptions_img" src="/themes/facebook/images/rightArrow.png" />
                            <span id="priceSuffixOptions" style="position: relative; top: -6px; cursor: pointer;">More Options</span>
                        </div>
                        <div style="display: block; padding-top: 5px; padding-left: 7px;">
                            <div style="display: block; clear: both; height: 18px;">
                                <div style="float: left">Price suffix color (optional)</div>
                                <div style="float: right;">ss</div>
                            </div>
                            <div style="display: block; clear: both; padding-top: 5px; height: 18px;">
                                <div style="float: left">Price suffix text size (optional)</div>
                                <div style="float: right;"><input type="text" size="15" maxlength="5" /></div>
                            </div>
                        </div>
                    </div>
                    <div style="height: 12px; clear: both;">&nbsp;</div>
                    <hr />
                    <div style="width: 80%;clear: both;">
                        <h1>Button (optional)</h1>
                        <div style="padding-top: 5px;"><input type="text" value="" size="40" style="height: 22px;" maxlength="25" /></div>
                        <div style="display: block; padding-top: 5px;">
                            <img id="buttonOptions_img" src="/themes/facebook/images/rightArrow.png" />
                            <span id="buttonOptions" style="position: relative; top: -6px; cursor: pointer;">More Options</span>
                        </div>
                        <div style="display: block; padding-top: 5px; padding-left: 7px;">
                            <div style="display: block; clear: both; padding-top: 5px; height: 18px;">
                                <div style="float: left">Button text color (optional)</div>
                                <div style="float: right;">ss</div>
                            </div>
                            <div style="display: block; clear: both; padding-top: 5px; height: 18px;"">
                                <div style="float: left">Button color (optional)</div>
                                <div style="float: right;">ss</div>
                            </div>
                            <div style="display: block; clear: both; padding-top: 5px; height: 18px;">
                                <div style="float: left">Rollover color (optional)</div>
                                <div style="float: right;">ss</div>
                            </div>
                            <div style="display: block; clear: both; padding-top: 5px; height: 18px;">
                                <div style="float: left">Button corners (optional)</div>
                                <div style="float: right;">
                                    <select>
                                        <option>Round corner</option>
                                        <option selected>Square corner</option>
                                    </select>
                                </div>
                            </div>
                            <div style="display: block; clear: both; padding-top: 5px; height: 18px;">
                                <div style="float: left">Button bevel (optional)</div>
                                <div style="float: right;">
                                    <select>
                                        <option>Include bevel</option>
                                        <option selected>No bevel</option>
                                    </select>
                                </div>
                            </div>
                            <div style="display: block; clear: both; padding-top: 5px; height: 18px;">
                                <div style="float: left">Button shadow (optional)</div>
                                <div style="float: right;">
                                    <select>
                                        <option>Include shadow</option>
                                        <option selected>No shadow</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="height: 12px; clear: both;">&nbsp;</div>
                    <hr />
                    <div style="width: 80%;clear: both;">
                        <h1>Display URL</h1>
                        <div style="padding-top: 5px;"><input type="text" value="" size="60" style="height: 22px;" maxlength="500" /></div>
                        <h1 style="padding-top: 5px;">Landing Page</h1>
                        <div style="padding-top: 5px;"><input type="text" value="" size="60" style="height: 22px;" maxlength="500" /></div>
                        <div style="display: block; padding-top: 5px;">
                            <img id="priceSuffixOptions_img" src="/themes/facebook/images/rightArrow.png" />
                            <span id="priceSuffixOptions" style="position: relative; top: -6px; cursor: pointer;">More Options</span>
                        </div>
                        <div style="display: block; padding-top: 5px; padding-left: 7px;">
                            <div style="display: block; clear: both; height: 18px;">
                                <div style="float: left">Click behavior(optional)</div>
                                <div style="float: right;">
                                    <select>
                                        <option>Navigate to a product URL</option>
                                        <option>Navigate to an AD URL</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="padding: 12px; float: left;width: 35%;">
                    <h1 class="boldFont">AD preview</h1>
                    <div style="width: 320px; height: 270px; padding-top: 12px;">
                        <div id="adPreViewSingle" style="width: 300px; height: 250px; border: 1px solid gray;">

                        </div>
                    </div>
                    <div style="width: 320px; height: 270px; padding-top: 22px;">
                        <div id="adPreViewM" style="width: 300px; height: 250px; border: 1px solid gray;">

                        </div>
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
                    <input type="button" value="<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'cancel');?>" class="greenButton" style="font-size: 12px; line-height: 166%;background: -webkit-linear-gradient(gray, gray); background-color: gray; -webkit-box-shadow: inset 0 1px 1px gray; border-color: gray;" onclick=" if(confirm('Are you sure to cancel and back to Advertisement list?')) window.location='<?php echo Yii::app()->createAbsoluteUrl("/marketing/advertisement/ad");?>' " />
                </h1>
            </div>
        </div>
    </div>
</div>