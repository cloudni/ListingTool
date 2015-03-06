<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
Yii::app()->clientScript->registerCoreScript('jquery');
?>

<style>
    #page { background-color: #e9eaed;border: none; }
</style>

<div class="container clearfix">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="position: relative; float: right;">
                    <a style="color: #3b5998; font-size: 11px; line-height: 38px; position: relative; margin-right: 10px; padding-right: 5px;" href="">See All</a>
                </div>
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; text-transform: uppercase; line-height: 38px; position: relative;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'user_status');?></h1>
                </div>
            </div>
            <div class="clearfix" style="border-top: 1px solid transparent;">
                <div style="width: 100%; padding: 0px; margin: 0px;">
                    <div class="lfloat">
                        <div style="background-image: url(/themes/facebook/images/201410080952.jpg); background-repeat: no-repeat; background-size: 1000%; background-position: -405px -77px; height: 100px; width: 100px;">&nbsp;</div>
                    </div>
                    <div class="lfloat">
                        <div style="font-size: 12px; height: 20px; vertical-align: middle; padding-top: 10px;">1.
                            <?php $userCount = User::model()->count("company_id=:company_id", array(":company_id"=>Yii::app()->session['user']->company_id));?>
                            <?php echo CHtml::encode(sprintf(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'total_user_count'), $userCount));?>
                        </div>
                        <div style="font-size: 12px; height: 20px; vertical-align: middle; padding-top: 10px;">2.
                            <?php echo CHtml::link(CHtml::encode(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'create_more_user_account')), array("/user/create"), array());?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'or');?>&nbsp;
                            <?php echo CHtml::link(CHtml::encode(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'manage_user_account')), array("/user"), array());?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="position: relative; float: right;">
                    <a style="color: #3b5998; font-size: 11px; line-height: 38px; position: relative; margin-right: 10px; padding-right: 5px;" href="">See All</a>
                </div>
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; text-transform: uppercase; line-height: 38px; position: relative;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'store_status');?></h1>
                </div>
            </div>
            <div class="clearfix" style="border-top: 1px solid transparent;">
                <div style="width: 100%; padding: 0px; margin: 0px;">
                    <div class="lfloat">
                        <div style="background-image: url(/themes/facebook/images/201410080952.jpg); background-repeat: no-repeat; background-size: 1000%; background-position: -50px -607px; height: 100px; width: 100px;">&nbsp;</div>
                    </div>
                    <div class="lfloat">
                        <div style="font-size: 12px; height: 20px; vertical-align: middle; padding-top: 10px;">1.
                            <?php $storeCount = Store::model()->count("company_id=:company_id", array(":company_id"=>Yii::app()->session['user']->company_id));?>
                            <?php $activeStoreCount = Store::model()->count("company_id=:company_id and is_active=:is_active", array(":company_id"=>Yii::app()->session['user']->company_id, ':is_active'=>Store::ACTIVE_YES));?>
                            <?php echo CHtml::encode(sprintf(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'total_store_count'), $storeCount, $activeStoreCount));?>
                        </div>
                        <div style="font-size: 12px; height: 20px; vertical-align: middle; padding-top: 10px;">2.
                            <?php $stores = Yii::app()->db->createCommand("SELECT count(id) as total, platform, is_active FROM lt_store where company_id = ".Yii::app()->session['user']->company_id." group by platform, is_active order by platform, is_active;")->queryAll();?>
                            <?php $platform = null;?>
                            <?php foreach($stores as $raw):?>
                                <?php
                                    if(!isset($platform) || $platform != $raw["platform"]) echo sprintf("%s: ", Store::getPlatformTextStatic($raw["platform"]));
                                    $platform = $raw["platform"];
                                    echo sprintf("%s %s,&nbsp;", $raw['total'], ($raw["is_active"] == Store::ACTIVE_YES ? ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'authorized') : ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'waiting_authorize')));
                                ?>
                            <?php endforeach;?>
                        </div>
                        <div style="font-size: 12px; height: 20px; vertical-align: middle; padding-top: 10px;">3.
                            <?php echo CHtml::link(CHtml::encode(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'create_more_store')), array("/store/create"), array());?>&nbsp;<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'or');?>&nbsp;
                            <?php echo CHtml::link(CHtml::encode(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'manage_store')), array("/store"), array());?>
                        </div>
                        <div style="font-size: 12px; height: 20px; vertical-align: middle; padding-top: 10px;">4.
                            <?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'platform_dashboard');?>:&nbsp;
                            <?php echo CHtml::link(CHtml::encode('eBay'), array("/ebay/ebay"), array());?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="position: relative; float: right;">
                    <a style="color: #3b5998; font-size: 11px; line-height: 38px; position: relative; margin-right: 10px; padding-right: 5px;" href="">See All</a>
                </div>
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; text-transform: uppercase; line-height: 38px; position: relative;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'listing_status_index');?></h1>
                </div>
            </div>
            <div class="clearfix" style="border-top: 1px solid transparent;">
                <div style="width: 100%; padding: 0px; margin: 0px;">
                    <div class="lfloat">
                        <div style="background-image: url(/themes/facebook/images/201410080952.jpg); background-repeat: no-repeat; background-size: 1000%; background-position: -580px -607px; height: 100px; width: 100px;">&nbsp;</div>
                    </div>
                    <div class="lfloat">
                        <div style="font-size: 12px; height: 20px; vertical-align: middle; padding-top: 10px;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'function_coming_soon');?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="position: relative; float: right;">
                    <a style="color: #3b5998; font-size: 11px; line-height: 38px; position: relative; margin-right: 10px; padding-right: 5px;" href="">See All</a>
                </div>
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; text-transform: uppercase; line-height: 38px; position: relative;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'notification_status');?></h1>
                </div>
            </div>
            <div class="clearfix" style="border-top: 1px solid transparent;">
                <div style="width: 100%; padding: 0px; margin: 0px;">
                    <div class="lfloat">
                        <div style="background-image: url(/themes/facebook/images/201410080952.jpg); background-repeat: no-repeat; background-size: 1000%; background-position: -320px -77px; height: 100px; width: 100px;">&nbsp;</div>
                    </div>
                    <div class="lfloat">
                        <div style="font-size: 12px; height: 20px; vertical-align: middle; padding-top: 10px;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'function_coming_soon');?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
</script>
