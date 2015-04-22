<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 2015/3/17
 * Time: 13:56
 */

$this->breadcrumbs=array(
    ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'company_title')=>array('index'),
    $model->name=>array('view','id'=>$model->id),
    'Finance',
);

$this->menu=array(
    array('label'=>ResourceStringTool::getSourceStringByKeyAndLanguage(Yii::app()->language,'company_update_menu'), 'url'=>array('update'/*, 'id'=>$model->id*/)),
    array('label'=>'View', 'url'=>array('index'/*, 'id'=>$model->id*/)),
);
?>

<style>
    table.detail-view th, table.detail-view td
    {
        font-size: 12px;
    }

    .tabTitle{
        border-right: 1px solid #9D9EA0; padding: 0px 15px 0px 15px;
    }

    .tabSelected{
        background-image: url(/themes/facebook/images/p8WLIWfshBr.png);
        background-repeat: no-repeat;
        background-size: auto;
        background-position: -28px -50px;
        bottom: -1px;
        height: 9px;
        left: 35%;
        margin-left: -8px;
        position: absolute;
        width: 17px;
    }
</style>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <div style="color: #4e5665; font-weight: 700; padding-left: 14px; line-height: 38px; position: relative; background-color: #fff;">
                        <span class="tabTitle"><?php echo $model->name; ?></span></span>
                        <a id="transaction_detail_link" onclick="updateFinancePanel('transaction_detail');" class="tabTitle">Transaction Detail<span id="transaction_detail_point_angle" class="tabSelected" style="display: block;"></span></a>
                        <a id="deposit_link" onclick="updateFinancePanel('deposit');" class="tabTitle">Deposit<span id="deposit_point_angle" class="tabSelected" style="left: 49%; display: none;"></span></a>
                        <a id="withdraw_link" onclick="updateFinancePanel('withdraw');" class="tabTitle">Withdraw<span id="withdraw_point_angle" class="tabSelected" style="left: 60%; display: none;"></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="transaction_detail_tab" style="clear: both; width: 100%; position: relative; top: -5px; ">
    <div class="borderBlock">
        <div>
            <div style="display: block; padding: 5px;">
                <div>
                    <span style="font-size: 16px; font-weight: bold;">Account Balance: $1000 USD</span>
                </div>
                <table width="100%" cellspacing="0" cellpadding="0" style="border-bottom: 1px solid #e5ecf9;" >
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th style="text-align: right;">Total</th>
                        <th style="text-align: right;">Fee</th>
                        <th style="text-align: right;">Net</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $this->widget('zii.widgets.CListView', array(
                        'dataProvider'=>new CActiveDataProvider(
                            'eBayListing',
                            array(
                                'criteria' => array
                                (
                                    'condition' => 'company_id=:company_id',
                                    'params' => array(
                                        ':company_id' => Yii::app()->session['user']->company_id),
                                ),
                                'pagination'=>array(
                                    'pageSize'=>25,
                                ),
                            )
                        ),

                        'itemView'=>'_transactionView',
                    )); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="deposit_tab" style="clear: both; width: 100%; position: relative; top: -5px; display: none;">
    <div class="borderBlock">
        <div>
            <div style="display: block; padding: 5px;">
                <select>
                    <option>PayPal</option>
                    <option>Credit Card</option>
                </select>
                <span style="padding: 0px 5px 0px 5px;">$</span><input type="text" size="60" />
                <?php echo CHtml::submitButton('submit', array('class'=>'greenButton')); ?>
            </div>
        </div>
    </div>
</div>

<div id="withdraw_tab" style="clear: both; width: 100%; position: relative; top: -5px; display: none;">
    <div class="borderBlock">
        <div>
            <div style="display: block; padding: 5px;">
                <div>
                    <span>Withdraw to PayPal Account: </span><input type="text" size="60" />
                </div>
                <div style="padding-top: 7px;">
                    <span style="padding: 0px 5px 0px 5px;">$</span><input type="text" size="60" />
                </div>
                <div style="padding-top: 7px;">
                    <textarea style="width: 69%" rows="5"></textarea>
                </div><br />
                <?php echo CHtml::submitButton('submit', array('class'=>'greenButton')); ?>
            </div>
        </div>
    </div>
</div>

<script>
    function updateFinancePanel(id)
    {
        if(id == 'transaction_detail')
        {
            $("#transaction_detail_tab").css("display", "");
            $("#deposit_tab").css("display", "none");
            $("#withdraw_tab").css("display", "none");
            $("#transaction_detail_point_angle").css("display", "");
            $("#deposit_point_angle").css("display", "none");
            $("#withdraw_point_angle").css("display", "none");
        }
        else if(id == 'deposit')
        {
            $("#transaction_detail_tab").css("display", "none");
            $("#deposit_tab").css("display", "");
            $("#withdraw_tab").css("display", "none");
            $("#transaction_detail_point_angle").css("display", "none");
            $("#deposit_point_angle").css("display", "");
            $("#withdraw_point_angle").css("display", "none");
        }
        else if(id == 'withdraw')
        {
            $("#transaction_detail_tab").css("display", "none");
            $("#deposit_tab").css("display", "none");
            $("#withdraw_tab").css("display", "");
            $("#transaction_detail_point_angle").css("display", "none");
            $("#deposit_point_angle").css("display", "none");
            $("#withdraw_point_angle").css("display", "");
        }
    }
</script>