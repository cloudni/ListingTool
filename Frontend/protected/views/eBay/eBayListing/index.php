<?php
/* @var $this EBayListingController */
/* @var $dataProvider CActiveDataProvider */
/* @sites $sites array */
/* @statusList $statusList array*/
/* @currentSite $currentSite string */
/* @currentStatus $currentStatus string */

$this->breadcrumbs=array(
    'eBay Listings',
);

$this->menu=array(
);
?>
<div style="padding: 5px 20px;">
    <h1>eBay Listings</h1>
    <div>
        <?php echo CHtml::label(CHtml::encode('eBay Sites: '), false, array('style'=>'font-weight: bold;'));?>
        <?php
        foreach($sites as $site)
        {
            if($site['selected'])
                echo CHtml::label(CHtml::encode($site['name']).'&nbsp;&nbsp;', false);
            else
                echo CHtml::link($site['name'], $this->createAbsoluteUrl('/eBay/eBayListing/index/eBaySite/'.$site['id'].'/status/'.$currentStatus.'/type/'.$currentType).'/store/'.$currentStore).'&nbsp;&nbsp;';
        } ?>
        <?php echo CHtml::label(CHtml::encode('Listing Status: '), false, array('style'=>'font-weight: bold;'));?>
        <?php
        foreach($statusList as $status)
        {
            if($status['selected'])
                echo CHtml::label(CHtml::encode($status['name']).'&nbsp;&nbsp;', false);
            else
                echo CHtml::link($status['name'], $this->createAbsoluteUrl('/eBay/eBayListing/index/eBaySite/'.$currentSite.'/status/'.$status['name'].'/type/'.$currentType.'/store/'.$currentStore)).'&nbsp;&nbsp;';
        } ?>
        <?php echo CHtml::label(CHtml::encode('Listing Type: '), false, array('style'=>'font-weight: bold;'));
        echo CHtml::dropDownList('listing_type', $currentType, eBayListingTypeCodeType::getListingTypeLabels(), array('empty'=>array('All'=>'All'), 'style'=>'width: 120px;'));
        ?>&nbsp;&nbsp;
        <?php echo CHtml::label(CHtml::encode('Stores: '), false, array('style'=>'font-weight: bold;'));
        echo CHtml::dropDownList('listing_store', (strtolower($currentStore) == 'all' ? NULL : (int)$currentStore), $storeList, array('empty'=>array('All'=>'All'), 'style'=>'width: 120px;'));
        ?>
    </div>

    <div>
        <table width="100%" cellspacing="0" cellpadding="0" style="border-bottom: 1px solid #e5ecf9;" >
            <thead>
            <tr>
                <th>ID</th>
                <th>Store</th>
                <th>eBay Item Id</th>
                <th>eBay Site</th>
                <th>Item Type</th>
                <th style="text-align: center;">Duration</th>
                <th style="text-align: right;">Sold Quantity</th>
                <th>Note</th>
                <th>Action</th>
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
