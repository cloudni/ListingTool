<?php
/* @var $this EBayListingController */
/* @var $data eBayListing */
Yii::import('application.vendor.*');
require_once 'eBay/reference.php';
?>

<tr>
    <td><?php echo CHtml::link(CHtml::encode($data["id"]), array('view', 'id'=>$data["id"])); ?></td>
    <td><?php echo CHtml::encode($data["storename"]); ?></td>
    <td><?php echo CHtml::link($data["ebay_listing_id"], CHtml::normalizeUrl($data['viewitemurl']), array('target'=>'_blank', 'title'=>$data['title']));?></td>
    <td><?php echo CHtml::encode(eBaySiteIdCodeType::getSiteIdCodeTypeText($data["site_id"])); ?></td>
    <td><?php echo CHtml::encode($data['listingtype']); ?></td>
    <td style="text-align: center;"><?php echo CHtml::encode($data['listingduration']); ?></td>
    <td style="text-align: right;"><?php echo CHtml::encode($data['soldquantity']); ?></td>
    <td><?php echo CHtml::encode($data['note']); ?></td>
    <td>&nbsp;</td>
</tr>
