<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/4/22
 * Time: 22:14
 */

/* @var $this ADGroupController */
/* @var $model ADGroup */
/* @var $performances array */

$this->breadcrumbs=array(
    'Marketing'=>array("/marketing/home"),
    'Advertisement'=>array("/marketing/advertisement/home"),
    'AD Campaign'=>array('/marketing/advertisement/adcampaign'),
    'AD Group'=>array('index'),
    $model->name=>array('view', "id"=>$model->id),
    'Geo Graphic Report'
);

$this->menu=array(
    array('label'=>'AD Group Index', 'url'=>array('index')),
    array('label'=>'AD Group Create', 'url'=>array('create')),
);
?>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 12px; line-height: 38px; position: relative;">Geo Graphic Report for AD Group: <?php echo $model->name;?></h1>
                </div>
            </div>
            <div>
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <thead>
                    <th align="left" style="padding-left: 12px; ">Country/Territory</th>
                    <th align="left">State/Province</th>
                    <th align="left">Location Type</th>
                    <th align="left">Device</th>
                    <th align="right">Clicks</th>
                    <th align="right">Impr.</th>
                    <th align="right">CTR</th>
                    <th align="right">Avg. CPC</th>
                    <th align="right">Cost</th>
                    <th align="right">Avg. POS</th>
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
                                <td align="right">&nbsp;</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>