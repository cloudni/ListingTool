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
    'Marketing'=>array("/marketing/home"),
    'Advertisement'=>array("/marketing/advertisement/home"),
    'AD Campaign'=>array('/marketing/advertisement/adcampaign'),
    'AD Group'=>array('index'),
    $model->name=>array('view', "id"=>$model->id),
    'Automatic Placement Report'
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
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 12px; line-height: 38px; position: relative;">Automatic Placement Report for AD Group: <?php echo $model->name;?></h1>
                </div>
            </div>
            <div>
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <thead>
                    <th align="left" style="padding-left: 12px; ">Automatic Placement</th>
                    <th align="left">URL</th>
                    <th align="right">Clicks</th>
                    <th align="right">Impr.</th>
                    <th align="right">CTR</th>
                    <th align="right">Avg. CPC</th>
                    <th align="right">Cost</th>
                    <th align="right">Avg. POS</th>
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