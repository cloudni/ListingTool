<?php
/* @var $this StoreController */
/* @var $model Store */
Yii::import('application.vendor.eBay.*');
require_once("reference.php");

$this->pageTitle=Yii::app()->name . ' - '.ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'store_view_menu');
$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'store_title')=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'store_list_menu'), 'url'=>array('index')),
	array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'store_create_menu'), 'url'=>array('create')),
	array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'store_update_menu'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'store_delete_menu'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('models/Store','Are you sure you want to delete this item?'))),
);
?>

<style>
    table.detail-view th, table.detail-view td
    {
        font-size: 12px;
    }
</style>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;"><?php echo $model->name; ?></h1>
                </div>
            </div>
            <div style="display: block;">
                <?php
                $attributes = array(
                    //'id',
                    'name',
                    array(
                        'name' => 'platform',
                        'value' => CHtml::encode($model->getPlatformText())
                    ),
                    array(
                        'name' => 'is_active',
                        'value' => CHtml::encode($model->getIsActiveText())
                    ),
                    array(
                        'name' => CHtml::encode($model->getAttributeLabel('last_listing_sync_time_utc')),
                        'value' => CHtml::encode(date("Y/m/d h:i:sa", $model->last_listing_sync_time_utc))
                    )
                );

                if($model->platform==Store::PLATFORM_EBAY)
                {
                    $attributes[] = array(
                        'name'=>CHtml::encode(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ebay_sites')),
                        'value'=>CHtml::encode(eBaySiteIdCodeType::getSiteIdCodeTypeText($model->ebay_site_code)),
                    );
                    if($model->is_active == Store::ACTIVE_YES)
                    {
                        $attributes[] = array(
                            'name'=>CHtml::encode(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ebay_token_expired_date')),
                            'value'=>CHtml::encode(date("Y/m/d h:i:sa", $model->HardExpirationTime)),
                        );
                    }
                    $attributes[] = array(
                        'name' => '',
                        'value' => CHtml::link(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ebay_token_renew_link_text'), $this->createAbsoluteUrl("store/getToken",array('id'=>$model->id))),
                        'type'=>'html',
                    );
                }

                if($model->platform==Store::PLATFORM_WISH)
                {
                    $attributes[] = array(
                        'name'=>CHtml::encode(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'wish_api_key')),
                        'value'=>CHtml::encode(substr($model->wish_token, 0, 10).'...'),
                    );
                }

                $this->widget('zii.widgets.CDetailView', array(
                    'data'=>$model,
                    'attributes'=>$attributes
                )); ?>
            </div>
        </div>
    </div>
</div>




