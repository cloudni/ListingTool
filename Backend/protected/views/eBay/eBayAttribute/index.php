<?php
/* @var $this EbayattributeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'eBay Attributes',
);

$this->menu=array(
	array('label'=>'Create eBayAttribute', 'url'=>array('create')),
	array('label'=>'Manage eBayAttribute', 'url'=>array('admin')),
);
?>

<h1>eBay Attributes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
