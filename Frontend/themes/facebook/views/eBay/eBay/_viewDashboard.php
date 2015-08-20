<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/2/27
 * Time: 9:41
 */
Yii::import('application.vendor.*');
require_once 'eBay/reference.php';
?>

<div class="clearfix" style="border-top: 1px solid transparent; border-bottom: 1px solid #e9eaed;">
    <div style="width: 100%; padding: 0px; margin: 0px;">
        <div class="lfloat" style="width: 15%; word-wrap: break-word; padding: 10px 25px 5px 5px;">
            <?php echo CHtml::link($data["name"], CHtml::normalizeUrl($this->createAbsoluteUrl(CHtml::encode("/eBay/eBayListing/index/store/".$data["id"])), array()), array('target'=>'_blank', 'title'=>'', 'style'=>'')); ?>
        </div>
        <div class="lfloat" style="padding-bottom: 8px;">
            <div style="font-size: 12px; height: auto; vertical-align: middle; <?php if(!isset($data["feedbackratingstar"])) echo "padding-top: 10px;";?>">
                <?php if(isset($data["feedbackscore"])):?>
                    <div>
                        <?php echo CHtml::link(CHtml::encode($data["feedbackscore"]), CHtml::normalizeUrl(sprintf(Yii::app()->params['ebay']['feedbackViewURL'], $data['userid'])), array('target'=>'_blank', 'title'=>'', 'style'=>''));?>
                        <span style=""><?php echo CHtml::encode(sprintf("(%1\$.1f%%)", $data["positivefeedbackpercent"])); ?></span>
                        <span><?php if(eBayFeedbackRatingStarCodeType::getFeedbackRatingStarImg25X25($data["feedbackratingstar"])) echo CHtml::image(eBayFeedbackRatingStarCodeType::getFeedbackRatingStarImg25X25($data["feedbackratingstar"]),"", array('width'=>'20px', 'height'=>'20px', 'align'=>'absmiddle', 'style'=>'position: relative; top: 5px;')); ?></span>
                        <img height="16" width="24" border="0" src="/images/help.gif" onmouseout="HideHelp('feedbackdetail_<?php echo $data["name"];?>');" onmouseover="ShowHelp('feedbackdetail_<?php echo $data["name"];?>', '<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'feedback_detail_title');?>', '<?php echo sprintf(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'feedback_detail_content'), $data["positivefeedback"], $data["neutralfeedback"], $data["negativefeedback"]);?>')" style="position: relative; top: 3px;" >
                        <div id="feedbackdetail_<?php echo $data["name"];?>" style="display: none;"></div>
                        <span><?php if($data["storeurl"]) echo CHtml::link(CHtml::image('/images/ebay/iconStoresNW_20x20.gif', '', array('align'=>'absmiddle', 'style'=>'position: relative; top: 5px;')), CHtml::normalizeUrl($data["storeurl"]), array('title'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ebay_store'))) ?></span>
                    </div>
                <?php endif;?>

                <?php if(isset($data["topratedseller"]) || isset($data["topratedprogram"]) ):?>
                    <div style="padding: 5px 0px 0px 0px;">
                        <div class="eBayTopRatedSellerIcon" style="display: inline-block; position: relative; top: -3px;">&nbsp;</div>
                        <?php echo $data["topratedprogram"];?>
                    </div>
                <?php else :?>
                    <div style="height: 5px;">&nbsp;</div>
                <?php endif;?>

                <?php if(isset($data["powersellerstatus"]) || isset($data["sellerfeediscount"])):?>
                    <div>
                        <span><span class="titleColor"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'power_seller_status');?>:&nbsp;</span><?php echo $data["powersellerstatus"];?></span>
                        <span style="<?php if(isset($data["powersellerstatus"])) echo "padding: 0px 5px 0px 5px;border-left: 1px solid #A3A9C2;";?>">
                            <span class="titleColor"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'seller_fee_discount');?>:&nbsp;</span>
                            <span <?php if($data["sellerfeediscount"]>0) echo "class=\"boldFont\"";?>><?php echo sprintf("%1\$.0f%%", $data["sellerfeediscount"]*100);?></span>
                        </span>
                        <span>
                            <?php
                                if(isset($data['sellerdashboardid']))
                                {
                                    $sellerDashboard = eBaySellerDashboard::model()->findByPk($data['sellerdashboardid']);
                                    $alerts = $sellerDashboard->getEntityAttributeValueByCodeWithAllChildren('PowerSellerStatus->Alert');
                                    if(isset($alerts))
                                    {
                                        if(array_key_exists("Text", $alerts) && array_key_exists("Severity", $alerts))
                                        {
                                            $img = 'success';
                                            $title = 'Information';
                                            if(isset($alerts["Severity"]) && ($alerts["Severity"] == eBaySellerDashboardAlertSeverityCodeType::Warning || $alerts["Severity"] == eBaySellerDashboardAlertSeverityCodeType::StrongWarning))
                                            {
                                                $img = 'error';$title = $alerts["Severity"];
                                            }
                                            echo "<img height='18' width='18' border='0' src='/images/$img.gif' onmouseout=\"HideHelp('powersellerstatus_alert_{$data["name"]}');\" onmouseover=\"ShowHelp('powersellerstatus_alert_{$data["name"]}', 'Alert', '{$alerts["Text"]}')\" style='position: relative; top: 3px;' >
                                            <div id=\"powersellerstatus_alert_{$data["name"]}\" style='display: none;'></div>";
                                        }
                                        else
                                        {
                                            $alertList = array(eBaySellerDashboardAlertSeverityCodeType::Informational=>array(), eBaySellerDashboardAlertSeverityCodeType::Warning=>array());
                                            foreach($alerts as $alert)
                                            {
                                                if($alert['Severity'] == eBaySellerDashboardAlertSeverityCodeType::CustomCode || $alert['Severity'] == eBaySellerDashboardAlertSeverityCodeType::Informational)
                                                    $alertList[eBaySellerDashboardAlertSeverityCodeType::Informational][] = $alert['Text'];
                                                if($alert['Severity'] == eBaySellerDashboardAlertSeverityCodeType::Warning || $alert['Severity'] == eBaySellerDashboardAlertSeverityCodeType::StrongWarning)
                                                    $alertList[eBaySellerDashboardAlertSeverityCodeType::Warning][] = $alert['Text'];
                                            }
                                            if(count($alertList[eBaySellerDashboardAlertSeverityCodeType::Informational])>0)
                                            {
                                                $content = ""; $index = 1;
                                                foreach($alertList[eBaySellerDashboardAlertSeverityCodeType::Informational] as $text)
                                                {
                                                    $content .= $index.". ".$text."<br />";
                                                    $index++;
                                                }
                                                echo "<img height='18' width='18' border='0' src='/images/success.gif' onmouseout=\"HideHelp('powersellerstatus_alert_info_{$data["name"]}');\" onmouseover=\"ShowHelp('powersellerstatus_alert_info_{$data["name"]}', 'Information', '{$content}')\" style='position: relative; top: 3px;' >
                                                <div id=\"powersellerstatus_alert_info_{$data["name"]}\" style='display: none;'></div>";
                                            }
                                            if(count($alertList[eBaySellerDashboardAlertSeverityCodeType::Warning])>0)
                                            {
                                                $content = ""; $index = 1;
                                                foreach($alertList[eBaySellerDashboardAlertSeverityCodeType::Warning] as $text)
                                                {
                                                    $content .= $index.". ".$text."<br />";
                                                    $index++;
                                                }
                                                echo "<img height='18' width='18' border='0' src='/images/success.gif' onmouseout=\"HideHelp('powersellerstatus_alert_warning_{$data["name"]}');\" onmouseover=\"ShowHelp('powersellerstatus_alert_warning_{$data["name"]}', 'Warning', '{$content}')\" style='position: relative; top: 3px;' >
                                                <div id=\"powersellerstatus_alert_warning_{$data["name"]}\" style='display: none;'></div>";
                                            }
                                        }
                                    }
                                }
                            ?>
                        </span>
                    </div>
                <?php endif;?>

                <?php if(isset($data["sellerdashboardid"])):?>
                    <div style="padding-top: 5px;">
                        <span class="titleColor"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ebay_store_performance');?>:&nbsp;</span>
                        <span><?php
                            if(!empty($performances))
                        if(isset($data['sellerdashboardid']))
                        {
                            $sellerDashboard = eBaySellerDashboard::model()->findByPk($data['sellerdashboardid']);
                            $performances = $sellerDashboard->getEntityAttributeValueByCodeWithAllChildren('Performance');
                            if(!array_key_exists("Site", $performances))
                            {
                                $index = 0;
                                foreach($performances as $performance)
                                {
                                    if(gettype($performance['Site']) === 'array')
                                    {
                                        foreach($performance['Site'] as $site) echo "<div class=\"nationalFlag ".strtolower($site)."Flag\"></div>".'&nbsp;';
                                    }
                                    else
                                    {
                                        echo "<div class=\"nationalFlag ".strtolower($performance['Site'])."Flag\"></div>".'&nbsp;';
                                    }
                                    echo $performance['Status'];
                                    if(isset($performance['Alert']))
                                    {
                                        if(gettype($performance['Alert']) === 'array' && array_key_exists("Text", $performance['Alert']) && array_key_exists("Severity", $performance['Alert']))
                                        {
                                            $img = 'success';
                                            $title = 'Information';
                                            if(isset($performance['Alert']["Severity"]) && ($performance['Alert']["Severity"] == eBaySellerDashboardAlertSeverityCodeType::Warning || $performance['Alert']["Severity"] == eBaySellerDashboardAlertSeverityCodeType::StrongWarning))
                                            {
                                                $img = 'error';$title = $performance['Alert']["Severity"];
                                            }
                                            echo "<img height='18' width='18' border='0' src='/images/$img.gif' onmouseout=\"HideHelp('performance_{$index}_alert_{$data["name"]}');\" onmouseover=\"ShowHelp('performance_{$index}_alert_{$data["name"]}', '$title', '{$performance['Alert']["Text"]}')\" style='position: relative; top: 3px;' >
                                            <div id=\"performance_{$index}_alert_{$data["name"]}\" style='display: none;'></div>";
                                        }
                                    }
                                    echo '<span style="padding-right: 15px;"></span>';
                                    $index++;
                                }
                            }
                            else
                            {
                                if(gettype($performances['Site']) === 'array')
                                {
                                    foreach($performances['Site'] as $site) echo "<div class=\"nationalFlag ".strtolower($site)."Flag\"></div>".'&nbsp;';
                                }
                                else
                                {
                                    echo "<div class=\"nationalFlag ".strtolower($performances['Site'])."Flag\"></div>".'&nbsp;';
                                }
                                echo $performances['Status'];
                                if(isset($performances['Alert']))
                                {
                                    if(gettype($performances['Alert']) === 'array' && array_key_exists("Text", $performances['Alert']) && array_key_exists("Severity", $performances['Alert']))
                                    {
                                        $img = 'success';
                                        $title = 'Information';
                                        if(isset($performances['Alert']["Severity"]) && ($performances['Alert']["Severity"] == eBaySellerDashboardAlertSeverityCodeType::Warning || $performances['Alert']["Severity"] == eBaySellerDashboardAlertSeverityCodeType::StrongWarning))
                                        {
                                            $img = 'error';$title = $performances['Alert']["Severity"];
                                        }
                                        echo "<img height='18' width='18' border='0' src='/images/$img.gif' onmouseout=\"HideHelp('performance_alert_{$data["name"]}');\" onmouseover=\"ShowHelp('performance_alert_{$data["name"]}', '$title', '{$performances['Alert']["Text"]}')\" style='position: relative; top: 3px;' >
                                            <div id=\"performance_alert_{$data["name"]}\" style='display: none;'></div>";
                                    }
                                }
                                echo '<span style="padding-right: 15px;"></span>';
                            }
                        }
                        ?></span>
                    </div>
                <?php endif;?>

                <?php if(isset($data["ebaysubscription"])):?>
                    <div style="padding-top: 5px;"><span class="titleColor"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ebay_store_subscription');?>:&nbsp;</span><?php echo $data["ebaysubscription"];?></div>
                <?php endif;?>

            </div>
        </div>
    </div>
</div>