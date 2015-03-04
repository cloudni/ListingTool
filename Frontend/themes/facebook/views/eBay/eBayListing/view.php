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
	array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'list_ebay_items'), 'url'=>array('index')),
	//array('label'=>'Update eBayListing', 'url'=>array('update', 'id'=>$model->id)),
	//array('label'=>'Delete eBayListing', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ebay_listing');?>&nbsp;<?php echo CHtml::link($model->ebay_listing_id, CHtml::normalizeUrl($model->getEntityAttributeValue("ListingDetails->ViewItemURL")), array('target'=>'_blank', 'title'=>'View item in eBay')); ?></h1>
                </div>
            </div>
            <div style="display: block;">
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
                            'name'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'stores'),
                            'value'=>$model->Store->name,
                        ),
                        array(
                            'label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'title'),
                            'value'=>$model->getEntityAttributeValue("Title"),
                        ),
                        array(
                            'label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'sub_title'),
                            'value'=>$model->getEntityAttributeValue("SubTitle"),
                        ),
                        array(
                            'label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ebay_sites'),
                            'value'=>$model->getEntityAttributeValue("Site"),
                        ),
                        array(
                            'label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'primary_category'),
                            'value'=>$model->getEntityAttributeValue("PrimaryCategory->CategoryName"),
                        ),
                        array(
                            'label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'secondary_category'),
                            'value'=>$model->getEntityAttributeValue("SecondaryCategory->CategoryName"),
                        ),
                        array(
                            'label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'start_time'),
                            'value'=>date('m/d/Y h:i:s', $model->getEntityAttributeValue("ListingDetails->StartTime")),
                        ),
                        array(
                            'label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'last_updated_time'),
                            'value'=>CHtml::encode(date("m/d/Y", $model->update_time_utc)),
                        ),
                        array(
                            'label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'listing_duration'),
                            'value'=>$model->getEntityAttributeValue("ListingDuration"),
                        ),
                        array(
                            'label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'listing_status'),
                            'value'=>$model->getEntityAttributeValue("SellingStatus->ListingStatus"),
                        ),
                        array(
                            'label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'sold_quantity'),
                            'value'=>$model->getEntityAttributeValue("SellingStatus->QuantitySold"),
                        ),
                        array(
                            'label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'item_pictures'),
                            'value'=>$pictureShow,
                            'type'=>'html',
                        ),
                        'note',
                    ),
                )); ?>
            </div>
        </div>
    </div>
</div>


