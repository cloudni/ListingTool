<?php
/* @var $this AdcampaignController */

$this->breadcrumbs=array(
	'AD Campaign',
);
?>
<h1>AD Campaign</h1>

<table>
    <thead>
        <th>ID</th>
        <th>Name</th>
        <th>Company</th>
        <th>Status</th>
        <th>Deleted</th>
        <th>Budget</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Action</th>
    </thead>
    <tbody>
    <?php $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$dataProvider,
        'itemView'=>'_view',
    )); ?>
    </tbody>
</table>
