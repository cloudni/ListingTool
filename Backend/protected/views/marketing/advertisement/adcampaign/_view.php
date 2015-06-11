<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/5/26
 * Time: 13:51
 */
?>

<tr>
    <td><?php echo CHtml::link($data->id, Yii::app()->createAbsoluteUrl("marketing/advertisement/adcampaign/view", array("id"=>$data->id)), array());?></td>
    <td><?php echo CHtml::link($data->name, Yii::app()->createAbsoluteUrl("marketing/advertisement/adcampaign/view", array("id"=>$data->id)), array());?></td>
    <td><?php echo Company::model()->findByPk($data->company_id)->name;?></td>
    <td><?php echo ADCampaign::getStatusText($data->status);?></td>
    <td><?php echo $data->is_delete ? 'Yes' : 'No';?></td>
    <td><?php echo sprintf("$%1\$.2f", $data->budget);?></td>
    <td><?php echo date("Y/m/d", $data->start_datetime);?></td>
    <td><?php echo $data->end_datetime ? date("Y/m/d", $data->end_datetime) : '';?></td>
    <td>
        <?php echo CHtml::link("View", Yii::app()->createAbsoluteUrl("marketing/advertisement/adcampaign/view", array("id"=>$data->id)), array());?>&nbsp;|&nbsp;
        <?php echo CHtml::link("Update", Yii::app()->createAbsoluteUrl("marketing/advertisement/adcampaign/update", array("id"=>$data->id)), array());?>
    </td>
</tr>