<?php
/* @var $this eBayListingController */
/* @var $dataProvider CActiveDataProvider */
/* @var $coompany_id int */
/* @var $store_id int */
/* @var $listingStatus string */
/* @var $listingType string */
/* @var $siteId int */
/* @var $searchKeyword string */
/* @var $id_page int */

Yii::import('application.vendor.eBay.*');
require_once 'reference.php';

$this->breadcrumbs=array(
	'eBay Listing',
);
?>
<h1>eBay Listing</h1>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'ebay_listing_select_form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
)); ?>
<div>
    <div class="row">
        <?php echo CHtml::textField("search_keyword", $searchKeyword, array("size"=>60,));?>
        <?php echo CHtml::submitButton("Search"); ?>
    </div>
    <div class="row" style="padding-top: 7px;">
        <span>Company: </span>
        <?php echo CHtml::dropDownList("company_select", $company_id, CHtml::listData(Company::model()->findAll(), "id", "name"), array("empty"=>"All Company"));?>
        <span>Store: </span>
        <?php echo CHtml::dropDownList("store_select", $store_id, CHtml::listData(Store::model()->findAll(""), "id", "name"), array("empty"=>"All Store"));?>
    </div>
    <div class="row" style="padding-top: 7px;">
        <span>eBay Site: </span>
        <?php echo CHtml::dropDownList("ebay_site_select", $siteId, eBaySiteIdCodeType::getSiteIdCodeTypeOptions(), array("empty"=>array("all"=>"All eBay Sites")));?>
        <span>Listing Status: </span>
        <?php echo CHtml::dropDownList("listing_status_select", $listingStatus, eBayListingStatusCodeType::getStatusOptions(), array("empty"=>"All Status"));?>
        <span>Listing Type: </span>
        <?php echo CHtml::dropDownList("listing_type_select", $listingType, eBayListingTypeCodeType::getListingTypeOptions(), array("empty"=>"All Type"));?>
    </div>
    <div class="row">
        <?php echo CHtml::hiddenField("id_page", 1, array("size"=>20));?>
    </div>
</div>
<?php $this->endWidget(); ?>

<div>
    <table width="100%" cellspacing="0" cellpadding="0" style="border: 1px solid gray;" >
        <tr>
            <th>ID</th>
            <th>eBay Item ID</th>
            <th>Title</th>
            <th>Store</th>
            <th>Company</th>
            <th>Site</th>
            <th>Listing Status</th>
            <th>Listing Type</th>
            <th>Sold</th>
            <th>Action</th>
        </tr>
        <?php $this->widget('zii.widgets.CListView', array(
            'dataProvider'=>$dataProvider,
            'itemView'=>'_view',
        )); ?>
    </table>
</div>

<script>
    $(function(){
        $("div[class='pager'] a").click(function(event){
            var currentPage = parseInt($("li[class='page selected'] a").html());
            var targetPage = 0;
            if(parseInt($(event.toElement).html()) > 0)
            {
                if(currentPage == parseInt($(event.toElement).html())) return false;
                targetPage = parseInt($(event.toElement).html());
            }
            else if($(event.toElement).html() == "&lt; Previous")
            {
                if(currentPage == 1) return false;
                targetPage = currentPage - 1;
            }
            else if($(event.toElement).html() == "Next &gt;")
            {
                targetPage = currentPage + 1;
            }

            if(targetPage>0)
            {
                $("#id_page").val(targetPage);
                $("#ebay_listing_select_form").submit();
            }

            return false;
        });
    });
</script>
