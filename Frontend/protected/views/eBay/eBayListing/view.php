<?php
/* @var $this EBayListingController */
/* @var $model eBayListing */

Yii::import('application.vendor.eBay.*');
require_once 'reference.php';

$this->breadcrumbs=array(
	'eBay Listings'=>array('index'),
	$model->ebay_listing_id,
);

$this->menu=array(
	array('label'=>'List eBayListing', 'url'=>array('index')),
	array('label'=>'Update eBayListing', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete eBayListing', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>View eBayListing <?php echo CHtml::link($model->ebay_listing_id, CHtml::normalizeUrl($model->getEntityAttributeValue("ListingDetails->ViewItemURL")), array('target'=>'_blank', 'title'=>'View item in eBay')); ?></h1>

<?php
$PictureURL = $model->getEntityAttributeValue("PictureDetails->PictureURL");
$pictureShow = "";
if(gettype($PictureURL) == 'array')
{
    foreach($PictureURL as $picture)
    $pictureShow .= "<img src='$picture' width='70px' height='70px' />";
}
elseif(!empty($PictureURL))
{
    $pictureShow = "<img src='$PictureURL' width='70px' height='70px' />";
}
if(empty($pictureShow)) $pictureShow = '&nbsp;';
$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
        array(
		    'name'=>'store_id',
            'value'=>$model->Store->name,
        ),
        array(
            'label'=>$model->getEntityAttributeLabel("Title"),
            'value'=>$model->getEntityAttributeValue("Title"),
        ),
        array(
            'label'=>$model->getEntityAttributeLabel("SubTitle"),
            'value'=>$model->getEntityAttributeValue("SubTitle"),
        ),
        array(
		    'label'=>'Site',
            'value'=>$model->getEntityAttributeValue("Site"),
        ),
        array(
            'label'=>"Primary Category",
            'value'=>$model->getEntityAttributeValue("PrimaryCategory->CategoryName"),
        ),
        array(
            'label'=>"Secondary Category",
            'value'=>$model->getEntityAttributeValue("SecondaryCategory->CategoryName"),
        ),
        array(
            'label'=>$model->getEntityAttributeLabel("ListingDetails->StartTime"),
            'value'=>date('m/d/Y h:i:s', $model->getEntityAttributeValue("ListingDetails->StartTime")),
        ),
        array(
		    'label'=>'Last Updated Time',
            'value'=>CHtml::encode(date("m/d/Y", $model->update_time_utc)),
        ),
        array(
            'label'=>$model->getEntityAttributeLabel("ListingDuration"),
            'value'=>$model->getEntityAttributeValue("ListingDuration"),
        ),
        array(
            'label'=>$model->getEntityAttributeLabel("SellingStatus->ListingStatus"),
            'value'=>$model->getEntityAttributeValue("SellingStatus->ListingStatus"),
        ),
        array(
            'label'=>$model->getEntityAttributeLabel("SellingStatus->QuantitySold"),
            'value'=>$model->getEntityAttributeValue("SellingStatus->QuantitySold"),
        ),
        array(
            'label'=>$model->getEntityAttributeLabel("PictureDetails->PictureURL"),
            'value'=>$pictureShow,
            'type'=>'html',
        ),
        'note',
	),
)); ?>

