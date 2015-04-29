<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/4/10
 * Time: 21:05
 */
/* @var $this ADCampaignController */
/* @var $model ADCampaign */
/* @var $form CActiveForm */
?>

<style>
    .excludeLocationUL{
        list-style: none;
        padding: 5px 0px 5px 8px;
        margin: auto;
    }

    #schedule_option_remove{
        background-image: url(/themes/facebook/images/NKweBg8DV6y.png);
        background-repeat: no-repeat;
        background-size: auto;
        background-position: -509px -160px;
        height: 12px;
        width: 12px;
        display: inline-block;
        cursor: pointer;
        position: relative;
        top: 1px;
        display: inline-block;
        /*margin-left: 3px;*/
    }
</style>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'ad_campaign_form',
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
                    <div style="float: left; width: 20%; text-align: right;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign');?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'name');?>: </div>
                    <div style="float: left; width: auto; text-align: left; padding-left: 12px;">
                        <input type="text" id="campaign_name" name="campaign[name]" size="60" maxlength="50" <?php if(!$model->isNewRecord) echo 'disabled';?> value="<?php echo $model->name;?>" />
                    </div>
                </div>
                <div style="clear: both; width: 100%; padding-top: 12px;">
                    <div style="float: left; width: 20%; text-align: right;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'budget');?>: </div>
                    <div style="float: left; width: auto; text-align: left; padding-left: 12px;">
                        <input type="text" id="campaign_budget" name="campaign[budget]" size="11" maxlength="10" style="text-align: right;" onkeyup="CheckInputInt(this);" value="<?php echo sprintf("%1\$.0f", $model->budget);?>" />
                        <span class="adCampaignBudgetCurrency">$</span><span><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'per_day');?></span>
                    </div>
                </div>
                <div style="clear: both; width: 100%; padding-top: 12px; display: none;">
                    <div style="float: left; width: 20%; text-align: right;">Device: </div>
                    <div style="float: left; width: 75%; text-align: left; padding-left: 12px;">
                        <div>Ads will show on all eligible devices by default.</div>
                        <div id="device_option_all"><div class="boldFont">All Devices <a id="device_option_edit_button">Edit</a></div></div>
                        <div id="device_option_panel" style="display: none; padding-top: 3px; width: 100%; height: 100%;">
                            <div class="boldFont">Operating Systems</div>
                            <select id="device_os_select" name="device_os_select" class="multiselect" multiple="multiple" style="width: 200px;" >
                                <option value="Android" selected>Android</option>
                                <option value="iOS" selected>iOS</option>
                                <option value="webOS" selected>webOS</option>
                                <option value="Windows_Phone" selected>Windows Phone</option>
                            </select>
                            <input type="hidden" value="" id="device_os_select_value" name="device_os_select_value" />
                            <div class="boldFont" style="padding-top: 7px;">Device Models</div>
                            <select id="device_model_select" name="device_model_select" class="multiselect" multiple="multiple" style="width: 200px;" >
                                <option value="Android" selected>Android</option>
                                <option value="iPad" selected>iPad</option>
                                <option value="iPhone" selected>iPhone</option>
                                <option value="iPod Touch" selected>iPod Touch</option>
                            </select>
                            <input type="hidden" value="" id="device_model_select_value" name="device_model_select_value" />
                        </div>
                    </div>
                </div>
                <div style="clear: both; width: 100%; padding-top: 12px;">
                    <div style="float: left; width: 20%; text-align: right;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'language');?>: </div>
                    <div style="float: left; width: 75%; text-align: left; padding-left: 12px;">
                        <div><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'which_language_your_customer_speak');?></div>
                        <div id="language_option_all" <?php if(isset($setting['language']) && !empty($setting['language'])) echo "style='display: none;'";?> ><div class="boldFont"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'all_languages');?>&nbsp;<a id="language_option_edit_button"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'edit');?></a></div></div>
                        <div id="language_option_panel" style="display: <?php if(isset($setting['language']) && !empty($setting['language'])) echo "block"; else echo "none";?>; padding-top: 3px;" >
                            <div style="word-wrap: normal;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign_language_help');?></div>
                            <div><input type="checkbox" checked="checked" id="language_option_all_value" name="language_option_all_value" value="all_language" /><span><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'all_languages');?></span></div>
                            <div style="clear: both; width: 100%;">
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Indonesian" /><span>Indonesian</span></div>
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Japanese" /><span>Japanese</span></div>
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Turkish" /><span>Turkish</span></div>
                            </div>
                            <div style="clear: both; width: 100%;">
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Romanian" /><span>Romanian</span></div>
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Croatian" /><span>Croatian</span></div>
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Hungarian" /><span>Hungarian</span></div>
                            </div>
                            <div style="clear: both; width: 100%;">
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Swedish" /><span>Swedish</span></div>
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Czech" /><span>Czech</span></div>
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Icelandic" /><span>Icelandic</span></div>
                            </div>
                            <div style="clear: both; width: 100%;">
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Catalan" /><span>Catalan</span></div>
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Chinese (traditional)" /><span>Chinese (traditional)</span></div>
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Chinese (simplified)" /><span>Chinese (simplified)</span></div>
                            </div>
                            <div style="clear: both; width: 100%;">
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Dutch" /><span>Dutch</span></div>
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Filipino" /><span>Filipino</span></div>
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Greek" /><span>Greek</span></div>
                            </div>
                            <div style="clear: both; width: 100%;">
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Vietnamese" /><span>Vietnamese</span></div>
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Danish" /><span>Danish</span></div>
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Urdu" /><span>Urdu</span></div>
                            </div>
                            <div style="clear: both; width: 100%;">
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Persian" /><span>Persian</span></div>
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Spanish" /><span>Spanish</span></div>
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Lithuanian" /><span>Lithuanian</span></div>
                            </div>
                            <div style="clear: both; width: 100%;">
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Bulgarian" /><span>Bulgarian</span></div>
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Thai" /><span>Thai</span></div>
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Russian" /><span>Russian</span></div>
                            </div>
                            <div style="clear: both; width: 100%;">
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Malay" /><span>Malay</span></div>
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Finnish" /><span>Finnish</span></div>
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="German" /><span>German</span></div>
                            </div>
                            <div style="clear: both; width: 100%;">
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="English" /><span>English</span></div>
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Hebrew" /><span>Hebrew</span></div>
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Serbian" /><span>Serbian</span></div>
                            </div>
                            <div style="clear: both; width: 100%;">
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Slovenian" /><span>Slovenian</span></div>
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Polish" /><span>Polish</span></div>
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Korean" /><span>Korean</span></div>
                            </div>
                            <div style="clear: both; width: 100%;">
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Slovak" /><span>Slovak</span></div>
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Ukrainian" /><span>Ukrainian</span></div>
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Italian" /><span>Italian</span></div>
                            </div>
                            <div style="clear: both; width: 100%;">
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Hindi" /><span>Hindi</span></div>
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Norwegian" /><span>Norwegian</span></div>
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Arabic" /><span>Arabic</span></div>
                            </div>
                            <div style="clear: both; width: 100%;">
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Latvian" /><span>Latvian</span></div>
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Portuguese" /><span>Portuguese</span></div>
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="French" /><span>French</span></div>
                            </div>
                            <div style="clear: both; width: 100%;">
                                <div style="float: left; width: 30%; text-align: left;"><input type="checkbox" id="language_option_value[]" name="language_option_value[]" disabled value="Estonian" /><span>Estonian</span></div>
                                <div style="float: left; width: 30%; text-align: left;"></div>
                                <div style="float: left; width: 30%; text-align: left;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="clear: both; width: 100%; padding-top: 12px;">
                    <div style="float: left; width: 20%; text-align: right;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'location');?>: </div>
                    <div style="float: left; width: 75%; text-align: left; padding-left: 12px;">
                        <div><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'which_location_to_target_in_campaign');?></div>
                        <div id="location_option_all"><div class="boldFont"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'all_countries_and_territories');?>&nbsp;<a id="location_option_edit_button"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'edit');?></a></div></div>
                        <div id="location_option_panel" style="clear: both;display: none; padding-bottom: 12px;">
                            <div style="word-wrap: normal;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign_location_help');?></div>
                            <div><input type="checkbox" checked="checked" id="location_option_all_value" name="location_option_all_value" value="all_locations" /><span><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'all_countries_and_territories');?></span></div>
                            <div id="location_option_values" style="position: relative; left: -8px; display: none; " >
                                <ul class="excludeLocationUL">
                                    <li class="lfloat" style="padding-right: 15px; width: 40%;">
                                        <input onclick="checkExcludeWorldWideRegion(this);" id="exclude_ship_location_worldwide_list[]" name="exclude_ship_location_worldwide_list[]" type="checkbox" value="Africa">
                                        <span class="boldFont" onclick="updateExcludeWorldWideRegion('exclude_ship_location_worldwide_list_Africa_ul');">Africa</span>
                                        <ul class="excludeLocationUL" style="display: none;" id="exclude_ship_location_worldwide_list_Africa_ul">
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="DZ"><span>Algeria</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="AO"><span>Angola</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="BJ"><span>Benin</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="BW"><span>Botswana</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="BF"><span>Burkina Faso</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="BI"><span>Burundi</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="CM"><span>Cameroon</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="CV"><span>Cape Verde Islands</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="CF"><span>Central African Republic</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="TD"><span>Chad</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="KM"><span>Comoros</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="CD"><span>Congo, Democratic Republic of the</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="CG"><span>Congo, Republic of the</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="CI"><span>Cote d Ivoire (Ivory Coast)</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="DJ"><span>Djibouti</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="EG"><span>Egypt</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="GQ"><span>Equatorial Guinea</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="ER"><span>Eritrea</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="ET"><span>Ethiopia</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="GA"><span>Gabon Republic</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="GM"><span>Gambia</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="GH"><span>Ghana</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="GN"><span>Guinea</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="GW"><span>Guinea-Bissau</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="KE"><span>Kenya</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="LS"><span>Lesotho</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="LR"><span>Liberia</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="LY"><span>Libya</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="MG"><span>Madagascar</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="MW"><span>Malawi</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="ML"><span>Mali</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="MR"><span>Mauritania</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="MU"><span>Mauritius</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="YT"><span>Mayotte</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="MA"><span>Morocco</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="MZ"><span>Mozambique</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="NA"><span>Namibia</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="NE"><span>Niger</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="NG"><span>Nigeria</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="RE"><span>Reunion</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="RW"><span>Rwanda</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="SH"><span>Saint Helena</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="SN"><span>Senegal</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="SC"><span>Seychelles</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="SL"><span>Sierra Leone</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="SO"><span>Somalia</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="ZA"><span>South Africa</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="SZ"><span>Swaziland</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="TZ"><span>Tanzania</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="TG"><span>Togo</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="TN"><span>Tunisia</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="UG"><span>Uganda</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="EH"><span>Western Sahara</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="ZM"><span>Zambia</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Africa[]" name="exclude_ship_location_worldwide_list_Africa[]" type="checkbox" value="ZW"><span>Zimbabwe</span></li>
                                        </ul>
                                    </li>
                                    <li class="lfloat" style="padding-right: 15px; width: 40%;">
                                        <input onclick="checkExcludeWorldWideRegion(this);" id="exclude_ship_location_worldwide_list[]" name="exclude_ship_location_worldwide_list[]" type="checkbox" value="Asia">
                                        <span class="boldFont" onclick="updateExcludeWorldWideRegion('exclude_ship_location_worldwide_list_Asia_ul');">Asia</span>
                                        <ul class="excludeLocationUL" style="display: none;" id="exclude_ship_location_worldwide_list_Asia_ul">
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Asia[]" name="exclude_ship_location_worldwide_list_Asia[]" type="checkbox" value="AF"><span>Afghanistan</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Asia[]" name="exclude_ship_location_worldwide_list_Asia[]" type="checkbox" value="AM"><span>Armenia</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Asia[]" name="exclude_ship_location_worldwide_list_Asia[]" type="checkbox" value="AZ"><span>Azerbaijan Republic</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Asia[]" name="exclude_ship_location_worldwide_list_Asia[]" type="checkbox" value="BD"><span>Bangladesh</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Asia[]" name="exclude_ship_location_worldwide_list_Asia[]" type="checkbox" value="BT"><span>Bhutan</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Asia[]" name="exclude_ship_location_worldwide_list_Asia[]" type="checkbox" value="CN"><span>China</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Asia[]" name="exclude_ship_location_worldwide_list_Asia[]" type="checkbox" value="GE"><span>Georgia</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Asia[]" name="exclude_ship_location_worldwide_list_Asia[]" type="checkbox" value="IN"><span>India</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Asia[]" name="exclude_ship_location_worldwide_list_Asia[]" type="checkbox" value="JP"><span>Japan</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Asia[]" name="exclude_ship_location_worldwide_list_Asia[]" type="checkbox" value="KZ"><span>Kazakhstan</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Asia[]" name="exclude_ship_location_worldwide_list_Asia[]" type="checkbox" value="KR"><span>Korea, South</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Asia[]" name="exclude_ship_location_worldwide_list_Asia[]" type="checkbox" value="KG"><span>Kyrgyzstan</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Asia[]" name="exclude_ship_location_worldwide_list_Asia[]" type="checkbox" value="MV"><span>Maldives</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Asia[]" name="exclude_ship_location_worldwide_list_Asia[]" type="checkbox" value="MN"><span>Mongolia</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Asia[]" name="exclude_ship_location_worldwide_list_Asia[]" type="checkbox" value="NP"><span>Nepal</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Asia[]" name="exclude_ship_location_worldwide_list_Asia[]" type="checkbox" value="PK"><span>Pakistan</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Asia[]" name="exclude_ship_location_worldwide_list_Asia[]" type="checkbox" value="LK"><span>Sri Lanka</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Asia[]" name="exclude_ship_location_worldwide_list_Asia[]" type="checkbox" value="TJ"><span>Tajikistan</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Asia[]" name="exclude_ship_location_worldwide_list_Asia[]" type="checkbox" value="TM"><span>Turkmenistan</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Asia[]" name="exclude_ship_location_worldwide_list_Asia[]" type="checkbox" value="UZ"><span>Uzbekistan</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Asia[]" name="exclude_ship_location_worldwide_list_Asia[]" type="checkbox" value="RU"><span>Russian Federation</span></li>
                                        </ul>
                                    </li>
                                    <li class="lfloat" style="padding-right: 15px; width: 40%;">
                                        <input onclick="checkExcludeWorldWideRegion(this);" id="exclude_ship_location_worldwide_list[]" name="exclude_ship_location_worldwide_list[]" type="checkbox" value="Europe">
                                        <span class="boldFont" onclick="updateExcludeWorldWideRegion('exclude_ship_location_worldwide_list_Europe_ul');">Europe</span>
                                        <ul class="excludeLocationUL" style="display: none;" id="exclude_ship_location_worldwide_list_Europe_ul">
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="RU"><span>Russian Federation</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="AL"><span>Albania</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="AD"><span>Andorra</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="AT"><span>Austria</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="BY"><span>Belarus</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="BE"><span>Belgium</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="BA"><span>Bosnia and Herzegovina</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="BG"><span>Bulgaria</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="HR"><span>Croatia, Republic of</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="CY"><span>Cyprus</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="CZ"><span>Czech Republic</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="DK"><span>Denmark</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="EE"><span>Estonia</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="FI"><span>Finland</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="FR"><span>France</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="DE"><span>Germany</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="GI"><span>Gibraltar</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="GR"><span>Greece</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="GG"><span>Guernsey</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="HU"><span>Hungary</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="IS"><span>Iceland</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="IE"><span>Ireland</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="IT"><span>Italy</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="JE"><span>Jersey</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="LV"><span>Latvia</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="LI"><span>Liechtenstein</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="LT"><span>Lithuania</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="LU"><span>Luxembourg</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="MK"><span>Macedonia</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="MT"><span>Malta</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="MD"><span>Moldova</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="MC"><span>Monaco</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="ME"><span>Montenegro</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="NL"><span>Netherlands</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="NO"><span>Norway</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="PL"><span>Poland</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="PT"><span>Portugal</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="RO"><span>Romania</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="SM"><span>San Marino</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="RS"><span>Serbia</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="SK"><span>Slovakia</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="SI"><span>Slovenia</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="ES"><span>Spain</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="SJ"><span>Svalbard and Jan Mayen</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="SE"><span>Sweden</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="CH"><span>Switzerland</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="UA"><span>Ukraine</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="GB"><span>United Kingdom</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Europe[]" name="exclude_ship_location_worldwide_list_Europe[]" type="checkbox" value="VA"><span>Vatican City State</span></li>
                                        </ul>
                                    </li>
                                    <li class="lfloat" style="padding-right: 15px; width: 40%;">
                                        <input onclick="checkExcludeWorldWideRegion(this);" id="exclude_ship_location_worldwide_list[]" name="exclude_ship_location_worldwide_list[]" type="checkbox" value="Central_America_and_Caribbean">
                                        <span class="boldFont" onclick="updateExcludeWorldWideRegion('exclude_ship_location_worldwide_list_Central_America_and_Caribbean_ul');">Central America and Caribbean</span>
                                        <ul class="excludeLocationUL" style="display: none;" id="exclude_ship_location_worldwide_list_Central_America_and_Caribbean_ul">
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" name="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" type="checkbox" value="AI"><span>Anguilla</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" name="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" type="checkbox" value="AG"><span>Antigua and Barbuda</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" name="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" type="checkbox" value="AW"><span>Aruba</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" name="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" type="checkbox" value="BS"><span>Bahamas</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" name="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" type="checkbox" value="BB"><span>Barbados</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" name="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" type="checkbox" value="BZ"><span>Belize</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" name="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" type="checkbox" value="VG"><span>British Virgin Islands</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" name="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" type="checkbox" value="KY"><span>Cayman Islands</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" name="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" type="checkbox" value="CR"><span>Costa Rica</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" name="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" type="checkbox" value="DM"><span>Dominica</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" name="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" type="checkbox" value="DO"><span>Dominican Republic</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" name="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" type="checkbox" value="SV"><span>El Salvador</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" name="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" type="checkbox" value="GD"><span>Grenada</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" name="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" type="checkbox" value="GP"><span>Guadeloupe</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" name="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" type="checkbox" value="GT"><span>Guatemala</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" name="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" type="checkbox" value="HT"><span>Haiti</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" name="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" type="checkbox" value="HN"><span>Honduras</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" name="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" type="checkbox" value="JM"><span>Jamaica</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" name="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" type="checkbox" value="MQ"><span>Martinique</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" name="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" type="checkbox" value="MS"><span>Montserrat</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" name="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" type="checkbox" value="AN"><span>Netherlands Antilles</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" name="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" type="checkbox" value="NI"><span>Nicaragua</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" name="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" type="checkbox" value="PA"><span>Panama</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" name="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" type="checkbox" value="PR"><span>Puerto Rico</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" name="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" type="checkbox" value="KN"><span>Saint Kitts-Nevis</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" name="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" type="checkbox" value="LC"><span>Saint Lucia</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" name="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" type="checkbox" value="VC"><span>Saint Vincent and the Grenadines</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" name="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" type="checkbox" value="TT"><span>Trinidad and Tobago</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" name="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" type="checkbox" value="TC"><span>Turks and Caicos Islands</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" name="exclude_ship_location_worldwide_list_Central_America_and_Caribbean[]" type="checkbox" value="VI"><span>Virgin Islands (U.S.)</span></li>
                                        </ul>
                                    </li>
                                    <li class="lfloat" style="padding-right: 15px; width: 40%;">
                                        <input onclick="checkExcludeWorldWideRegion(this);" id="exclude_ship_location_worldwide_list[]" name="exclude_ship_location_worldwide_list[]" type="checkbox" value="Middle_East">
                                        <span class="boldFont" onclick="updateExcludeWorldWideRegion('exclude_ship_location_worldwide_list_Middle_East_ul');">Middle East</span>
                                        <ul class="excludeLocationUL" style="display: none;" id="exclude_ship_location_worldwide_list_Middle_East_ul">
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Middle_East[]" name="exclude_ship_location_worldwide_list_Middle_East[]" type="checkbox" value="BH"><span>Bahrain</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Middle_East[]" name="exclude_ship_location_worldwide_list_Middle_East[]" type="checkbox" value="IQ"><span>Iraq</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Middle_East[]" name="exclude_ship_location_worldwide_list_Middle_East[]" type="checkbox" value="IL"><span>Israel</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Middle_East[]" name="exclude_ship_location_worldwide_list_Middle_East[]" type="checkbox" value="JO"><span>Jordan</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Middle_East[]" name="exclude_ship_location_worldwide_list_Middle_East[]" type="checkbox" value="KW"><span>Kuwait</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Middle_East[]" name="exclude_ship_location_worldwide_list_Middle_East[]" type="checkbox" value="LB"><span>Lebanon</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Middle_East[]" name="exclude_ship_location_worldwide_list_Middle_East[]" type="checkbox" value="OM"><span>Oman</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Middle_East[]" name="exclude_ship_location_worldwide_list_Middle_East[]" type="checkbox" value="QA"><span>Qatar</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Middle_East[]" name="exclude_ship_location_worldwide_list_Middle_East[]" type="checkbox" value="SA"><span>Saudi Arabia</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Middle_East[]" name="exclude_ship_location_worldwide_list_Middle_East[]" type="checkbox" value="TR"><span>Turkey</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Middle_East[]" name="exclude_ship_location_worldwide_list_Middle_East[]" type="checkbox" value="AE"><span>United Arab Emirates</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Middle_East[]" name="exclude_ship_location_worldwide_list_Middle_East[]" type="checkbox" value="YE"><span>Yemen</span></li>
                                        </ul>
                                    </li>
                                    <li class="lfloat" style="padding-right: 15px; width: 40%;">
                                        <input onclick="checkExcludeWorldWideRegion(this);" id="exclude_ship_location_worldwide_list[]" name="exclude_ship_location_worldwide_list[]" type="checkbox" value="North_America">
                                        <span class="boldFont" onclick="updateExcludeWorldWideRegion('exclude_ship_location_worldwide_list_North_America_ul');">North America</span>
                                        <ul class="excludeLocationUL" style="display: none;" id="exclude_ship_location_worldwide_list_North_America_ul">
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_North_America[]" name="exclude_ship_location_worldwide_list_North_America[]" type="checkbox" value="US"><span>United States</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_North_America[]" name="exclude_ship_location_worldwide_list_North_America[]" type="checkbox" value="BM"><span>Bermuda</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_North_America[]" name="exclude_ship_location_worldwide_list_North_America[]" type="checkbox" value="CA"><span>Canada</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_North_America[]" name="exclude_ship_location_worldwide_list_North_America[]" type="checkbox" value="GL"><span>Greenland</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_North_America[]" name="exclude_ship_location_worldwide_list_North_America[]" type="checkbox" value="MX"><span>Mexico</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_North_America[]" name="exclude_ship_location_worldwide_list_North_America[]" type="checkbox" value="PM"><span>Saint Pierre and Miquelon</span></li>
                                        </ul>
                                    </li>
                                    <li class="lfloat" style="padding-right: 15px; width: 40%;">
                                        <input onclick="checkExcludeWorldWideRegion(this);" id="exclude_ship_location_worldwide_list[]" name="exclude_ship_location_worldwide_list[]" type="checkbox" value="Oceania">
                                        <span class="boldFont" onclick="updateExcludeWorldWideRegion('exclude_ship_location_worldwide_list_Oceania_ul');">Oceania</span>
                                        <ul class="excludeLocationUL" style="display: none;" id="exclude_ship_location_worldwide_list_Oceania_ul">
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Oceania[]" name="exclude_ship_location_worldwide_list_Oceania[]" type="checkbox" value="AS"><span>American Samoa</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Oceania[]" name="exclude_ship_location_worldwide_list_Oceania[]" type="checkbox" value="AU"><span>Australia</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Oceania[]" name="exclude_ship_location_worldwide_list_Oceania[]" type="checkbox" value="CK"><span>Cook Islands</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Oceania[]" name="exclude_ship_location_worldwide_list_Oceania[]" type="checkbox" value="FJ"><span>Fiji</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Oceania[]" name="exclude_ship_location_worldwide_list_Oceania[]" type="checkbox" value="PF"><span>French Polynesia</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Oceania[]" name="exclude_ship_location_worldwide_list_Oceania[]" type="checkbox" value="GU"><span>Guam</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Oceania[]" name="exclude_ship_location_worldwide_list_Oceania[]" type="checkbox" value="KI"><span>Kiribati</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Oceania[]" name="exclude_ship_location_worldwide_list_Oceania[]" type="checkbox" value="MH"><span>Marshall Islands</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Oceania[]" name="exclude_ship_location_worldwide_list_Oceania[]" type="checkbox" value="FM"><span>Micronesia</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Oceania[]" name="exclude_ship_location_worldwide_list_Oceania[]" type="checkbox" value="NR"><span>Nauru</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Oceania[]" name="exclude_ship_location_worldwide_list_Oceania[]" type="checkbox" value="NC"><span>New Caledonia</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Oceania[]" name="exclude_ship_location_worldwide_list_Oceania[]" type="checkbox" value="NZ"><span>New Zealand</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Oceania[]" name="exclude_ship_location_worldwide_list_Oceania[]" type="checkbox" value="NU"><span>Niue</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Oceania[]" name="exclude_ship_location_worldwide_list_Oceania[]" type="checkbox" value="PW"><span>Palau</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Oceania[]" name="exclude_ship_location_worldwide_list_Oceania[]" type="checkbox" value="PG"><span>Papua New Guinea</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Oceania[]" name="exclude_ship_location_worldwide_list_Oceania[]" type="checkbox" value="SB"><span>Solomon Islands</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Oceania[]" name="exclude_ship_location_worldwide_list_Oceania[]" type="checkbox" value="TO"><span>Tonga</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Oceania[]" name="exclude_ship_location_worldwide_list_Oceania[]" type="checkbox" value="TV"><span>Tuvalu</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Oceania[]" name="exclude_ship_location_worldwide_list_Oceania[]" type="checkbox" value="VU"><span>Vanuatu</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Oceania[]" name="exclude_ship_location_worldwide_list_Oceania[]" type="checkbox" value="WF"><span>Wallis and Futuna</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Oceania[]" name="exclude_ship_location_worldwide_list_Oceania[]" type="checkbox" value="WS"><span>Western Samoa</span></li>
                                        </ul>
                                    </li>
                                    <li class="lfloat" style="padding-right: 15px; width: 40%;">
                                        <input onclick="checkExcludeWorldWideRegion(this);" id="exclude_ship_location_worldwide_list[]" name="exclude_ship_location_worldwide_list[]" type="checkbox" value="Southeast_Asia">
                                        <span class="boldFont" onclick="updateExcludeWorldWideRegion('exclude_ship_location_worldwide_list_Southeast_Asia_ul');">Southeast Asia</span>
                                        <ul class="excludeLocationUL" style="display: none;" id="exclude_ship_location_worldwide_list_Southeast_Asia_ul">
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Southeast_Asia[]" name="exclude_ship_location_worldwide_list_Southeast_Asia[]" type="checkbox" value="BN"><span>Brunei Darussalam</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Southeast_Asia[]" name="exclude_ship_location_worldwide_list_Southeast_Asia[]" type="checkbox" value="KH"><span>Cambodia</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Southeast_Asia[]" name="exclude_ship_location_worldwide_list_Southeast_Asia[]" type="checkbox" value="HK"><span>Hong Kong</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Southeast_Asia[]" name="exclude_ship_location_worldwide_list_Southeast_Asia[]" type="checkbox" value="ID"><span>Indonesia</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Southeast_Asia[]" name="exclude_ship_location_worldwide_list_Southeast_Asia[]" type="checkbox" value="LA"><span>Laos</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Southeast_Asia[]" name="exclude_ship_location_worldwide_list_Southeast_Asia[]" type="checkbox" value="MO"><span>Macau</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Southeast_Asia[]" name="exclude_ship_location_worldwide_list_Southeast_Asia[]" type="checkbox" value="MY"><span>Malaysia</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Southeast_Asia[]" name="exclude_ship_location_worldwide_list_Southeast_Asia[]" type="checkbox" value="PH"><span>Philippines</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Southeast_Asia[]" name="exclude_ship_location_worldwide_list_Southeast_Asia[]" type="checkbox" value="SG"><span>Singapore</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Southeast_Asia[]" name="exclude_ship_location_worldwide_list_Southeast_Asia[]" type="checkbox" value="TW"><span>Taiwan</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Southeast_Asia[]" name="exclude_ship_location_worldwide_list_Southeast_Asia[]" type="checkbox" value="TH"><span>Thailand</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_Southeast_Asia[]" name="exclude_ship_location_worldwide_list_Southeast_Asia[]" type="checkbox" value="VN"><span>Vietnam</span></li>
                                        </ul>
                                    </li>
                                    <li class="lfloat" style="padding-right: 15px; width: 40%; padding-bottom: 8px;">
                                        <input onclick="checkExcludeWorldWideRegion(this);" id="exclude_ship_location_worldwide_list[]" name="exclude_ship_location_worldwide_list[]" type="checkbox" value="South_America">
                                        <span class="boldFont" onclick="updateExcludeWorldWideRegion('exclude_ship_location_worldwide_list_South_America_ul');">South America</span>
                                        <ul class="excludeLocationUL" style="display: none;" id="exclude_ship_location_worldwide_list_South_America_ul">
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_South_America[]" name="exclude_ship_location_worldwide_list_South_America[]" type="checkbox" value="AR"><span>Argentina</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_South_America[]" name="exclude_ship_location_worldwide_list_South_America[]" type="checkbox" value="BO"><span>Bolivia</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_South_America[]" name="exclude_ship_location_worldwide_list_South_America[]" type="checkbox" value="BR"><span>Brazil</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_South_America[]" name="exclude_ship_location_worldwide_list_South_America[]" type="checkbox" value="CL"><span>Chile</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_South_America[]" name="exclude_ship_location_worldwide_list_South_America[]" type="checkbox" value="CO"><span>Colombia</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_South_America[]" name="exclude_ship_location_worldwide_list_South_America[]" type="checkbox" value="EC"><span>Ecuador</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_South_America[]" name="exclude_ship_location_worldwide_list_South_America[]" type="checkbox" value="FK"><span>Falkland Islands (Islas Malvinas)</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_South_America[]" name="exclude_ship_location_worldwide_list_South_America[]" type="checkbox" value="GF"><span>French Guiana</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_South_America[]" name="exclude_ship_location_worldwide_list_South_America[]" type="checkbox" value="GY"><span>Guyana</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_South_America[]" name="exclude_ship_location_worldwide_list_South_America[]" type="checkbox" value="PY"><span>Paraguay</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_South_America[]" name="exclude_ship_location_worldwide_list_South_America[]" type="checkbox" value="PE"><span>Peru</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_South_America[]" name="exclude_ship_location_worldwide_list_South_America[]" type="checkbox" value="SR"><span>Suriname</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_South_America[]" name="exclude_ship_location_worldwide_list_South_America[]" type="checkbox" value="UY"><span>Uruguay</span></li>
                                            <li style="padding-right: 15px;"><input id="exclude_ship_location_worldwide_list_South_America[]" name="exclude_ship_location_worldwide_list_South_America[]" type="checkbox" value="VE"><span>Venezuela</span></li>
                                        </ul>
                                    </li>
                                </ul>
                                <div class="borderBlock" style="width: 100%; position: relative; left: 8px;">
                                    <div>
                                        <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                                            <div style="/*height: 36px;*/ color: #9197a3; font-weight: normal;">
                                                <h1 style="color: #4e5665; font-weight: 700; padding: 12px;/*line-height: 38px;*/ position: relative;"><span style="font-weight: normal;">You have selected: </span><span id="exclude_ship_location_result"></span></h1>
                                            </div>
                                        </div>
                                        <div class="clearfix" style="border-top: 1px solid transparent; padding-left: 12px;">
                                            &nbsp;
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="clear: both; width: 100%; padding-top: 12px;">
                    <div style="float: left; width: 20%; text-align: right;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign_start_datetime');?>: </div>
                    <div style="float: left; width: auto; text-align: left; padding-left: 12px;">
                        <input id="startdate" name="startdate" type="text" size="20" value='' maxlength="50" readonly  />
                    </div>
                </div>
                <div style="clear: both; width: 100%; padding-top: 12px;">
                    <div style="float: left; width: 20%; text-align: right;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign_end_datetime');?>: </div>
                    <div style="float: left; width: auto; text-align: left; padding-left: 12px;">
                        <input type="radio" id="enddate_none" name="enddate_select" <?php if($model->isNewRecord || !isset($model->end_datetime)) echo "checked='checked'";?> value="none_end_date" /><span><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'none');?></span>&nbsp;&nbsp;
                        <input type="radio" id="enddate_select" name="enddate_select" <?php if(!$model->isNewRecord && isset($model->end_datetime)) echo "checked='checked'";?> value="select_end_date" />
                        <input type="text" id="enddate" name="enddate" size="20" maxlength="50" <?php if($model->isNewRecord || !isset($model->end_datetime)) echo "disabled";?>  readonly />
                    </div>
                </div>
                <div style="clear: both; width: 100%; padding-top: 12px; ">
                    <div style="float: left; width: 20%; text-align: right;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign_schedule');?>: </div>
                    <div style="float: left; width: auto; text-align: left; padding-left: 12px;">
                        <div><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'which_schedule_run_campaign');?></div>
                        <div id="schedule_option_all" <?php if(isset($setting['schedule']) && !empty($setting['schedule'])) echo "style='display: none;'";?> ><div class="boldFont"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'all_possible_time');?>&nbsp;<a id="schedule_option_edit_button"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'edit');?></a></div></div>
                        <div id="schedule_option_panel" style="padding-top: 8px; display: <?php if(isset($setting['schedule']) && !empty($setting['schedule'])) echo "block"; else echo "none";?>;">
                            <div style="padding-bottom: 8px;">
                                <span><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign_timezone');?>: </span>
                                <select id="schedule_timezone" name="schedule_timezone">
                                    <option value="UTC-11">UTC-11（MIT - 中途岛标准时间)</option>
                                    <option value=">UTC-10">UTC-10（HST - 夏威夷－阿留申标准时间）</option>
                                    <option value="UTC-9">UTC-9（AKST - 阿拉斯加标准时间）</option>
                                    <option value="UTC-8">UTC-8（PSTA - 太平洋标准时间A）</option>
                                    <option value="UTC-7">UTC-7（MST - 北美山区标准时间）</option>
                                    <option value="UTC-6">UTC-6（CST - 北美中部标准时间）</option>
                                    <option value="UTC-5">UTC-5（EST - 北美东部标准时间）</option>
                                    <option value="UTC-4">UTC-4（AST - 大西洋标准时间）</option>
                                    <option value="UTC-3">UTC-3（SAT - 南美标准时间 )</option>
                                    <option value="UTC-2">UTC-2（BRT - 巴西时间)</option>
                                    <option value="UTC-1">UTC-1（CVT - 佛得角标准时间 )</option>
                                    <option value="UTC">UTC（WET - 欧洲西部时区，GMT - 格林威治标准时间）</option>
                                    <option value="UTC+1">UTC+1（CET - 欧洲中部时区）</option>
                                    <option value="UTC+2">UTC+2（EET - 欧洲东部时区）</option>
                                    <option value="UTC+3">UTC+3（MSK - 莫斯科时区）</option>
                                    <option value="UTC+4">UTC+4（META - 中东时区A )</option>
                                    <option value="UTC+5">UTC+5（METB - 中东时区B )</option>
                                    <option value="UTC+6">UTC+6（BHT - 孟加拉标准时间 )</option>
                                    <option value="UTC+7">UTC+7（MST - 中南半岛标准时间 )</option>
                                    <option value="UTC+8">UTC+8（EAT - 东亚标准时间, 北京标准时间）</option>
                                    <option value="UTC+9">UTC+9（FET- 远东标准时间）</option>
                                    <option value="UTC+10">UTC+10（AEST - 澳大利亚东部标准时间）</option>
                                    <option value="UTC+11">UTC+11（VTT - 瓦努阿图标准时间 )</option>
                                    <option value="UTC+12">UTC+12（PSTB - 太平洋标准时间B）</option>
                                </select>
                                <div style="padding-top: 5px;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'timezone_help');?></div>
                            </div>
                            <div id="schedule_option_value_list">
                                <?php
                                if(isset($setting['schedule']) && !empty($setting['schedule']))
                                {
                                    foreach($setting['schedule'] as $period)
                                    {
                                        $period = (array)$period;
                                        echo "<div style='padding-bottom: 5px;'>".
                                            "<select id='schedule_option_value_day[]' name='schedule_option_value_day[]'>".
                                            "   <option value='all_days' ".($period['day']=='all_days' ? "selected" : "").">".ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'schedule_all_days')."</option>".
                                            "   <option value='monday_to_friday' ".($period['day']=='monday_to_friday' ? "selected" : "").">".ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'schedule_monday_to_friday')."</option>".
                                            "   <option value='monday' ".($period['day']=='monday' ? "selected" : "").">".ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'schedule_monday')."</option>".
                                            "   <option value='tuesday' ".($period['day']=='tuesday' ? "selected" : "").">".ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'schedule_tuesday')."</option>".
                                            "   <option value='wednesday' ".($period['day']=='wednesday' ? "selected" : "").">".ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'schedule_wednesday')."</option>".
                                            "   <option value='thursday' ".($period['day']=='thursday' ? "selected" : "").">".ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'schedule_thursday')."</option>".
                                            "   <option value='friday' ".($period['day']=='friday' ? "selected" : "").">".ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'schedule_friday')."</option>".
                                            "   <option value='saturday' ".($period['day']=='saturday' ? "selected" : "").">".ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'schedule_saturday')."</option>".
                                            "   <option value='sunday' ".($period['day']=='sunday' ? "selected" : "").">".ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'schedule_sunday')."</option>".
                                            "   </select>&nbsp;&nbsp;".
                                            "   <select id='schedule_option_value_from_hour[]' name='schedule_option_value_from_hour[]'>".
                                            "   <option value='00' ".($period['from_hour']=='00' ? "selected" : "").">00</option>".
                                            "   <option value='01' ".($period['from_hour']=='01' ? "selected" : "").">01</option>".
                                            "   <option value='02' ".($period['from_hour']=='02' ? "selected" : "").">02</option>".
                                            "   <option value='03' ".($period['from_hour']=='03' ? "selected" : "").">03</option>".
                                            "   <option value='04' ".($period['from_hour']=='04' ? "selected" : "").">04</option>".
                                            "   <option value='05' ".($period['from_hour']=='05' ? "selected" : "").">05</option>".
                                            "   <option value='06' ".($period['from_hour']=='06' ? "selected" : "").">06</option>".
                                            "   <option value='07' ".($period['from_hour']=='07' ? "selected" : "").">07</option>".
                                            "   <option value='08' ".($period['from_hour']=='08' ? "selected" : "").">08</option>".
                                            "   <option value='09' ".($period['from_hour']=='09' ? "selected" : "").">09</option>".
                                            "   <option value='10' ".($period['from_hour']=='10' ? "selected" : "").">10</option>".
                                            "   <option value='11' ".($period['from_hour']=='11' ? "selected" : "").">11</option>".
                                            "   <option value='12' ".($period['from_hour']=='12' ? "selected" : "").">12</option>".
                                            "   <option value='13' ".($period['from_hour']=='13' ? "selected" : "").">13</option>".
                                            "   <option value='14' ".($period['from_hour']=='14' ? "selected" : "").">14</option>".
                                            "   <option value='15' ".($period['from_hour']=='15' ? "selected" : "").">15</option>".
                                            "   <option value='16' ".($period['from_hour']=='16' ? "selected" : "").">16</option>".
                                            "   <option value='17' ".($period['from_hour']=='17' ? "selected" : "").">17</option>".
                                            "   <option value='18' ".($period['from_hour']=='18' ? "selected" : "").">18</option>".
                                            "   <option value='19' ".($period['from_hour']=='19' ? "selected" : "").">19</option>".
                                            "   <option value='20' ".($period['from_hour']=='20' ? "selected" : "").">20</option>".
                                            "   <option value='21' ".($period['from_hour']=='21' ? "selected" : "").">21</option>".
                                            "   <option value='22' ".($period['from_hour']=='22' ? "selected" : "").">22</option>".
                                            "   <option value='23' ".($period['from_hour']=='23' ? "selected" : "").">23</option>".
                                            "   </select>&nbsp;:&nbsp;".
                                            "   <select id='schedule_option_value_from_minute[]' name='schedule_option_value_from_minute[]'>".
                                            "   <option value='00' ".($period['from_minute']=='00' ? "selected" : "").">00</option>".
                                            "   <option value='15' ".($period['from_minute']=='15' ? "selected" : "").">15</option>".
                                            "   <option value='30' ".($period['from_minute']=='30' ? "selected" : "").">30</option>".
                                            "   <option value='45' ".($period['from_minute']=='45' ? "selected" : "").">45</option>".
                                            "   </select>&nbsp;&nbsp;To&nbsp;&nbsp;".
                                            "   <select id='schedule_option_value_to_hour[]' name='schedule_option_value_to_hour[]'>".
                                            "   <option value='00' ".($period['to_hour']=='00' ? "selected" : "").">00</option>".
                                            "   <option value='01' ".($period['to_hour']=='01' ? "selected" : "").">01</option>".
                                            "   <option value='02' ".($period['to_hour']=='02' ? "selected" : "").">02</option>".
                                            "   <option value='03' ".($period['to_hour']=='03' ? "selected" : "").">03</option>".
                                            "   <option value='04' ".($period['to_hour']=='04' ? "selected" : "").">04</option>".
                                            "   <option value='05' ".($period['to_hour']=='05' ? "selected" : "").">05</option>".
                                            "   <option value='06' ".($period['to_hour']=='06' ? "selected" : "").">06</option>".
                                            "   <option value='07' ".($period['to_hour']=='07' ? "selected" : "").">07</option>".
                                            "   <option value='08' ".($period['to_hour']=='08' ? "selected" : "").">08</option>".
                                            "   <option value='09' ".($period['to_hour']=='09' ? "selected" : "").">09</option>".
                                            "   <option value='10' ".($period['to_hour']=='10' ? "selected" : "").">10</option>".
                                            "   <option value='11' ".($period['to_hour']=='11' ? "selected" : "").">11</option>".
                                            "   <option value='12' ".($period['to_hour']=='12' ? "selected" : "").">12</option>".
                                            "   <option value='13' ".($period['to_hour']=='13' ? "selected" : "").">13</option>".
                                            "   <option value='14' ".($period['to_hour']=='14' ? "selected" : "").">14</option>".
                                            "   <option value='15' ".($period['to_hour']=='15' ? "selected" : "").">15</option>".
                                            "   <option value='16' ".($period['to_hour']=='16' ? "selected" : "").">16</option>".
                                            "   <option value='17' ".($period['to_hour']=='17' ? "selected" : "").">17</option>".
                                            "   <option value='18' ".($period['to_hour']=='18' ? "selected" : "").">18</option>".
                                            "   <option value='19' ".($period['to_hour']=='19' ? "selected" : "").">19</option>".
                                            "   <option value='20' ".($period['to_hour']=='20' ? "selected" : "").">20</option>".
                                            "   <option value='21' ".($period['to_hour']=='21' ? "selected" : "").">21</option>".
                                            "   <option value='22' ".($period['to_hour']=='22' ? "selected" : "").">22</option>".
                                            "   <option value='23' ".($period['to_hour']=='23' ? "selected" : "").">23</option>".
                                            "   </select>&nbsp;:&nbsp;".
                                            "   <select id='schedule_option_value_to_minute[]' name='schedule_option_value_to_minute[]'>".
                                            "   <option value='00' ".($period['to_minute']=='00' ? "selected" : "").">00</option>".
                                            "   <option value='15' ".($period['to_minute']=='15' ? "selected" : "").">15</option>".
                                            "   <option value='30' ".($period['to_minute']=='30' ? "selected" : "").">30</option>".
                                            "   <option value='45' ".($period['to_minute']=='45' ? "selected" : "").">45</option>".
                                            "   </select>&nbsp;&nbsp;".
                                            "   <div id='schedule_option_remove' onclick='removeScheduleOptionDetail(this);' ></div>".
                                            "   </div>";
                                    }
                                }
                                ?>
                            </div>
                            <div><a id="schedule_option_add">+ <?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'add');?></a></div>
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
                    <input type="button" value="<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'cancel');?>" class="greenButton" style="font-size: 12px; line-height: 166%;background: -webkit-linear-gradient(gray, gray); background-color: gray; -webkit-box-shadow: inset 0 1px 1px gray; border-color: gray;" onclick=" if(confirm('Are you sure to cancel and back to AD Campaign list?')) window.location='<?php echo Yii::app()->createAbsoluteUrl("/marketing/advertisement/ADCampaign");?>' " />
                </h1>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<script language="javascript">

    function CheckInputInt(oInput)
    {
        if('' != oInput.value.replace(/\d{1,}\d{0,}/,''))
        {
            oInput.value = oInput.value.match(/\d{1,}\d{0,}/) == null ? '' :oInput.value.match(/\d{1,}\d{0,}/);
        }
    }

    $(function() {
        $("#device_option_edit_button").click(function(){
            $("#device_option_panel").css('display', 'block');
            $("#device_option_all").css('display', 'none');
        });
        $("#language_option_edit_button").click(function(){
            $("#language_option_panel").css('display', 'block');
            $("#language_option_all").css('display', 'none');
        });
        $("#location_option_edit_button").click(function(){
            $("#location_option_panel").css('display', 'block');
            $("#location_option_all").css('display', 'none');
        });
        $("#schedule_option_edit_button").click(function(){
            $("#schedule_option_panel").css('display', 'block');
            $("#schedule_option_all").css('display', 'none');
        });
        $("#location_option_all_value").click(function(){
            if($("#location_option_all_value").prop('checked'))
                $("#location_option_values").css('display', 'none');
            else
                $("#location_option_values").css('display', '');
        });
        $("#location_option_values input:checkbox").click(function(obj, even){
            var str = "";
            for(var i=0;i<$("#location_option_values input:checkbox:checked").length;i++)
            {
                str += $("#location_option_values input:checkbox:checked")[i].nextSibling.innerHTML+", ";
            }
            $("#exclude_ship_location_result").html(str);
        });

        $("#device_os_select").multiselect({
            sortable: false,
            searchable: false,
            close: function(){
                $("#device_os_select_value").val($.map($("#device_os_select").multiselect("getChecked"), function( input ){return input.value;}).toString());
            }
        });
        $("#device_os_select_value").val($.map($("#device_os_select").multiselect("getChecked"), function( input ){return input.value;}).toString());
        $("#device_model_select").multiselect({
            sortable: false,
            searchable: false,
            close: function(){
                $("#device_model_select_value").val($.map($("#device_device_select").multiselect("getChecked"), function( input ){return input.value;}).toString());
            }
        });
        $("#device_model_select_value").val($.map($("#device_model_select").multiselect("getChecked"), function( input ){return input.value;}).toString());

        $("#language_option_all_value").click(function(){
            if($("#language_option_all_value").prop('checked'))
            {
                $("input[id^='language_option_value']").prop('disabled', true);
                $("input[id^='language_option_value']").removeAttr('checked');
            }
            else
            {
                $("input[id^='language_option_value']").removeAttr('disabled');
            }
        });

        $( "#startdate" ).datepicker();
        $( "#startdate" ).datepicker("option", "dateFormat", "yy-mm-dd");
        $( "#startdate" ).datepicker("option", "minDate", "+1D");
        $( "#enddate" ).datepicker();
        $( "#enddate" ).datepicker("option", "dateFormat", "yy-mm-dd");
        $( "#enddate" ).datepicker("option", "minDate", "+2D");
        $("#startdate").val('<?php echo $model->isNewRecord ? date("Y-m-d", time()+60*60*24) : date("Y-m-d", $model->start_datetime);?>');
        $("#enddate").val('<?php echo !$model->isNewRecord && isset($model->end_datetime) ? date("Y-m-d", $model->end_datetime) : '';?>');

        $("#enddate_none").click(function(){
            $("#enddate").val('');
            $("#enddate").prop('disabled', true);
        });
        $("#enddate_select").click(function(){
            $("#enddate").removeAttr('disabled');
        });

        <?php if($model->isNewRecord || !isset($setting['timezone']) || empty($setting['timezone'])): ?>
        $("#schedule_timezone").val('UTC+8');
        <?php else:?>
        $("#schedule_timezone").val('<?php echo $setting['timezone'];?>');
        <?php endif;?>

        $("#schedule_option_add").click(function(){
            var schedule_value = "<div style='padding-bottom: 5px;'>"+
                    "<select id='schedule_option_value_day[]' name='schedule_option_value_day[]'>"+
                    "   <option value='all_days'><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'schedule_all_days');?></option>"+
                    "   <option value='monday_to_friday'><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'schedule_monday_to_friday');?></option>"+
                    "   <option value='monday'><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'schedule_monday');?></option>"+
                    "   <option value='tuesday'><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'schedule_tuesday');?></option>"+
                    "   <option value='wednesday'><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'schedule_wednesday');?></option>"+
                    "   <option value='thursday'><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'schedule_thursday');?></option>"+
                    "   <option value='friday'><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'schedule_friday');?></option>"+
                    "   <option value='saturaday'><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'schedule_saturday');?></option>"+
                    "   <option value='sunday'><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'schedule_sunday');?></option>"+
                    "   </select>&nbsp;&nbsp;"+
                    "   <select id='schedule_option_value_from_hour[]' name='schedule_option_value_from_hour[]'>"+
                    "   <option value='00'>00</option>"+
                    "   <option value='01'>01</option>"+
                    "   <option value='02'>02</option>"+
                    "   <option value='03'>03</option>"+
                    "   <option value='04'>04</option>"+
                    "   <option value='05'>05</option>"+
                    "   <option value='06'>06</option>"+
                    "   <option value='07'>07</option>"+
                    "   <option value='08'>08</option>"+
                    "   <option value='09'>09</option>"+
                    "   <option value='10'>10</option>"+
                    "   <option value='11'>11</option>"+
                    "   <option value='12'>12</option>"+
                    "   <option value='13'>13</option>"+
                    "   <option value='14'>14</option>"+
                    "   <option value='15'>15</option>"+
                    "   <option value='16'>16</option>"+
                    "   <option value='17'>17</option>"+
                    "   <option value='18'>18</option>"+
                    "   <option value='19'>19</option>"+
                    "   <option value='20'>20</option>"+
                    "   <option value='21'>21</option>"+
                    "   <option value='22'>22</option>"+
                    "   <option value='23'>23</option>"+
                    "   </select>&nbsp;:&nbsp;"+
                    "   <select id='schedule_option_value_from_minute[]' name='schedule_option_value_from_minute[]'>"+
                    "   <option value='00'>00</option>"+
                    "   <option value='15'>15</option>"+
                    "   <option value='30'>30</option>"+
                    "   <option value='45'>45</option>"+
                    "   </select>&nbsp;&nbsp;To&nbsp;&nbsp;"+
                    "   <select id='schedule_option_value_to_hour[]' name='schedule_option_value_to_hour[]'>"+
                    "   <option value='00'>00</option>"+
                    "   <option value='01'>01</option>"+
                    "   <option value='02'>02</option>"+
                    "   <option value='03'>03</option>"+
                    "   <option value='04'>04</option>"+
                    "   <option value='05'>05</option>"+
                    "   <option value='06'>06</option>"+
                    "   <option value='07'>07</option>"+
                    "   <option value='08'>08</option>"+
                    "   <option value='09'>09</option>"+
                    "   <option value='10'>10</option>"+
                    "   <option value='11'>11</option>"+
                    "   <option value='12'>12</option>"+
                    "   <option value='13'>13</option>"+
                    "   <option value='14'>14</option>"+
                    "   <option value='15'>15</option>"+
                    "   <option value='16'>16</option>"+
                    "   <option value='17'>17</option>"+
                    "   <option value='18'>18</option>"+
                    "   <option value='19'>19</option>"+
                    "   <option value='20'>20</option>"+
                    "   <option value='21'>21</option>"+
                    "   <option value='22'>22</option>"+
                    "   <option value='23'>23</option>"+
                    "   </select>&nbsp;:&nbsp;"+
                    "   <select id='schedule_option_value_to_minute[]' name='schedule_option_value_to_minute[]'>"+
                    "   <option value='00'>00</option>"+
                    "   <option value='15'>15</option>"+
                    "   <option value='30'>30</option>"+
                    "   <option value='45'>45</option>"+
                    "   </select>&nbsp;&nbsp;"+
                    "   <div id='schedule_option_remove' onclick='removeScheduleOptionDetail(this);' ></div>"+
                    "   </div>";
            $("#schedule_option_value_list").append(schedule_value);
        });

        <?php if(isset($setting['language']) && !empty($setting['language'])): ?>
        $("input[id^='language_option_value']").removeAttr('disabled');
        $("#language_option_all_value").removeAttr('checked');
            <?php $language = explode(',', $setting['language']); foreach($language as $lan):?>
                $("input[id^='language_option_value'][value='<?php echo $lan;?>']").prop('checked', true);
            <?php endforeach;?>
        <?php endif;?>

        <?php if(isset($setting['location']) && !empty($setting['location'])):?>
        $("#location_option_panel").css('display', 'block');
        $("#location_option_all").css('display', 'none');
        $("#location_option_all_value").removeAttr('checked');
        $("#location_option_values").css('display', 'block');
        <?php $locations = explode(',', $setting['location']); foreach($locations as $location):?>
            $($($("input[id^='exclude_ship_location_worldwide_list_'][value='<?php echo $location;?>']")[0].parentNode)[0].parentNode).css('display', '');
            $("input[id^='exclude_ship_location_worldwide_list_'][value='<?php echo $location;?>']").prop('checked', true);
        <?php endforeach;?>
        var str = "";
        for(var i=0;i<$("#location_option_values input:checkbox:checked").length;i++)
        {
            str += $("#location_option_values input:checkbox:checked")[i].nextSibling.innerHTML+", ";
        }
        $("#exclude_ship_location_result").html(str);
        <?php endif;?>
    });

    function updateExcludeWorldWideRegion(obj)
    {
        if($("#"+obj).css('display') == 'none')
            $("#"+obj).css('display', '');
        else
            $("#"+obj).css('display', 'none');
    }

    function checkExcludeWorldWideRegion(obj)
    {
        if($(obj).prop('checked'))
        {
            $("input[id^='exclude_ship_location_worldwide_list_"+$(obj).val()+"'").prop('checked', true);
            $("#exclude_ship_location_worldwide_list_"+$(obj).val().replace(/ /g, '_')+"_ul").css('display', '');
        }
        else
        {
            $("input[id^='exclude_ship_location_worldwide_list_"+$(obj).val()+"'").removeAttr('checked');
            $("#exclude_ship_location_worldwide_list_"+$(obj).val().replace(/ /g, '_')+"_ul").css('display', 'none');
        }
    }

    function removeScheduleOptionDetail(obj)
    {
        $(obj)[0].parentNode.remove();
    }

    function validate()
    {
        var error = "";
        if($("#campaign_name").val() == "")
        {
            error += "Please input AD Campaign name!\n";
        }
        if($("#campaign_budget").val() == "" || parseInt($("#campaign_budget").val()) <= 0)
        {
            error += "Please input AD Campaign Budget!\n";
        }
        if($("#startdate").val() == "")
        {
            error += "Please input AD Campaign Start Date!\n";
        }
        if(error.length>0)
        {
            alert(error);
            return false;
        }

        return true;
    }
</script>