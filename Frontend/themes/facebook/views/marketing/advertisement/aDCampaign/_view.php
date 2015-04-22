<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/4/13
 * Time: 22:46
 */

/* @var $this ADCampaignController */
/* @var $data array */
?>
<tr>
    <td align="left"><input type="checkbox" /></td>
    <td align="left"><img src="/themes/facebook/images/disabled.png" /></td>
    <td align="right"><a href="<?php echo Yii::app()->createAbsoluteUrl("marketing/advertisement/ADCampaign/view", array('id'=>$data['id']));?>"><?php echo $data['name'];?></a></td>
    <td align="right"><?php echo sprintf("$%1\$.2f", $data['budget']);?></td>
    <td align="right"><?php echo ADCampaign::getStatusText($data['status']);?></td>
    <td align="right">0</td>
    <td align="right">0</td>
    <td align="right">0%</td>
    <td align="right">$0.00</td>
    <td align="right">$0.00</td>
    <td align="right">0</td>
</tr>