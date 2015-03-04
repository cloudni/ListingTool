<?php
/* @var $this EbayattributesetController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'eBay Attribute Sets',
);

$this->menu=array(
	array('label'=>'Create eBayAttributeSet', 'url'=>array('create')),
	//array('label'=>'Manage eBayAttributeSet', 'url'=>array('admin')),
);
?>

<h1>eBay Attribute Sets</h1>

<div>
    <table width="100%" cellspacing="0" cellpadding="0" style="border: 1px solid gray;" >
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Is Active</th>
            <th>Action</th>
        </tr>
        <?php $this->widget('zii.widgets.CListView', array(
            'dataProvider'=>$dataProvider,
            'itemView'=>'_view',
        )); ?>
    </table>
</div>


