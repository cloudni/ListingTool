<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/6/16
 * Time: 22:03
 */

/* @var $this ADCampaignController */
/* @var $model ADCampaign */
/* @var $placements array */

$this->breadcrumbs=array(
    'Automatic placement report'
);
?>

<div style="clear: both; width: 100%; position: relative; top: 15px;">
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <thead>
        <th align="left" style="padding-left: 12px; ">Automatic placement</th>
        <th align="left">URL</th>
        <th align="right">Clicks</th>
        <th align="right">Impressions</th>
        <th align="right">CTR</th>
        <th align="right">Avg. CPC</th>
        <th align="right">Cost</th>
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