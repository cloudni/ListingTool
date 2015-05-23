<?php
/* @var $this WishListingController */

$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'wish_listing'),
);
?>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <div style="padding: 5px; padding-left: 12px;">
                        <?php echo CHtml::label(CHtml::encode(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'listing_status').': '), false, array('style'=>'font-weight: bold;'));
                        echo CHtml::dropDownList('currentStatus', $currentStatus, $statusList, array('empty'=>array('All'=>'All'), 'style'=>'width: 120px;'));
                        ?>&nbsp;&nbsp;
                        <?php echo CHtml::label(CHtml::encode(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'stores').': '), false, array('style'=>'font-weight: bold;'));
                        echo CHtml::dropDownList('currentStore', (strtolower($currentStore) == 'all' ? NULL : (int)$currentStore), $storeList, array('empty'=>array('All'=>'All'), 'style'=>'width: 120px;'));
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
                                <th style=" padding-left: 12px;">ID</th>
                                <th><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'stores');?></th>
                                <th><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'wish_listing_id');?></th>
                                <th><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'name');?></th>
                                <th>Parent SKU</th>
                                <th><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'status');?></th>
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
    var url = '<?php echo $this->createAbsoluteUrl("/Wish/WishListing/index/", array('currentStatus'=>'replaceStatus', 'currentStore'=>'replaceStore'));?>';
    $(function(){
        $("#currentStatus").change(function(){
            location.href = url.replace('replaceStatus', $("#currentStatus").val()).replace('replaceStore', $("#currentStore").val());
        });

        $("#currentStore").change(function(){
            location.href = url.replace('replaceStatus', $("#currentStatus").val()).replace('replaceStore', $("#currentStore").val());
        });
    });
</script>
