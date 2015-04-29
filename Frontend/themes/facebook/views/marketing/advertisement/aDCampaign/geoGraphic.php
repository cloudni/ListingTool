<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/4/22
 * Time: 22:42
 */

/* @var $this ADCampaignController */
/* @var $model ADCampaign */
/* @var $performances array */

$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'menu_marketing')=>array("/marketing/home"),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'display_advertisement')=>array("/marketing/advertisement/home"),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign')=>array('index'),
    $model->name=>array('view', "id"=>$model->id),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'geo_graphic_report')
);

$this->menu=array(
    array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign_index'), 'url'=>array('index')),
    array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign_create'), 'url'=>array('create')),
);
?>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 12px; line-height: 38px; position: relative;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'geo_report_for_campaign');?><?php echo $model->name;?></h1>
                </div>
            </div>
            <div>
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <thead>
                    <th align="left" style="padding-left: 12px; "><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'geo_country_or_territory');?></th>
                    <th align="left"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'geo_state_or_province');?></th>
                    <th align="left"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'geo_location_type');?></th>
                    <th align="left"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'device');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'clicks');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'impressions');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'click_through_rate');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'average_cost_per_click');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'cost');?></th>
                    </thead>
                    <tbody>
                    <?php if(isset($performances) && !empty($performances)):?>
                        <?php foreach($performances as $performance):?>
                            <tr>
                                <td align="left" style="padding-left: 12px; " width="20%"><span title="<?php echo $performance['effective_destination_url'];?>"><?php echo strlen($performance['effective_destination_url']) > 20 ? substr($performance['effective_destination_url'], 0, 20).'...' : $performance['effective_destination_url'];?></span></td>
                                <td align="left"><?php echo $performance['click_type'];?></td>
                                <td align="left"><?php echo $performance['device'];?></td>
                                <td align="right"><?php echo $performance['clicks'];?></td>
                                <td align="right"><?php echo $performance['impr'];?></td>
                                <td align="right"><?php echo $performance['impr'] ? sprintf("%1\$.2f%%", $performance['clicks'] / $performance['impr'] * 100) : "&nbsp;";?></td>
                                <td align="right"><?php echo $performance['clicks'] ? sprintf("$%1\$.2f", $performance['cost'] / $performance['clicks']) : "&nbsp;";?></td>
                                <td align="right"><?php echo $performance['cost'] ? sprintf("$%1\$.2f", $performance['cost']) : "&nbsp";?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>