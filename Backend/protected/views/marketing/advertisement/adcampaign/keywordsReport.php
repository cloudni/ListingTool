<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/6/18
 * Time: 19:45
 */

$this->breadcrumbs=array(
    'Keywords report'
);
?>

<div style="clear: both; width: 100%; position: relative; top: 15px;">
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <thead>
        <th align="left" style="padding-left: 12px; ">Keywords</th>
        <th align="left">Status</th>
        <th align="right">Clicks</th>
        <th align="right">Impressions</th>
        <th align="right">CTR</th>
        <th align="right">Avg. CPC</th>
        <th align="right">Cost</th>
        </thead>
        <tbody>
        <?php if(isset($keywords) && !empty($keywords)):?>
            <?php foreach($keywords as $keyword):?>
                <tr>
                    <td align="left" style="padding-left: 12px; "><?php echo $keyword['keyword_text'];?></td>
                    <td align="left"><?php echo $keyword['status'];?></td>
                    <td align="right"><?php echo $keyword['clicks'];?></td>
                    <td align="right"><?php echo $keyword['impressions'];?></td>
                    <td align="right"><?php echo $keyword['impressions'] ? sprintf("%1\$.2f%%", $keyword['clicks'] / $keyword['impressions'] * 100) : "&nbsp;";?></td>
                    <td align="right"><?php echo $keyword['clicks'] ? sprintf("$%1\$.2f", $keyword['cost'] / $keyword['clicks']) : "&nbsp;";?></td>
                    <td align="right"><?php echo $keyword['cost'] ? sprintf("$%1\$.2f", $keyword['cost']) : "&nbsp";?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif;?>
        </tbody>
    </table>
</div>