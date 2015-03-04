<?php
/* @var $this EbayentitytypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'eBay Entity Types',
);

$this->menu=array(
	array('label'=>'Create eBayEntityType', 'url'=>array('create')),
	array('label'=>'Manage eBayEntityType', 'url'=>array('admin')),
);
?>

<h1>eBay Entity Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
