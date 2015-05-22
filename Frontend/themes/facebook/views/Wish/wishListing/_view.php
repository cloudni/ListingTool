<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/5/14
 * Time: 11:18
 */
?>

<tr>
    <td style=" padding-left: 12px;"><?php echo CHtml::link(CHtml::encode($data["id"]), array('view', 'id'=>$data["id"])); ?></td>
    <td><?php echo CHtml::encode($data["storename"]); ?></td>
    <td><a href="<?php echo sprintf(Yii::app()->params['wish']['itemURL'], $data["wish_id"]);?>" target="_blank" title="<?php echo $data["name"];?>"><?php echo CHtml::encode($data["wish_id"]); ?></a></td>
    <td><?php echo CHtml::link(substr($data["name"], 0, 20).'...', CHtml::normalizeUrl(sprintf(Yii::app()->params['wish']['itemURL'], $data["wish_id"])), array('target'=>'_blank', 'title'=>$data['name']));?></td>
    <td><?php echo CHtml::encode($data['parent_sku']); ?></td>
    <td><?php echo CHtml::encode($data['review_status']); ?></td>
    <td style="text-align: right;"><?php echo CHtml::encode($data['number_sold']); ?></td>
    <td><?php echo CHtml::encode($data['note']); ?></td>
    <td>&nbsp;</td>
</tr>