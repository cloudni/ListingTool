<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/6/2
 * Time: 10:43
 */
/* @var $tdis eBayListingController */
/* @var $data eBayListing */
?>

<tr>
    <td><?php echo CHtml::link(CHtml::encode($data["id"]), array('view', 'id'=>$data["id"])); ?></td>
    <td><?php echo CHtml::link($data["ebay_listing_id"], CHtml::normalizeUrl($data["viewitemurl"]), array('target'=>'_blank', 'title'=>$data["title"]));?></td>
    <td><span title="<?php echo CHtml::encode($data["title"]); ?>"><?php echo CHtml::encode(substr($data["title"], 0, 10).'...'); ?></span></td>
    <td><?php echo CHtml::encode($data["storename"]); ?></td>
    <td><?php echo CHtml::encode($data["companyname"]); ?></td>
    <td><?php echo CHtml::encode(eBaySiteIdCodeType::getSiteIdCodeTypeText($data["site_id"])); ?></td>
    <td><?php echo CHtml::encode($data['listingtype']); ?></td>
    <td><?php echo CHtml::encode($data['listingtstatus']); ?></td>
    <td style="text-align: right;"><?php echo CHtml::encode($data['soldquantity']); ?></td>
    <td><?php /*echo CHtml::link(CHtml::encode("Edit"), array('update', 'id'=>$data->id)); */?><!--&nbsp;|&nbsp;--><?php /*echo CHtml::linkButton('Delete',array(
            'submit'=>array('delete','id'=>$data->id),
            'confirm'=>"Are you sure to delete tdis attribute set?",
        )); */?></td>
</tr>