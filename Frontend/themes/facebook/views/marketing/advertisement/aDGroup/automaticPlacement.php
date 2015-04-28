<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/4/22
 * Time: 20:16
 */

/* @var $this ADGroupController */
/* @var $model ADGroup */
/* @var $placements array */

$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'menu_marketing')=>array("/marketing/home"),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'display_advertisement')=>array("/marketing/advertisement/home"),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_campaign')=>array('/marketing/advertisement/ADCampaign/index'),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_group')=>array('index'),
    $model->name=>array('view', "id"=>$model->id),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'automatic_placement_report')
);

$this->menu=array(
    array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_group_index'), 'url'=>array('index')),
    array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ad_group_create'), 'url'=>array('create')),
);
?>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 12px; line-height: 38px; position: relative;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'automatic_placement_report_for_ad_group');?><?php echo $model->name;?></h1>
                </div>
            </div>
            <div>
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <thead>
                    <th align="left" style="padding-left: 12px; "><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'automatic_placement');?></th>
                    <th align="left"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'url');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'clicks');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'impressions');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'click_through_rate');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'average_cost_per_click');?></th>
                    <th align="right"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'cost');?></th>
                    </thead>
                    <tbody>
                    <?php if(isset($placements) && !empty($placements)):?>
                        <?php foreach($placements as $placement):?>
                            <tr>
                                <td align="left" style="padding-left: 12px; " width="20%"><span title="<?php echo $placement['domain'];?>"><?php echo strlen($placement['domain']) > 20 ? substr($placement['domain'], 0, 20).'...' : $placement['domain'];?></span></td>
                                <td align="left"><span title="<?php echo $placement['domain'];?>"><?php echo strlen($placement['domain']) > 20 ? substr($placement['domain'], 0, 20).'...' : $placement['domain'];?></span></td>
                                <td align="right"><?php echo $placement['clicks'];?></td>
                                <td align="right"><?php echo $placement['impr'];?></td>
                                <td align="right"><?php echo $placement['impr'] ? sprintf("%1\$.2f%%", $placement['clicks'] / $placement['impr'] * 100) : "&nbsp;";?></td>
                                <td align="right"><?php echo $placement['clicks'] ? sprintf("$%1\$.2f", $placement['cost'] / $placement['clicks']) : "&nbsp;";?></td>
                                <td align="right"><?php echo $placement['cost'] ? sprintf("$%1\$.2f", $placement['cost']) : "&nbsp";?></td>
                            </tr>
                            <?php endforeach; ?>
                    <?php endif;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>