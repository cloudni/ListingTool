<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/2/9
 * Time: 16:19
 */
/* @var $this EBayListingController */
/* @var $data eBayListing */
Yii::import('application.vendor.*');
require_once 'eBay/reference.php';
?>
<tr>
    <td>
        <table width="100%" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td rowspan="2" width="20%" valign="middle"><?php echo CHtml::link($data["name"], CHtml::normalizeUrl($this->createAbsoluteUrl(CHtml::encode("/eBay/eBayListing/index/store/".$data["id"])), array()), array('target'=>'_blank', 'title'=>'', 'style'=>'position: relative; top: -7px;')); ?></td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($data["feedbackscore"]), CHtml::normalizeUrl(sprintf(Yii::app()->params['ebay']['feedbackViewURL'], $data['userid'])), array('target'=>'_blank', 'title'=>'', 'style'=>'position: relative; top: -7px;'));?>
                        <span style="position: relative; top: -7px;"><?php echo CHtml::encode(sprintf("(%1\$.1f%%)", $data["positivefeedbackpercent"])); ?></span>
                        <?php if(eBayFeedbackRatingStarCodeType::getFeedbackRatingStarImg25X25($data["feedbackratingstar"])) echo CHtml::image(eBayFeedbackRatingStarCodeType::getFeedbackRatingStarImg25X25($data["feedbackratingstar"]),"", array('width'=>'25px', 'height'=>'25px')); ?>
                        <?php if($data["userid"]) echo CHtml::link(CHtml::image("/images/ebay/iconStoresNW_20x20.gif", "", array('alt'=>'eBay Store', 'style'=>'position: relative; top: 5px;')), CHtml::normalizeUrl($data['storeurl']), array('target'=>'_blank', 'title'=>'eBay Store', 'style'=>'position: relative; top: -7px;'));?>
                    </td>
                </tr>
                <tr>
                    <td>eeeee</td>
                </tr>
            </tbody>
        </table>
    </td>
</tr>