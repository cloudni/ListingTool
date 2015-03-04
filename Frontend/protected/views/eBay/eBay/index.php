<?php
/* @var $this EBayController */

$this->breadcrumbs=array(
	'eBay',
);

$this->menu=array(
    array('label'=>'Manage Listings', 'url'=>array('/eBay/eBayListing')),
	array('label'=>'Bulk Update', 'url'=>array('/eBay/eBayListing/bulkUpdate')),
);
?>
<h1>eBay Dashboard</h1>

<div style="clear: both; width: 100%;">
	<div>
		<table width="100%" cellspacing="0" cellpadding="0" style="border-bottom: 1px solid #e5ecf9;" >
			<thead>
			<tr>
				<th width="100%">Store</th>
			</tr>
			</thead>
			<tbody>
			<?php $this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$dataProvider,
				'itemView'=>'_viewDashboard',
			)); ?>
			</tbody>
		</table>
	</div>
</div>
