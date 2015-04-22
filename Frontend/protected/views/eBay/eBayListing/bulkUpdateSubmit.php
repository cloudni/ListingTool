<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-11-28
 * Time: 11:10pm
 */

$this->breadcrumbs=array(
    'eBay Listings'=>array('index'),
    'Bulk Update'=>array('bulkUpdate'),
    'Bulk Update Verify Result'
);

Yii::app()->getClientScript()->registerCoreScript('jquery');
?>

<div style="padding: 5px 20px;">
    <h1>eBay Listings Bulk Update Verify Result</h1>
    <hr/>
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
        <h3><?php echo CHtml::encode("Total verified: {$result['Total']} listing(s)");?></h3>
        <hr />
        <?php if(!empty($result['Success'])):?>
        <div class="MessageBox MessageBoxSuccess">
            <h3><?php echo CHtml::encode("Succeeded: ".count($result['Success'])." listing(s)");?></h3>
            <?php foreach($result['Success'] as $key => $success):?>
                <?php echo CHtml::label('eBay Listing ID: '.$key.', Status: '.$success['Status'], NULL);?><br />
                <?php foreach($success['Msg'] as $msg):?>
                    <?php echo CHtml::label($msg, NULL, array('style'=>'padding-left: 7px;'));?><br />
                <?php endforeach;?>
                <br />
            <?php endforeach;?>
        </div>
        <?php endif;?>
        <?php if(!empty($result['Warning'])):?>
        <div class="MessageBox MessageBoxError">
            <h3><?php echo CHtml::encode("Warining: ".count($result['Warning'])." listing(s)");?></h3>
            <?php foreach($result['Warning'] as $key => $warning):?>
                <?php echo CHtml::label('eBay Listing ID: '.$key.', Status: '.$warning['Status'], NULL);?><br />
                <?php foreach($warning['Msg'] as $msg):?>
                    <?php echo CHtml::label($msg, NULL, array('style'=>'padding-left: 7px;'));?><br />
                <?php endforeach;?>
                <br />
            <?php endforeach;?>
        </div>
        <?php endif;?>
        <?php if(!empty($result['Failure'])):?>
        <div class="MessageBox MessageBoxError">
            <h3><?php echo CHtml::encode("Failure: ".count($result['Failure'])." listing(s)");?></h3>
            <?php foreach($result['Failure'] as $key => $failure):?>
                <?php echo CHtml::label('eBay Listing ID: '.$key.', Status: '.$failure['Status'], NULL);?><br />
                <?php foreach($failure['Msg'] as $msg):?>
                    <?php echo CHtml::label($msg, NULL, array('style'=>'padding-left: 7px;'));?><br />
                <?php endforeach;?>
                <br />
            <?php endforeach;?>
        </div>
        <?php endif;?>
        <?php if(!empty($result['UnknownStatus'])):?>
        <div class="MessageBox MessageBoxInfo">
            <h3><?php echo CHtml::encode("Unknown Status: ".count($result['UnknownStatus'])." listing(s)");?></h3>
            <?php echo CHtml::encode(implode(", ", array_keys($result['UnknownStatus'])));?>
        </div>
        <?php endif;?>
    </div>
    <hr />
    <?php $result['params']['Success'] = array_keys($result['Success']); $result['params']['Warning'] = array_keys($result['Warning']); echo CHtml::hiddenField('params', json_encode($result['params']));?>
    <?php echo CHtml::checkBox('submitwarning', false, array('onChange'=>'updateSubmitButton(this);'));?><?php echo CHtml::label('Still submit warning listing(s) to eBay', NULL);?><br />
    <?php echo CHtml::submitButton('Submit', array('id'=>'form_submit', 'disabled'=>(empty($result['Success']) ? "disabled" : ""))); ?>&nbsp;<?php echo CHtml::label('Click submit button to commit update to eBay with succeeded listing(s).', NULL);?>
    <?php $this->endWidget(); ?>
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
            return confirm('Are you sure still submit warning listing(s) to eBay?')
        }

        return true;
    }
</script>