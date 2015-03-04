<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-11-28
 * Time: 11:10pm
 */

$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'ebay_listing')=>array('index'),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'bulk_update_ebay_listing')=>array('bulkUpdate'),
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'bulk_update_verify_result')
);

Yii::app()->getClientScript()->registerCoreScript('jquery');
?>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <h1 style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative;"><?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'bulk_update_verify_result');?></h1>
                </div>
            </div>
            <div style="display: block;">
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'bulk_update_form',
                    // Please note: When you enable ajax validation, make sure the corresponding
                    // controller action is handling ajax validation correctly.
                    // There is a call to performAjaxValidation() commented in generated controller code.
                    // See class documentation of CActiveForm for details on this.
                    'enableAjaxValidation'=>false,
                    'htmlOptions'=>array(
                        'onsubmit'=>' return validate()',
                    ),
                    'action'=>$this->createAbsoluteUrl('/eBay/eBayListing/bulkUpdateSubmit'),
                )); ?>
                <div>
                    <h3><?php echo CHtml::encode(sprintf(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'total_verified_ebay_items'), $result['Total']));?></h3>
                    <hr />
                    <?php if(!empty($result['Success'])):?>
                        <div class="MessageBox MessageBoxSuccess">
                            <h3><?php echo CHtml::encode(sprintf(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'bulk_update_success_count'), count($result['Success'])));?></h3>
                            <?php foreach($result['Success'] as $key => $success):?>
                                <?php echo CHtml::label(sprintf(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'bulk_update_result_row'), $key, $success['Status']), NULL);?><br />
                                <?php foreach($success['Msg'] as $msg):?>
                                    <?php echo CHtml::label($msg, NULL, array('style'=>'padding-left: 7px;'));?><br />
                                <?php endforeach;?>
                                <br />
                            <?php endforeach;?>
                        </div>
                    <?php endif;?>
                    <?php if(!empty($result['Warning'])):?>
                        <div class="MessageBox MessageBoxError">
                            <h3><?php echo CHtml::encode(sprintf(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'bulk_update_success_count'), count($result['Warning'])));?></h3>
                            <?php foreach($result['Warning'] as $key => $warning):?>
                                <?php echo CHtml::label(sprintf(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'bulk_update_result_row'), $key, $warning['Status']), NULL);?><br />
                                <?php foreach($warning['Msg'] as $msg):?>
                                    <?php echo CHtml::label($msg, NULL, array('style'=>'padding-left: 7px;'));?><br />
                                <?php endforeach;?>
                                <br />
                            <?php endforeach;?>
                        </div>
                    <?php endif;?>
                    <?php if(!empty($result['Failure'])):?>
                        <div class="MessageBox MessageBoxError">
                            <h3><?php echo CHtml::encode(sprintf(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'bulk_update_success_count'), count($result['Failure'])));?></h3>
                            <?php foreach($result['Failure'] as $key => $failure):?>
                                <?php echo CHtml::label(sprintf(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'bulk_update_result_row'), $key, $failure['Status']), NULL);?><br />
                                <?php foreach($failure['Msg'] as $msg):?>
                                    <?php echo CHtml::label($msg, NULL, array('style'=>'padding-left: 7px;'));?><br />
                                <?php endforeach;?>
                                <br />
                            <?php endforeach;?>
                        </div>
                    <?php endif;?>
                    <?php if(!empty($result['UnknownStatus'])):?>
                        <div class="MessageBox MessageBoxInfo">
                            <h3><?php echo CHtml::encode(sprintf(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'bulk_update_success_count'), count($result['UnknownStatus'])));?></h3>
                            <?php echo CHtml::encode(implode(", ", array_keys($result['UnknownStatus'])));?>
                        </div>
                    <?php endif;?>
                </div>
                <hr />
                <?php $result['params']['Success'] = array_keys($result['Success']); $result['params']['Warning'] = array_keys($result['Warning']); echo CHtml::hiddenField('params', json_encode($result['params']));?>
                <?php echo CHtml::checkBox('submitwarning', false, array('onChange'=>'updateSubmitButton(this);'));?><?php echo CHtml::label(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'question_still_submit_warning_items'), NULL);?><br />
                <?php echo CHtml::submitButton(ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'submit'), array('id'=>'form_submit', 'disabled'=>(empty($result['Success']) ? "disabled" : ""))); ?>&nbsp;<?php /*echo CHtml::label('Click submit button to commit update to eBay with succeeded listing(s).', NULL);*/?>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    var hasWarning = <?php echo empty($result['Warning'])? 'false' : 'true';?>;
    var hasSuccess = <?php echo empty($result['Success'])? 'false' : 'true';?>;

    function updateSubmitButton(obj)
    {
        if($(obj).attr('checked') == 'checked')
        {
            if(hasWarning || hasSuccess) $("#form_submit").removeAttr('disabled');
        }
        else
        {
            if(!hasSuccess) $("#form_submit").attr('disabled',"true");
        }
    }

    function validate()
    {
        if($("#submitwarning").attr('checked') == 'checked')
        {
            return confirm('<?php echo ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'question_still_submit_warning_items_confirm');?>')
        }

        return true;
    }
</script>