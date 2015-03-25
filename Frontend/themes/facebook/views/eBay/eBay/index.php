<?php
/* @var $this EBayController */

$this->breadcrumbs=array(
	'eBay',
);

$this->menu=array(
    array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'list_ebay_items'), 'url'=>array('/eBay/eBayListing')),
	array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'bulk_update_ebay_listing'), 'url'=>array('/eBay/eBayListing/bulkUpdate')),
);
?>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
	<div class="borderBlock">
		<div>
			<div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
				<div style="height: 36px; color: #9197a3; font-weight: normal;">
					<h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'store_dashboard');?></h1>
				</div>
			</div>
			<?php $this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$dataProvider,
				'itemView'=>'_viewDashboard',
			)); ?>
        </div>
	</div>
</div>
