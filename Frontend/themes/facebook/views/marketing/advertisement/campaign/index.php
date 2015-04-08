<?php
/* @var $this CampaignController */

$this->breadcrumbs=array(
    'Marketing',
    'Advertisement',
	'Campaign',
);

$this->menu=array(
    array('label'=>'Test Campaign #1', 'url'=>array('/marketing/advertisement/campaign/view/id/1')),
    array('label'=>'Test Campaign #2', 'url'=>array('/marketing/advertisement/campaign/view/id/2')),
    array('label'=>'Test Campaign #3', 'url'=>array('/marketing/advertisement/campaign/view/id/3')),
);
?>

<div style="clear: both; width: 100%; position: relative; top: -5px;">
    <div class="borderBlock">
        <div>
            <div style="background: #f6f7f8; border-bottom: 1px solid #e9eaed; font-size: 12px;">
                <div style="height: 36px; color: #9197a3; font-weight: normal;">
                    <input type="button" value="+Campaign" />
                    <select>
                        <option>All</option>
                        <option>All enabled</option>
                        <option selected>All but removed</option>
                    </select>
                    <select>
                        <option>Enable</option>
                        <option>Pause</option>
                        <option>Remove</option>
                        <option>Change Budget</option>
                        <option>Download Report</option>
                    </select>
                    <select>
                        <option>None</option>
                        <option>Time</option>
                        <option>Click Type</option>
                        <option>Device</option>
                        <option>Download Report</option>
                    </select>
                    <select>
                        <option>Customize Columns</option>
                    </select>
                </div>
            </div>
            <div>

            </div>
        </div>
    </div>
</div>