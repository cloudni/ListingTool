<?php
/* @var $this EBayListingController */
/* @var $dataProvider CActiveDataProvider */
/* @sites $sites array */
/* @statusList $statusList array*/
/* @currentSite $currentSite string */
/* @currentStatus $currentStatus string */

$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ebay_listing'),
);

$this->menu=array(
);
?>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <div style="padding: 5px;">
                        <?php echo CHtml::label(CHtml::encode(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ebay_sites').': '), false, array('style'=>'font-weight: bold;'));?>
                        <?php
                        foreach($sites as $site)
                        {
                            if($site['selected'])
                                echo CHtml::label(CHtml::encode($site['name']).'&nbsp;&nbsp;', false);
                            else
                                echo CHtml::link($site['name'], $this->createAbsoluteUrl('/eBay/eBayListing/index/eBaySite/'.$site['id'].'/status/'.$currentStatus.'/type/'.$currentType).'/store/'.$currentStore).'&nbsp;&nbsp;';
                        } ?>
                        <?php echo CHtml::label(CHtml::encode(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'listing_status').': '), false, array('style'=>'font-weight: bold;'));?>
                        <?php
                        foreach($statusList as $status)
                        {
                            if($status['selected'])
                                echo CHtml::label(CHtml::encode(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,strtolower($status['name']))).'&nbsp;&nbsp;', false);
                            else
                                echo CHtml::link(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,strtolower($status['name'])), $this->createAbsoluteUrl('/eBay/eBayListing/index/eBaySite/'.$currentSite.'/status/'.$status['name'].'/type/'.$currentType.'/store/'.$currentStore)).'&nbsp;&nbsp;';
                        } ?>
                        <?php echo CHtml::label(CHtml::encode(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'listing_types').': '), false, array('style'=>'font-weight: bold;'));
                        echo CHtml::dropDownList('listing_type', $currentType, eBayListingTypeCodeType::getListingTypeLabels(), array('empty'=>array('All'=>'All'), 'style'=>'width: 120px;'));
                        ?>&nbsp;&nbsp;
                        <?php echo CHtml::label(CHtml::encode(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'stores').': '), false, array('style'=>'font-weight: bold;'));
                        echo CHtml::dropDownList('listing_store', (strtolower($currentStore) == 'all' ? NULL : (int)$currentStore), $storeList, array('empty'=>array('All'=>'All'), 'style'=>'width: 120px;'));
                        ?>
                    </div>
                </div>
            </div>
            <div class="clearfix" style="border-top: 1px solid transparent;">
                <div style="width: 100%; padding: 0px; margin: 0px;">
                    <div class="container">
                        <table width="100%" cellspacing="0" cellpadding="0" style="border-bottom: 1px solid #e5ecf9;" >
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'stores');?></th>
                                <th><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ebay_item_id');?></th>
                                <th><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ebay_sites');?></th>
                                <th><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'listing_types');?></th>
                                <th style="text-align: center;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'listing_duration');?></th>
                                <th style="text-align: right;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'sold_quantity');?></th>
                                <th><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'note');?></th>
                                <th><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'action');?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $this->widget('zii.widgets.CListView', array(
                                'dataProvider'=>$dataProvider,
                                'itemView'=>'_view',
                                //'sortableAttributes'=>array('id','soldquantity'),
                            )); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        $("#listing_type").change(function(){
            location.href = '<?php echo $this->createAbsoluteUrl("/eBay/eBayListing/index/eBaySite/$currentSite/status/$currentStatus/type");?>'+'/'+$("#listing_type").val()+'/store/'+$("#listing_store").val();
        });

        $("#listing_store").change(function(){
            location.href = '<?php echo $this->createAbsoluteUrl("/eBay/eBayListing/index/eBaySite/$currentSite/status/$currentStatus/type");?>'+'/'+$("#listing_type").val()+'/store/'+$("#listing_store").val();
        });
    });
</script>
